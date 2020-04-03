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
Auth::routes();
Route::get('/', fn () => view('welcome'));
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'threads'], function () {
  Route::name('threads.')->group(function () {
      Route::resource('', 'ThreadController')->parameters(['' => 'thread'])->except(['index', 'show'])->middleware('auth');
      Route::get('', 'ThreadController@index')->name('index');
      Route::get('{channel}/{thread}', 'ThreadController@show')->name('show');
  });
  Route::post('{channel}/{thread}/replies', 'ReplyController@store')->name('replies.store')->middleware('auth');
  Route::get('{channel}', 'ThreadController@index');
});

Route::post('replies/{reply}/favorites', 'FavoriteController@store')->name('favorite.store')->middleware('auth');
Route::get('profiles/{user}', 'ProfileController@show')->name('user.profile');
Route::delete('replies/{reply}', 'ReplyController@destroy')->middleware('auth');
