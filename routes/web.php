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

Route::get('/add-survivor', function () {
    return view('add-survivor');
});
Route::get('/update-location', function () {
    return view('update-location');
});
Route::get('/list-robots', function () {
    return view('list-robots');
});
Route::get('/list-survivors', function () {
    return view('list-survivors');
});
