<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\login;

Route::get('/login', [login::class, 'showLoginForm'])->name('login');
Route::post('/login', [login::class, 'login']);
Route::post('/logout', [login::class, 'logout'])->name('logout');
// routes/auth.php or routes/web.php