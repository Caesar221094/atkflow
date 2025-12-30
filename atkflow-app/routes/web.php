<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\StockReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('products', ProductController::class)->except(['show']);
    Route::get('products/{product}/usage', [ProductController::class, 'usage'])->name('products.usage');
    // Transaksi penerimaan ATK (stok masuk)
    Route::get('transactions/stock-in', [StockMovementController::class, 'index'])->name('transactions.stock-in.index');
    Route::get('transactions/stock-in/create', [StockMovementController::class, 'createGeneral'])->name('transactions.stock-in.create');
    Route::post('transactions/stock-in', [StockMovementController::class, 'storeGeneral'])->name('transactions.stock-in.store');
    Route::get('products/{product}/stock-in', [StockMovementController::class, 'create'])->name('products.stock-in.create');
    Route::post('products/{product}/stock-in', [StockMovementController::class, 'store'])->name('products.stock-in.store');
    // Laporan mutasi stok
    Route::get('reports/stock-movements', [StockReportController::class, 'index'])->name('reports.stock-movements.index');
    Route::resource('orders', OrderController::class)->only(['index', 'create', 'store', 'show']);
});


