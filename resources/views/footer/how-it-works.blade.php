@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-4xl font-bold mb-6">How It Works</h1>
    
    <div class="space-y-8">
        <!-- For Buyers -->
        <section class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-semibold mb-6">For Buyers</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-blue-600">1</span>
                    </div>
                    <h3 class="font-semibold mb-2">Browse Products</h3>
                    <p class="text-gray-600 text-sm">Explore our wide selection of products from various categories.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-blue-600">2</span>
                    </div>
                    <h3 class="font-semibold mb-2">Add to Cart</h3>
                    <p class="text-gray-600 text-sm">Select your desired items and add them to your shopping cart.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-blue-600">3</span>
                    </div>
                    <h3 class="font-semibold mb-2">Checkout</h3>
                    <p class="text-gray-600 text-sm">Complete your purchase with secure payment and delivery options.</p>
                </div>
            </div>
        </section>
        
        <!-- For Sellers -->
        <section class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-semibold mb-6">For Sellers</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-green-600">1</span>
                    </div>
                    <h3 class="font-semibold mb-2">Sign Up</h3>
                    <p class="text-gray-600 text-sm">Create your seller account on MyShop platform.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-green-600">2</span>
                    </div>
                    <h3 class="font-semibold mb-2">List Products</h3>
                    <p class="text-gray-600 text-sm">Add your products with descriptions, images, and pricing.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-green-600">3</span>
                    </div>
                    <h3 class="font-semibold mb-2">Receive Orders</h3>
                    <p class="text-gray-600 text-sm">Get notified when customers place orders for your products.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-green-600">4</span>
                    </div>
                    <h3 class="font-semibold mb-2">Get Paid</h3>
                    <p class="text-gray-600 text-sm">Receive payments securely after order fulfillment.</p>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
