<?php

use App\Http\Controllers\BicycleController;
use App\Http\Controllers\TintucController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('Bicycles', BicycleController::class);
Route::get('/search', [BicycleController::class, 'search'])->name('search');
