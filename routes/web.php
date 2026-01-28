<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\login;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellerController;

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

    // Seller Routes
    Route::get('/seller/register-shop', [SellerController::class, 'registerShop'])->name('seller.register-shop');
    Route::get('/api/seller/shop', [SellerController::class, 'getShop'])->name('api.seller.shop');
    Route::post('/api/seller/shop/store', [SellerController::class, 'storeShop'])->name('api.seller.shop.store');
    Route::get('/seller', [SellerController::class, 'index'])->name('seller.index');
    Route::get('/seller/categories', [SellerController::class, 'categories'])->name('seller.categories');
    Route::get('/seller/products', [SellerController::class, 'products'])->name('seller.products');
    Route::get('/seller/shop-profile', [SellerController::class, 'shopProfile'])->name('seller.shop-profile');
    Route::get('/api/seller/categories', [SellerController::class, 'getCategories'])->name('api.seller.categories');
    Route::post('/api/seller/categories/store', [SellerController::class, 'storeCategory'])->name('api.seller.categories.store');
    Route::post('/api/seller/categories/delete', [SellerController::class, 'deleteCategory'])->name('api.seller.categories.delete');
    Route::get('/api/seller/subcategories', [SellerController::class, 'getSubCategories'])->name('api.seller.subcategories');
    Route::post('/api/seller/subcategories/store', [SellerController::class, 'storeSubCategory'])->name('api.seller.subcategories.store');
    Route::post('/api/seller/subcategories/delete', [SellerController::class, 'deleteSubCategory'])->name('api.seller.subcategories.delete');
    Route::get('/api/seller/products', [SellerController::class, 'getProducts'])->name('api.seller.products');
    Route::post('/api/seller/products/store', [SellerController::class, 'storeProduct'])->name('api.seller.products.store');
    Route::post('/api/seller/products/image/store', [SellerController::class, 'storeProductImage'])->name('api.seller.products.image.store');
    Route::post('/api/seller/products/delete', [SellerController::class, 'deleteProduct'])->name('api.seller.products.delete');
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

    // Page Content Management Routes
    Route::get('/page-content/terms-conditions', [App\Http\Controllers\Admin\PageContentController::class, 'editTermsConditions'])->name('page-content.terms-conditions.edit');
    Route::post('/page-content/terms-conditions', [App\Http\Controllers\Admin\PageContentController::class, 'updateTermsConditions'])->name('page-content.terms-conditions.update');
    Route::get('/page-content/seller-agreement', [App\Http\Controllers\Admin\PageContentController::class, 'editSellerAgreement'])->name('page-content.seller-agreement.edit');
    Route::post('/page-content/seller-agreement', [App\Http\Controllers\Admin\PageContentController::class, 'updateSellerAgreement'])->name('page-content.seller-agreement.update');
});
