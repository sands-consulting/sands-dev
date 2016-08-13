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

Route::get('/', function () {
    if (app('auth')->user()) {
        return view('dashboard');
    }
    return view('welcome');
});

Route::get('login', 'OauthController@redirectToProvider');
Route::get('logout', function () {
    app('auth')->logout();
    return redirect('/');
});

view()->share('__table', 'dashboard');
Route::get('oauth/github/callback', 'OauthController@handleProviderCallback');

Route::controller('/dashboard', 'DashboardController');
Route::controller('/applications', 'ApplicationsController');
