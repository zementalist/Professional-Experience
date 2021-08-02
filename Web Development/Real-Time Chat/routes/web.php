<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'HomeController@index')->name('home');

// Route::group([
//     'middleware' => 'api',
//     'prefix' => 'auth'

// ], function ($router) {
//     Route::get('login', 'LoginController@showLoginForm')->name('login');
//     Route::post('login', 'oginController@login');
//     Route::post('logout', 'LoginController@logout')->name('logout');

//     // Registration Routes...
//     Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
//     Route::post('register', 'RegisterController@register');

//     // Password Reset Routes...
//     Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
//     Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//     Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
//     Route::post('password/reset', 'ResetPasswordController@reset');
// });
Auth::routes();

Route::group([
    'middleware' => 'jwt.verify',
    //'prefix' => 'auth'

], function($router) {
    Route::get('messages', 'ChatController@fetchMessages');
    Route::post('messages', 'ChatController@sendMessage');
});
Route::get('/home', 'HomeController@index')->name('home');
Route::get("/chat", "ChatController@chat")->name('chat');
//Route::get('messages', 'ChatController@fetchMessages');
