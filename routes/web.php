<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TradesController;
use App\Http\Controllers\ScreenerController;

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
Route::get('/trades/detail/{id}', [TradesController::class, 'detail'])->middleware(['auth'])->name('trades/detail');
Route::get('/trades/detail/delete/{id}', [TradesController::class, 'delete'])->middleware(['auth'])->name('trades/delete');


Route::get('/trades/binance', [TradesController::class, 'binance'])->middleware(['auth'])->name('trades/binance');

Route::post('/trades/add', [TradesController::class, 'add'])->middleware(['auth'])->name('trades/add');

Route::get('/screener', [ScreenerController::class, 'index'])->middleware(['auth'])->name('screener');
Route::post('/screener/search', [ScreenerController::class, 'search'])->middleware(['auth'])->name('screener/search');

require __DIR__.'/auth.php';
