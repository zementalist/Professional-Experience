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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/note', 'noteController@index')->name('note');
Route::get('/games', 'gameController@index')->name('games');
Route::get('/ball', 'gameController@ball')->name('ball');
Route::get('/tictactoe', 'gameController@tictactoe')->name('tictactoe');
Route::get('/calculator', 'HomeController@calculator')->name('calculator');


Route::post('/note/store', 'noteController@store');
Route::delete("/note/delete", 'noteController@delete');