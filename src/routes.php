<?php

/*
|--------------------------------------------------------------------------
| PINGPONG :: Video Contest Application :: Routes
|--------------------------------------------------------------------------
|
*/
Route::get('/', 'AppController@index');
Route::get('/upload', 'AppController@getUpload');
Route::get('/register', 'AppController@getRegister');
Route::get('/gallery', 'AppController@gallery');
Route::get('/leaderboard', 'AppController@leaderboard');
Route::get('/logout', 'AppController@logout');

/* Terms and Condition */
Route::get('/terms-and-condition', 'AppController@terms');
Route::get('/prize', 'AppController@prize');

Route::get('/video/{slug}', 'AppController@singleVideo');
Route::get('/v/{id}', 'AppController@v');

/* Twitter Action */
Route::group(array('prefix'=>'twitter'), function(){

	Route::get('redirect', 'AppController@redirect');
	Route::get('callback', 'AppController@callback');

	/* Post CSRF */
	Route::group(array('before'=>'csrf'),function(){

		Route::post('share/{id}', 'AppController@postTweet');

	});

});

/* POST  */
Route::group(array('before'=>'csrf'), function(){

	Route::post('upload', 'AppController@postUpload');
	Route::post('register', 'AppController@postRegister');
	Route::post('vote/{id}', 'AppController@postVote');

});

/* Error page : 404 */	
App::missing(function()
{
	return View::make('Videocontest::404');
});