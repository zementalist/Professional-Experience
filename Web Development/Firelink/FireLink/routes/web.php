<?php
use App\User;
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
$user = User::find(1);

Auth::login($user);
Auth::routes();

Route::get('', 'HomeController@index')->name('home');
Route::post('/files', 'UploadController@upload');
Route::get('/files/{id}', 'UploadController@show')->name('files');
Route::get('/contact', 'MessageController@index')->name('contact');

Route::delete('files/{id}', 'UploadController@destroy')->name('files');

Route::get('upload/{type}', array('as' => 'upload', 'uses' => 'UploadController@index'));
Route::post('/contact', 'MessageController@store');
Route::get('/owner/control', 'AccessController@index')->name('owner');
Route::post('/owner/control/find/file', 'AccessController@findFile');
Route::post('/owner/control/del/file', 'AccessController@destroyFile');
Route::post('/owner/control/find/mail', 'AccessController@findMail');
Route::post('/owner/control/find/mail/seen', 'AccessController@seen');
Route::post('/owner/control/del/mail', 'AccessController@destroyMail');
Route::post('/uploadProgress', 'UploadController@progress');