<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('/sounds/upload', 'SoundController@upload');
Route::get('/sounds', 'SoundController@index');
Route::delete('/sounds/{id}', 'SoundController@remove');

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
