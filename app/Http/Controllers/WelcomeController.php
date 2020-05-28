<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

define('TOTAL_RESULTS', 5);

class WelcomeController extends Controller {

    public function index() {
        $last_reviews = $this->getLastReviews();
        $most_valued_movies = $this->getMostValuedMovies();
        $users_with_most_reviews = $this->getUsersWithMoreReviews();

        return view('welcome')
                        ->with('last_reviews', $last_reviews)
                        ->with('most_valued_movies', $most_valued_movies)
                        ->with('users_with_most_reviews', $users_with_most_reviews);
    }

    /**
     * Recupera de la base de dades les cinc útlimes crítiques
     * 
     * @return type
     */
    public function getLastReviews() {
        return DB::table('reviews')
                        ->orderByRaw('created_at DESC')
                        ->take(TOTAL_RESULTS)
                        ->get();
    }

    /**
     * Recupera las cinc películes millor valorades
     * 
     * @return type
     */
    public function getMostValuedMovies() {
        return DB::select('
            SELECT movie_id, count(id) AS total_reviews, ROUND(AVG(note), 1) AS note
            FROM reviews
            GROUP BY movie_id
            ORDER BY note DESC, total_reviews DESC
            LIMIT ' . TOTAL_RESULTS);
    }

    /**
     * Retorna els cinc usuaris amb més crítiques
     * 
     * @return type
     */
    public function getUsersWithMoreReviews() {

        return DB::select('
            SELECT users.id, users.name, users.image, COUNT(reviews.id) AS total_reviews
            FROM reviews
            INNER JOIN users on reviews.user_id = users.id 
            GROUP BY users.id
            LIMIT ' . TOTAL_RESULTS);
    }

}
