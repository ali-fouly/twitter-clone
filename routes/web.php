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

Route::get('/users/search/{user}', 'UserController@search');
Route::post('/users/follow', 'UserController@follow');

Route::post('/tweets/store', 'TweetController@store');
Route::post('/tweets/like', 'TweetController@like');
Route::post('/tweets/delete', 'TweetController@destroy');

Route::get('/newsfeed', 'FeedController@newsFeed');
Route::get('/activityfeed', 'FeedController@activityFeed');

Route::get('/home', 'HomeController@index')->name('home');


