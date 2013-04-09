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

Route::get('welcome', array('as' => 'login', 'uses' => 'AuthController@welcome'));

Route::get('login', array('as' => 'loginRedirect', 'uses' => 'AuthController@login'));

Route::get('auth/callback', array('as' => 'twitterCallback', 'uses' => 'AuthController@callback'));

Route::get('private', array('as' => 'private', 'uses' => 'AuthController@sitePrivate'));

Route::filter('authRequired', function()
{
	if (!Session::has('user'))
	{
		return Redirect::route('login');
	}
});

Route::group(array('before' => 'authRequired'), function()
{
	Route::get('/', array('as' => 'home', 'uses' => 'ThreadsController@threadsList'));

	// Threads
	Route::model('thread', 'Thread');

	Route::get('discussion/new', array('as' => 'startDiscussion', 'uses' => 'ThreadsController@createThreadForm'));
	Route::post('discussion/new', array('as' => 'startDiscussionSubmit', 'uses' => 'ThreadsController@createThread'));
	Route::get('discussion/{thread}', array('as' => 'viewDiscussion', 'uses' => 'ThreadsController@threadView'));

	Route::post('discussion/{thread}/reply', array('as' => 'replyToDiscussion', 'uses' => 'ThreadsController@replyToThread'));

	Route::get('logout', array('as' => 'logout', 'uses' => 'AuthController@logout'));

	Route::Get('settings', array('as' => 'settings', 'uses' => 'SettingsController@settings'));
});