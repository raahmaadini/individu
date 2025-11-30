<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MemberApiController;




Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/members', function () {
        return view('members.index');
    })->name('members.index');

    /**
     * PROFILE
     */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /**
     * PRODUCT PAGE (ADMIN & OWNER boleh lihat)
     */
    Route::get('/products', [ProductController::class, 'index'])
        ->name('products.index');

  

    /**
     * PRODUCT CRUD (ADMIN ONLY)
     */
    Route::middleware('role:admin')->group(function () {
        Route::get('/products/create', [ProductController::class, 'create'])
            ->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])
            ->name('products.store');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])
            ->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])
            ->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])
            ->name('products.destroy');
    });

    /**
     * OWNER ONLY — REPORT
     */
    Route::middleware('role:owner')->group(function () {
        Route::get('/report/products', [ReportController::class, 'products'])
            ->name('reports.products');
    });

});

require __DIR__.'/auth.php';
