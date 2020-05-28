<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class SearchController extends Controller {

    /**
     * Retorna los resultados de la búsqueda
     * 
     * @param Request $request
     */
    public function index(Request $request) {

        //Guardamos todos los resultados del request
        $entrada = $request->all();

        //Cogemos sólo lo incluido en search y buscamos en la API
        $moviesJson = $this->searchInApi($entrada['search'], $entrada['page']);

        return view('search')
                        //Variables de la query
                        ->with('search', $entrada['search'])
                        ->with('page', $moviesJson->page)
                        ->with('total_results', $moviesJson->total_results)
                        ->with('total_pages', $moviesJson->total_pages)
                        ->with('results', $moviesJson->results);
    }

    /**
     * Retorna los links para el paginador
     * 
     * @param type $search
     * @param type $page
     */
    public static function returnPageView($token, $search, $page) {
        return "/search?_token=" . $token . "&search=" . $search . "&page=" . $page;
    }

    /**
     * Comprueba si la imagen existe en tmdb
     * La web hace cosas raras y a veces desaparecen imágenes
     * TODO: Tal vez le resta tiempo al renderizado. Comprobar si va bien.
     * 
     * @param type $imageName
     * @return boolean
     */
    public static function checkIfImageExists($imageName) {
        $file = 'https://image.tmdb.org/t/p/w500' . $imageName;
        $file_headers = get_headers($file);
        if (!$file_headers 
                || $file_headers[0] == 'HTTP/1.1 404 Not Found' 
                || $file_headers[0] == 'HTTP/1.1 502 Bad Gateway') {
            return false;
        }
        return true;
    }

    /**
     * Busca en la API de THE MOVIE DB: https://www.themoviedb.org
     * 
     * Ejemplo de link de consulta:
     * https://api.themoviedb.org/3/search/movie?api_key=<api-key>&language=es&query=<query>
     * API KEY: 7da7846e6f507299a5297efc606be5f0
     * 
     * Usaremos la libreria Guzzle para tal uso
     * https://styde.net/peticiones-http-con-guzzle-en-laravel-5-1/
     * 
     * Para ello se ha instalado:
     * 
     * composer require guzzlehttp/guzzle
     * composer require symfony/psr-http-message-bridge
     * composer require zendframework/zend-diactoros
     * 
     * @param type $search
     * @param type $page
     */
    public function searchInApi($search, $page) {

        $client = new Client();

        $response = $client->request('GET', 'https://api.themoviedb.org/3/search/movie', [
            'query' => [
                'api_key' => config('app.api_key'),
                'language' => app()->getLocale(),
                'query' => $search,
                'page' => $page
            ]
        ]);

        //Aislamos contenidos del body de la respuesta de la API
        $contents = $response->getBody()->getContents();

        //Nos dará un json que lo decodificamos y retornamos
        $json = json_decode($contents);

        return $json;
    }

}
