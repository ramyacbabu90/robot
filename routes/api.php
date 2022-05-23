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

Route::post('list-robot', 'RobotController@listRobots');
Route::post('list-survivors', 'RobotController@listSurvivors');
Route::post('add-survivor', 'RobotController@addSurvivor');
Route::post('update-location', 'RobotController@updateLocation');
Route::get('select-list', 'RobotController@getSurvivorsSelect');

// Route::get('list-robot', [RobotController::class, 'listRobots'])->name('list-robot');
// Route::post('register', 'UserController@register');
// Route::post('register', [UserController::class, 'register'])->name('register');