<?php

Route::get('/', 'HomeController@getIndex');
Route::controller('home', 'HomeController');
Route::controller('admin', 'AdminController');
Route::controller('update', 'UpdateController');

/**
 * API ROUTES
 */
Route::api(['version' => 'v1', 'prefix' => 'api'], function()
{
	Route::get('streamers/all', 'ApiController@showAllStreamers');
	Route::get('streamers/live', 'ApiController@showLiveStreamers');
	Route::get('streamers/livereplay', 'ApiController@showLiveReplayStreamers');
	Route::get('streamers/{names}', 'ApiController@showStreamers')->where('names', '[A-Za-z0-9,_-]+');

	Route::get('teams/all', 'ApiController@showAllTeams');
	Route::get('teams/{names}', 'ApiController@showTeams')->where('names', '[A-Za-z0-9,_-]+');

	Route::get('streams/all', 'ApiController@showAllStreams');
	Route::get('streams/{ids}', 'ApiController@showStreams')->where('ids', '[0-9,]+');

	Route::get('stats/all', 'ApiController@showAllStats');
});
