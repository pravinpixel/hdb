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

Route::post('check-out', [HomeController::class, 'CheckOut'])->name('check.out');

Route::post('item-delete', [HomeController::class, 'ItemDelete'])->name('item.delete');

Route::post('item-unset', [HomeController::class, 'ItemUnset'])->name('item.unset');

Route::get('check-in-success', [HomeController::class, 'CheckInSuccess'])->name('check.in.success');

Route::get('check-out-success', [HomeController::class, 'CheckOutSuccess'])->name('check.out.success');
Route::post('check-out-clear', [HomeController::class, 'CheckOutClear'])->name('check.out.clear');


