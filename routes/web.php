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
Route::get('threads/search', 'SearchController@show');

Route::group(['prefix' => 'threads'], function () {
    Route::get('', 'ThreadController@index')->name('threads');
    Route::name('threads.')->group(function () {
        Route::resource('', 'ThreadController')->parameters(['' => 'thread'])->only(['create', 'edit'])->middleware('auth');
        Route::get('{channel}/{thread}', 'ThreadController@show')->name('show');
        Route::post('', 'ThreadController@store')->name('store')->middleware(['verified', 'auth']);
        Route::delete('{channel}/{thread}', 'ThreadController@destroy')->name('destroy')->middleware('auth');
        Route::patch('{channel}/{thread}', 'ThreadController@update');
    });

  Route::post('{channel}/{thread}/subscriptions', 'SubscriptionController@store')->middleware('auth');
  Route::delete('{channel}/{thread}/subscriptions', 'SubscriptionController@destroy')->middleware('auth');

  Route::get('{channel}/{thread}/replies', 'ReplyController@index');
  Route::post('{channel}/{thread}/replies', 'ReplyController@store')->name('replies.store')->middleware('auth');
  Route::get('{channel}', 'ThreadController@index')->name('thread.index');
});

Route::group(['middleware' => 'auth', 'prefix' => 'replies/{reply}'], function () {
    Route::post('/favorites', 'FavoriteController@store');
    Route::delete('/favorites', 'FavoriteController@destroy');
    Route::post('/best', 'BestReplyController@store')->name('best-replies.store');
    Route::delete('', 'ReplyController@destroy')->name('replies.destroy');
    Route::patch('', 'ReplyController@update');
});

Route::group(['prefix' => 'profiles/{user}'], function () {
    Route::get('', 'ProfileController@show')->name('user.profile');
    Route::get('notifications', 'UserNotificationController@index');
    Route::delete('/notifications/{notification}', 'UserNotificationController@destroy')->middleware('auth');
});

Route::get('api/users', 'Api\UserController@index');
Route::post('api/users/{user}/avatars', 'Api\UserAvatarController@store')->middleware('auth')->name('avatars');

Route::post('locked-threads/{thread}', 'LockThreadController@store')->name('locked-threads.store')->middleware('admin');
Route::delete('locked-threads/{thread}', 'LockThreadController@destroy')->name('locked-threads.destroy')->middleware('admin');
