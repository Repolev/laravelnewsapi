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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', 'App\Http\Controllers\NewsController@displayNews');
Route::get('/news', 'App\Http\Controllers\NewsController@fetchNews');
Route::get('/news-detail', 'App\Http\Controllers\NewsController@fetchNewsDetail')->name('newsDetail');
Route::post('/sourceId', 'App\Http\Controllers\NewsController@displayNews');
