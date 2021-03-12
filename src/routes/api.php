<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParserController;
use App\Http\Controllers\ApiController;


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
Route::group(['middleware' => 'throttle:500:1'], function () {
    Route::get('/domains',
        [ApiController::class, 'getDomains']
    )->name('get_domains');

    Route::get('/stat',
        [ApiController::class, 'getMetrics']
    )->name('get_logos');
});

Route::group(['middleware' => 'throttle:60:1'], function () {
    Route::get('/logos/{domain}',
        [ApiController::class, 'findLogos']
    )->name('get_logos');
});











