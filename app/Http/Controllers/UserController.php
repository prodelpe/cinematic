<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Review;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {

    /**
     * Mostra les dades d'un usuari i le seves crítiques
     * 
     * @return type
     */
    public function index($user_id) {
        $user = User::findOrFail($user_id);
        $user_reviews = Review::getAllReviewsFromUser($user->id)->paginate(5);
        $number_user_reviews = Review::getNumberOfReviewsByUserId($user->id);
        $user_avg_note = Review::getAverageNoteOfAnUser($user->id);

        $isTheLoggedUser = $this->isTheLoggedUser($user_id);
        
        if($isTheLoggedUser){
            return redirect('/home');
        }

        return view('home')
                        ->with('user', $user)
                        ->with('user_reviews', $user_reviews)
                        ->with('isTheLoggedUser', $isTheLoggedUser)
                        ->with('number_user_reviews', $number_user_reviews)
                        ->with('user_avg_note', $user_avg_note);
    }

    /**
     * Comprovem si l'usuari al que s'ha accedit és el mateix que el que està logat
     * 
     * @param type $user_id
     */
    public function isTheLoggedUser($user_id) {
        $loggedUser = Auth::user();

        if ($user_id == $loggedUser->id) {
            return true;
        }

        return false;
    }

}
