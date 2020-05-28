<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Location;

class MovieController extends Controller {

    public function index($movie_id) {
        $movie = $this->getMovie($movie_id);
        $credits = $this->getCredits($movie_id);
        $avg_note = $this->getAvgNote($movie_id);
        return view('movie')
                        ->with('movie', $movie)
                        ->with('cast', $credits->cast)
                        ->with('crew', $credits->crew)
                        ->with('avg_note', $avg_note);
    }

    /**
     * Retorna los datos de una película
     * https://api.themoviedb.org/3/movie/401123?api_key=7da7846e6f507299a5297efc606be5f0&language=es-ES
     * 
     * @param type $movie_id
     * @return type
     */
    public static function getMovie($movie_id) {
        $client = new Client();

        $response = $client->request('GET', 'https://api.themoviedb.org/3/movie/' . $movie_id, [
            'query' => [
                'api_key' => config('app.api_key'),
                'language' => app()->getLocale()
            ]
        ]);

        $contents = $response->getBody()->getContents();

        $json = json_decode($contents);

        return $json;
    }

    /**
     * Retorna el personal de una película
     * https://api.themoviedb.org/3/movie/89/credits?api_key=7da7846e6f507299a5297efc606be5f0
     * Divide el resultado en cast y crew
     * 
     * @param type $movie_id
     */
    public static function getCredits($movie_id) {
        $client = new Client();

        $response = $client->request('GET', 'https://api.themoviedb.org/3/movie/' . $movie_id . '/credits', [
            'query' => [
                'api_key' => config('app.api_key'),
                'language' => app()->getLocale()
            ]
        ]);

        $contents = $response->getBody()->getContents();

        $json = json_decode($contents);

        return $json;
    }

    /**
     * Retorna la nota mitjana d'una película
     * 
     * @param type $movie_id
     * @return type
     */
    public function getAvgNote($movie_id) {
        $avg_note = DB::table('reviews')
                ->where('movie_id', $movie_id)
                ->avg('note');

        return round($avg_note, 1);
    }

    /**
     * Retorna el número de crítiques d'una película
     * 
     * @param type $movie_id
     */
    public static function getTotalReviewsOfAMovie($movie_id) {
        return DB::table('reviews')
                        ->where('movie_id', $movie_id)
                        ->count();
    }

}
