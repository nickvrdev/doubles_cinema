<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::match(['get', 'post'], '/ajax/films', [App\Http\Controllers\AjaxController::class, 'listFilms'])->name('list.films');
Route::match(['get', 'post'], '/ajax/timeslots', [App\Http\Controllers\AjaxController::class, 'listTimeslots'])->name('list.timeslots');
Route::match(['get', 'post'], '/ajax/timeslots/available', [App\Http\Controllers\AjaxController::class, 'availableTimeslots'])->name('available.timeslots');

Route::get('/bookings', [App\Http\Controllers\BookingController::class, 'index'])->name('booking.index');
Route::post('/booking/create', [App\Http\Controllers\BookingController::class, 'create'])->name('booking.create');
Route::match(['get', 'post'], '/booking/cancel', [App\Http\Controllers\BookingController::class, 'cancel'])->name('booking.cancel');
