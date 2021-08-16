<?php

use App\Http\Controllers\SpaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutoTestController;

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

// Route::view('/{any}', 'home')
//     ->where('any', '.*');

Route::get('/autotest',[AutoTestController::class, 'index']);
Route::view('/{any}', 'spa')->where('any', '.*');
