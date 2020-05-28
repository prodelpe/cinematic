<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Review;
use App\User;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $user = Auth::user();
        $user_reviews = Review::getAllReviewsFromUser($user->id)->paginate(5);
        $number_user_reviews = Review::getNumberOfReviewsByUserId($user->id);
        $user_avg_note = Review::getAverageNoteOfAnUser($user->id);
        $isTheLoggedUser = true; //A la home sempre aniràn usuaris logats

        return view('home')
                        ->with('user', $user)
                        ->with('user_reviews', $user_reviews)
                        ->with('isTheLoggedUser', $isTheLoggedUser)
                        ->with('number_user_reviews', $number_user_reviews)
                        ->with('user_avg_note', $user_avg_note);
    }

    /**
     * Edita dades d'usuari
     * 
     * @param Request $request
     */
    public function update(Request $request, $id) {

        $user = User::findOrFail($id);

        $in = $request->all(); //Guardamos todos los datos editados del usuario en la variable $in

        if ($file = $request->file('image')) {
            $ext = $file->getClientOriginalExtension();
            $name = 'photo-' . $this->getName(8) . '.' . $ext;
            $file->move('images/users', $name);
            $in['image'] = $name;
        }

        $user->update($in);
        return redirect()->action('HomeController@index');
    }

    /**
     * Esborra un usuari de la base de dades
     * 
     * @param type $id
     */
    public function destroy($id) {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect("/");
    }

    /**
     * Generador d'strings random
     * El farem servir per crear un nom d'imatge unic
     * https://stackoverflow.com/questions/4356289/php-random-string-generator
     * 
     * @param type $n
     * @return string
     */
    function getName($n) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }

}
