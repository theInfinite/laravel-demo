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

Route::get('/','HomeController@showList');

Route::get('/gallery','ImageController@index');
Route::get('/map','MapController@index');
Route::post('/uploadImage','ImageController@uploadImage');
Route::auth();
Route::post('/addUser','UserController@addUser');
Route::post('/addMarker','MapController@addMarker');
Route::post('/getMarkers','MapController@getMarkers');
Route::post('/findList','UserController@findList');
Route::post('/deleteUser','UserController@deleteUser');
Route::get('/home', 'HomeController@index');

Route::get('/user', 'UserController@index');
Route::post('/editUser','UserController@editUser');
Route::post('/uploadFile','ImageController@uploadFile');
Route::post('/closeImage','ImageController@closeImage');