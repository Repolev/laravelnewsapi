<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/get-news', 'App\Http\Controllers\NewsApiController@displayNews');
Route::get('/get-news-detail/{id}', 'App\Http\Controllers\NewsApiController@getNewsDetail');
Route::post('/sourceId', 'App\Http\Controllers\NewsApiController@displayNews');
Route::post('/get-by-country', 'App\Http\Controllers\NewsApiController@getNewsFromCountry');
Route::post('/like-news', 'App\Http\Controllers\NewsApiController@likeNews');
Route::post('/dislike-news', 'App\Http\Controllers\NewsApiController@dislikeNews');
Route::post('get-news-likes-info', 'App\Http\Controllers\NewsApiController@getNewsDetail');
