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
    return view('welcome');
});

Route::get('/changelog', 'ChangelogController@all');
Route::get('/configuration', 'ConfigurationController@all');
Route::get('/server', 'ServerController@all');
Route::get('/players', 'ServerController@all');
Route::get('/tribes', 'ServerController@all');

Route::get('/server/restart', 'ServerController@restart');
Route::get('/server/start', 'ServerController@start');
Route::get('/server/stop', 'ServerController@stop');
Route::get('/server/update', 'ServerController@update');
Route::get('/server/status', 'ServerController@status');

Route::post('/configuration/save/{id_server}/{id_configuration}/{value}', 'ConfigurationController@save')
->where(['id_server' => '[0-9]+', 'id_configuration' => '[0-9]+']);
