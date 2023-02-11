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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'App\Http\Controllers\Api\UserController@login');

Route::group(['middleware' => ["auth:sanctum"]], function(){
    Route::resource('clients', 'App\Http\Controllers\Api\ClientController')->only(['index','store','show','update','destroy']);
    Route::resource('services', 'App\Http\Controllers\Api\ServiceController')->only(['index','store','show','update','destroy']);
    Route::resource('service-clients', 'App\Http\Controllers\Api\ClientServiceController')->only(['index','store','show','update','destroy']);
});