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
Auth::routes(['verify' => true]);
Route::get('/', fn () => view('welcome'));
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'threads'], function () {
  Route::name('threads.')->group(function () {
      Route::resource('', 'ThreadController')->parameters(['' => 'thread'])->except(['index', 'show', 'store'])->middleware('auth');
      Route::get('', 'ThreadController@index')->name('index');
      Route::get('{channel}/{thread}', 'ThreadController@show')->name('show');
      Route::post('', 'ThreadController@store')->name('store')->middleware(['verified', 'auth']);
  });

  Route::post('{channel}/{thread}/subscriptions', 'SubscriptionController@store')->middleware('auth');
  Route::delete('{channel}/{thread}/subscriptions', 'SubscriptionController@destroy')->middleware('auth');

  Route::get('{channel}/{thread}/replies', 'ReplyController@index');
  Route::post('{channel}/{thread}/replies', 'ReplyController@store')->name('replies.store')->middleware('auth');
  Route::get('{channel}', 'ThreadController@index')->name('thread.index');
});

Route::post('replies/{reply}/favorites', 'FavoriteController@store')->middleware('auth');
Route::delete('replies/{reply}/favorites', 'FavoriteController@destroy')->middleware('auth');

Route::group(['prefix' => 'profiles/{user}'], function () {
    Route::get('', 'ProfileController@show')->name('user.profile');
    Route::get('notifications', 'UserNotificationController@index');
    Route::delete('/notifications/{notification}', 'UserNotificationController@destroy')->middleware('auth');
});

Route::delete('replies/{reply}', 'ReplyController@destroy')->middleware('auth');
Route::patch('replies/{reply}', 'ReplyController@update')->middleware('auth');

Route::get('api/users', 'Api\UserController@index');
Route::post('api/users/{user}/avatars', 'Api\UserAvatarController@store')->middleware('auth')->name('avatars');
