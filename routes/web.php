<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TradesController;

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

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/trades', [TradesController::class, 'all'])->middleware(['auth'])->name('trades');
Route::get('/trades/{id}', [TradesController::class, 'detail'])->middleware(['auth'])->name('trades/detail');

require __DIR__.'/auth.php';
