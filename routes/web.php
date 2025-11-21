<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return redirect()->route('login');
});

// Tambahan: Route /admin/login (redirect ke login standar)
Route::get('/admin/login', function () {
    return redirect()->route('login');
})->name('admin.login');

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // POS
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');

    // Admin Manajemen
    Route::middleware('role:admin')->group(function () {
        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);
        Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
    });

    // Transaksi
    Route::post('/sale', [SaleController::class, 'store'])->name('sale.store');
    Route::get('/sale/receipt/{id}', [SaleController::class, 'receipt'])->name('sale.receipt');
});


Route::middleware('role:admin')->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('users', UserController::class);  // Baru: Manajemen kasir
    Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
});