<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\login;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PageController;

Route::get('/', [Dashboard::class, 'index'])->name('dashboard');

Route::get('/login', [login::class, 'showLoginForm'])->name('login');
Route::post('/login', [login::class, 'login']);
Route::post('/logout', [login::class, 'logout'])->name('logout');
Route::post('/api/store-token', [login::class, 'storeToken'])->name('api.store-token');

Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/category/{category}', [ProductController::class, 'category'])->name('category');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

// INFORMATION Pages
Route::get('/contact-us', [PageController::class, 'contactUs'])->name('contact-us');
Route::get('/blog', [PageController::class, 'blog'])->name('blog');
Route::get('/about-us', [PageController::class, 'aboutUs'])->name('about-us');
Route::get('/disclaimer', [PageController::class, 'disclaimer'])->name('disclaimer');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/how-it-works', [PageController::class, 'howItWorks'])->name('how-it-works');
Route::get('/help-center', [PageController::class, 'helpCenter'])->name('help-center');

// BUY Pages
Route::get('/terms-conditions', [PageController::class, 'termsConditions'])->name('terms-conditions');
Route::get('/privacy-policy', [PageController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/return-refund-policy', [PageController::class, 'returnRefundPolicy'])->name('return-refund-policy');
Route::get('/shipping-policy', [PageController::class, 'shippingPolicy'])->name('shipping-policy');
Route::get('/payment-policy', [PageController::class, 'paymentPolicy'])->name('payment-policy');
Route::get('/cookie-policy', [PageController::class, 'cookiePolicy'])->name('cookie-policy');
Route::get('/buyer-protection-policy', [PageController::class, 'buyerProtectionPolicy'])->name('buyer-protection-policy');
Route::get('/intellectual-property-policy', [PageController::class, 'intellectualPropertyPolicy'])->name('intellectual-property-policy');

// SELL Pages
Route::get('/sell-on-begja', [PageController::class, 'sellOnBegja'])->name('sell-on-begja');
Route::get('/seller-agreement', [PageController::class, 'sellerAgreement'])->name('seller-agreement');
Route::get('/fees-commission', [PageController::class, 'feesCommission'])->name('fees-commission');
Route::get('/listing-guidelines', [PageController::class, 'listingGuidelines'])->name('listing-guidelines');
