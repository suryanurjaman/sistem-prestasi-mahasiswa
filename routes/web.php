<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatistikController;
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


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/statistik', [StatistikController::class, 'index'])->name('statistik');


Route::get('/prestasi', [PrestasiController::class, 'index'])->name('prestasi');
Route::get('/prestasi/{id}', [PrestasiController::class, 'show'])->name('prestasi.show');
Route::get('/prestasi/{id}/export-pdf', [PrestasiController::class, 'exportPDF'])->name('prestasi.exportPDF');


Route::view('/faq', 'faq')->name('faq');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
