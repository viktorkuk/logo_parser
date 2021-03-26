<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParserController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\LogoController;


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

Route::middleware('throttle:other')->group(function () {
    Route::get('/domains',
        [ApiController::class, 'getDomains']
    )->name('get_domains');

    Route::get('/stat',
        [ApiController::class, 'getMetrics']
    )->name('get_logos');

    Route::get('/download_logo',
        [LogoController::class, 'download']
    )->name('download_logo');

    Route::get('/download_origin_logo',
        [LogoController::class, 'downloadOrigin']
    )->name('download_origin_logo');
});


Route::middleware('throttle:render')->group(function () {
    //0.5 sec
    Route::get('/get_logo',
        [LogoController::class, 'make']
    )->name('get_logo');

});


Route::middleware('throttle:parsing')->group(function () {
    //3-6 sec
    Route::get('/logos/{domain}',
        [ApiController::class, 'findLogos']
    )->name('get_logos');

});











