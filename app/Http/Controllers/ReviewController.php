<?php

namespace App\Http\Controllers;

use App\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\MovieController;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($movie_id) {
        $movie = MovieController::getMovie($movie_id);
        $credits = MovieController::getCredits($movie_id);

        //Para la review tan sólo mostraremos unos pocos datos
        //10 actores y directores y guionistas
        $reduced_cast = $this->reduceCast($credits->cast);
        $reduced_crew = $this->reduceCrew($credits->crew);
        $reviews = DB::table('reviews')->where('movie_id', $movie_id)->paginate(10);    
        //return $reviews;
        return view('review.index')
                        ->with('reviews', $reviews)
                        ->with('movie', $movie)
                        ->with('cast', $reduced_cast)
                        ->with('crew', $reduced_crew);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($movie_id) {
        $movie = MovieController::getMovie($movie_id);
        $credits = MovieController::getCredits($movie_id);

        $reduced_cast = $this->reduceCast($credits->cast);
        $reduced_crew = $this->reduceCrew($credits->crew);

        return view('review.create')
                        ->with('movie', $movie)
                        ->with('cast', $reduced_cast)
                        ->with('crew', $reduced_crew);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $this->validate($request, [
            //Només una crítica a la magteixa película per usuari
            'movie_id' => Rule::unique('reviews')->where(function ($query) use ($request) {
                        return $query->where('user_id', $request->user_id)->where('movie_id', $request->movie_id);
                    }),
            'note' => 'required|integer',
            'title' => 'required|max:255',
            'review' => 'required'], ['movie_id.*' => __('Ya has hecho una crítica a esta película')]); //TODO: add |min:255

        $in = $request->all();
        Review::create($in);

        return redirect()
                        ->route('movie', $request->movie_id)
                        ->with('message', __('Muchas gracias por tu crítica!!!'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $movie_id
     * @return \Illuminate\Http\Response
     */
    public function edit($movie_id) {

        $review = Review::where('movie_id', $movie_id)->first();

        //Si l'usuari no ha fet una review, redirigim a review.create
        if (is_null($review)) {
            return redirect()
                            ->route('review.create', $movie_id)
                            ->withErrors('no_review', __('No has publicado una crítica de esta película')); //TODO: No mostra l'error
        }

        $movie = MovieController::getMovie($movie_id);
        $credits = MovieController::getCredits($movie_id);

        $reduced_cast = $this->reduceCast($credits->cast);
        $reduced_crew = $this->reduceCrew($credits->crew);

        return view("review.edit")
                        ->with('review', $review)
                        ->with('movie', $movie)
                        ->with('cast', $reduced_cast)
                        ->with('crew', $reduced_crew);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $movie_id
     * @param  \App\Review  $request
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request) {

        $review = Review::findOrFail($id);

        $review->update($request->all());
        
        return redirect()
                        ->route('movie', $request->movie_id)
                        ->with('message', __('Tu crítica ha sido modificada'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $review = Review::findOrFail($id);
        $review->delete();
        return redirect()
                        ->route('movie', $review->movie_id)
                        ->with('message', __('Tu crítica ha sido eliminada'));
    }

    /**
     * Retorna només 10 actors/actrius
     * 
     * @param type $cast
     * @return array
     */
    public function reduceCast($cast) {
        $reduced_cast = [];
        foreach ($cast as $i => $c) {
            array_push($reduced_cast, $c);
            if ($i == 10) {
                break;
            }
        }
        return $reduced_cast;
    }

    /**
     * Retorna només directors i guionistes
     * 
     * @param type $crew
     * @return array
     */
    public function reduceCrew($crew) {
        $reduced_crew = [];
        foreach ($crew as $c) {
            if ($c->job == 'Director' || $c->job == 'Story') {
                array_push($reduced_crew, $c);
            }
        }
        return $reduced_crew;
    }

}
