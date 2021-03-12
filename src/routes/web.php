<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParserController;
use App\Http\Controllers\LogoController;

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

/*Route::get('/', function () {
    return view('welcome');
});*/


Route::get('/',
    [ParserController::class, 'index']
)->name('home');

Route::get('/reset',
    [ParserController::class, 'reset']
)->name('reset');

Route::post('/csv_upload',
    [ParserController::class, 'uploadCsv']
)->name('parser_csv_upload');








