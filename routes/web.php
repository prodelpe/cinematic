<?php

use Illuminate\Support\Facades\Route;

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

Route::get('locale/{locale}', function ($locale){
    Session::put('locale', $locale);
    return redirect()->back();
});

Route::get('/', 'WelcomeController@index')->name('welcome');

Route::get('/search', 'SearchController@index');

Route::get('/movie/{movie_id}', 'MovieController@index')->name('movie');

//Es podria haver fet a partir de Route::resource('/productos', 'ProductosController');
Route::get('/reviews/{movie_id}', 'ReviewController@index')->name('review.index');
Route::get('/review/{movie_id}/create', 'ReviewController@create')->name('review.create')->middleware('auth');
Route::get('/review/{movie_id}/store', 'ReviewController@store')->name('review.store')->middleware('auth');
Route::get('/review/{movie_id}/edit', 'ReviewController@edit')->name('review.edit')->middleware('auth');
Route::get('/review/{movie_id}/update', 'ReviewController@update')->name('review.update')->middleware('auth');
Route::delete('/destroy/{movie_id}', 'ReviewController@destroy')->name('review.destroy')->middleware('auth');

//Route::resource('/home', 'HomeController');
Route::get('/home', 'HomeController@index')->name('home');
Route::put('/home/{id}', 'HomeController@update')->name('home.update')->middleware('auth');
Route::delete('/home/{id}', 'HomeController@destroy')->name('home.destroy')->middleware('auth');

Route::get('/user/{id}', 'UserController@index')->name('user');

Auth::routes();
