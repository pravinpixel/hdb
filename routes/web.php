<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('get-staff', [HomeController::class, 'getStaff'])->name('getStaff');

Route::post('verify-staff', [HomeController::class, 'verifyStaff'])->name('verifyStaff');

Route::post('check-item', [HomeController::class, 'CheckItem'])->name('check.item');
Route::post('check-in', [HomeController::class, 'CheckIn'])->name('check.in');


