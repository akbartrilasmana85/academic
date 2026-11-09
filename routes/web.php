<?php

use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MataKuliahController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin/mahasiswa');

// semua master data dikelompokkan di prefix /admin dan nama route diawali admin.
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('mahasiswa', MahasiswaController::class);
    Route::resource('matakuliah', MataKuliahController::class);
});
