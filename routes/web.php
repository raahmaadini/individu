<?php

use App\Http\Controllers\MahasiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('hey', function (): string {
    return "halooooo";
});


Route::prefix('mahasiswa')->group(function (){
    Route::get('/', [MahasiswaController::class, 'index']);
    Route::get('/{id}', [MahasiswaController::class, 'detail']);
});