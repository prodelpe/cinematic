<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Review extends Model {

    protected $fillable = ["user_id", "movie_id", "title", "note", "review", "spoiler"];
    
    /**
     * Retorna totes les crítiques d'un usuari segons el seu id
     * 
     * @param type $user_id
     * @return type
     */
    public static function getAllReviewsFromUser($user_id){
        $reviews = DB::table('reviews')->where('user_id', $user_id);
        return $reviews;
    }

    /**
     * Retorna el número de reviews donat l'id d'un usuari
     * 
     * @param type $user_id
     * @return type
     */
    public static function getNumberOfReviewsByUserId($user_id) {
        $reviews = DB::table('reviews')->where('user_id', $user_id)->count();
        return $reviews;
    }

    /**
     * Comprova si un usuari ja ha fet una crítica a una película
     * Retorne true si SÍ que l'ha fet
     * False si no ha fet cap crítica
     * 
     * @param type $user_id
     * @param type $movie_id
     * @return type boolean
     */
    public static function hasUserReviewedMovie($user_id, $movie_id) {
        $return = DB::table('reviews')
                ->where('user_id', $user_id)
                ->where('movie_id', $movie_id)
                ->count();

        if ($return > 0) {
            return true;
        }

        return false;
    }

    /**
     * Retorna el número de reviews que te una pelicula
     * 
     * @param type $user_id
     * @param type $movie_id
     * @return type integer
     */
    public static function checkNumberOfReviewsOfAMovie($movie_id) {
        $return = DB::table('reviews')
                ->where('movie_id', $movie_id)
                ->count();

        return $return;
    }

    /**
     * Retorna la nota mitjana d'una pelicula donat el seu id
     * 
     * @param type $movie_id
     */
    public static function getMovieAverageNote($movie_id) {
        $average_note = DB::table('reviews')
                ->where('movie_id', $movie_id)
                ->avg('note');

        return round($average_note, 1);
    }

    /**
     * Retorna la mitjana de les notes realitzades per un usuari
     * 
     * @param type $user_id
     * @return type
     */
    public static function getAverageNoteOfAnUser($user_id) {
        $average_note = DB::table('reviews')
                ->where('user_id', $user_id)
                ->avg('note');

        return round($average_note, 1);
    }

}
