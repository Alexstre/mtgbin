<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::any('/about', function () {
	return View::make('static.about');
});

Route::any('/contact', function () {
	return View::make('static.contact');
});

Route::controller('user', 'HomeController');

Route::get('/', array(
	'as' => 'decks/home',
	'uses' => 'DeckController@index'
));

Route::put('/{slug}', array(
	'as' => 'decks/bump',
	'uses' => 'DeckController@update'
));

Route::get('/{slug}', array(
	'as' => 'decks/slug',
	'uses' => 'DeckController@show',
));

Route::post('/', 
	array(
		'before' => 'csrf',
		'uses' => 'DeckController@store'
));

Route::any('/{slug}/fork', array(
	'as'=>'decks/fork',
	'uses'=>'DeckController@fork'
));



Route::resource('decks', 'DeckController');
