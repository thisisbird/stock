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

Route::get('/crawler', '\App\Http\Controllers\CrawlerController@index');
Route::get('/stock', '\App\Http\Controllers\StockController@index');
Route::get('/kline', '\App\Http\Controllers\StockController@kline');
