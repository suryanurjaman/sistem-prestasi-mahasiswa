<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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


Route::get('/download-berkas/{tipe}/{id}', function ($tipe, $id) {
    $berkas = \App\Models\BerkasPrestasi::where('prestasi_id', $id)->firstOrFail();

    $filePath = match ($tipe) {
        'bukti' => $berkas->bukti_berkas,
        'foto' => $berkas->foto_upp,
        'surat' => $berkas->surat_tugas,
        default => abort(404),
    };

    if (!$filePath || !Storage::disk('public')->exists($filePath)) {
        abort(404, 'File tidak ditemukan.');
    }

    return Storage::disk('public')->download($filePath);
})->name('download.berkas');
