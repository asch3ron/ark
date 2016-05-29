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

Route::get('/configuration/{id_server}', 'ConfigurationController@all')->where(['id_server' => '[0-9]+']);

Route::get('/server/restart/{id_server}', 'ServerController@restart')->where(['id_server' => '[0-9]+']);
Route::get('/server/start/{id_server}', 'ServerController@start')->where(['id_server' => '[0-9]+']);
Route::get('/server/stop/{id_server}', 'ServerController@stop')->where(['id_server' => '[0-9]+']);
Route::get('/server/update/{id_server}', 'ServerController@update')->where(['id_server' => '[0-9]+']);
Route::get('/server/status/{id_server}', 'ServerController@status')->where(['id_server' => '[0-9]+']);

Route::post('/configuration/save/{id_server}/{id_configuration}/{value}', 'ConfigurationController@save')
->where(['id_server' => '[0-9]+', 'id_configuration' => '[0-9]+']);
