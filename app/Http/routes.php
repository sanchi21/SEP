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

Route::get('/', 'WelcomeController@index');

Route::post('hardware','ResourceController@store');

Route::get('hardware','ResourceController@index');
Route::get('hardware/{id}','ResourceController@hardware');
Route::get('software','SoftwareController@index');
Route::post('software','SoftwareController@store');
Route::post('software-edit','SoftwareController@editPage');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
