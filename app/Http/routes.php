<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
 */
Route::get('/', ['middleware' => 'guest', 'uses' => function () {
    return view('welcome');
}]);

Route::get('login/github', 'OauthController@redirectToGithubProvider');
Route::get('login/google', 'OauthController@redirectToGoogleProvider');
Route::get('oauth/github/callback', 'OauthController@handleGithubProviderCallback');
Route::get('oauth/google/callback', 'OauthController@handleGoogleProviderCallback');
Route::get('logout', 'OauthController@logout');

Route::controller('/dashboard', 'DashboardController');
Route::controller('/applications', 'ApplicationsController');
