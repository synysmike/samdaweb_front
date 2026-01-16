<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\login;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\ProductController;

Route::get('/', [Dashboard::class, 'index'])->name('dashboard');

Route::get('/login', [login::class, 'showLoginForm'])->name('login');
Route::post('/login', [login::class, 'login']);
Route::post('/logout', [login::class, 'logout'])->name('logout');

Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/category/{category}', [ProductController::class, 'category'])->name('category');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
// routes/auth.php or routes/web.php
