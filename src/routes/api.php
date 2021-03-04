<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ClickController;
use \App\Http\Controllers\BadDomainController;
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
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/


Route::get('/clicks', [ClickController::class, 'index']);
Route::get('/click/{id}',  [ClickController::class, 'get']);

Route::post('/click',  [ClickController::class, 'create']);
Route::put('/click/{id}', [ClickController::class, 'update']);

Route::delete('/click/{id}', [ClickController::class, 'delete']);


Route::get('/domains', [BadDomainController::class, 'index']);
Route::get('/domain/{id}',  [BadDomainController::class, 'get']);

Route::post('/domain',  [BadDomainController::class, 'create']);
Route::put('/domain/{id}', [BadDomainController::class, 'update']);

Route::delete('/domain/{id}', [BadDomainController::class, 'delete']);



