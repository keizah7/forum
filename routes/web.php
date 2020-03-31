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
      $methodsArray = ['index', 'show'];
      $parameters = ['' => 'thread'];
      $resource = ['', 'ThreadController'];

      Route::resource(...$resource)->parameters($parameters)->except($methodsArray)->middleware('auth');
      Route::resource(...$resource)->parameters($parameters)->only($methodsArray);
  });
  Route::post('{thread}/replies', 'ReplyController@store')->name('replies.store')->middleware('auth');
});

