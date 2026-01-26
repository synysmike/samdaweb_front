<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\login;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;

// Public routes (no authentication required)
Route::get('/login', [login::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [login::class, 'login'])->middleware('guest');
// Store token route - no middleware to allow access during login
Route::post('/api/store-token', [login::class, 'storeToken'])->name('api.store-token');

// Public routes (no authentication required)
Route::get('/', [Dashboard::class, 'index'])->name('dashboard');
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/category/{category}', [ProductController::class, 'category'])->name('category');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

// Protected routes (authentication required)
Route::middleware(['auth.session'])->group(function () {
    Route::post('/logout', [login::class, 'logout'])->name('logout');
    
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
    
    // Shipping Address Routes
    Route::get('/profile/shipping-address', [ProfileController::class, 'shippingAddressIndex'])->name('profile.shipping-address.index');
    Route::post('/profile/shipping-address/store', [ProfileController::class, 'shippingAddressStore'])->name('profile.shipping-address.store');
    Route::post('/profile/shipping-address/{id}/delete', [ProfileController::class, 'shippingAddressDestroy'])->name('profile.shipping-address.destroy');
    Route::match(['GET', 'POST'], '/profile/shipping-address/{id}', [ProfileController::class, 'shippingAddressShow'])->name('profile.shipping-address.show');
    Route::put('/profile/shipping-address/{id}', [ProfileController::class, 'shippingAddressUpdate'])->name('profile.shipping-address.update');
    
    // World data endpoints
    Route::get('/api/world/countries', [ProfileController::class, 'getCountries'])->name('api.world.countries');
    Route::post('/api/world/states', [ProfileController::class, 'getStates'])->name('api.world.states');
    Route::post('/api/world/cities', [ProfileController::class, 'getCities'])->name('api.world.cities');
});

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

// Admin Routes (protected)
Route::prefix('admin')->name('admin.')->middleware('auth.session')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard.index');
    })->name('dashboard');

    // Theme Management Routes
    Route::get('/themes', [App\Http\Controllers\Admin\ThemeController::class, 'index'])->name('themes.index');
    Route::post('/themes', [App\Http\Controllers\Admin\ThemeController::class, 'update'])->name('themes.update');

    // User Management Routes
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('users.show');

    // Product Management Routes
    Route::get('/products', [App\Http\Controllers\Admin\ProductController::class, 'index'])->name('products.index');
});
