<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MeController;
use App\Http\Controllers\PostController;
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

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', ['as' => 'login', 'uses' => 'App\Http\Controllers\Auth\LoginController@login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/me', [MeController::class, 'me']);
    Route::resource('posts', PostController::class);
});
