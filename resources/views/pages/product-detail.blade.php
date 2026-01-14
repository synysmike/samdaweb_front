@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="grid md:grid-cols-2 gap-8">
            <!-- Product Image -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="w-full h-auto object-cover">
            </div>

            <!-- Product Details -->
            <div>
                <h1 class="text-4xl font-bold mb-4">{{ $product['name'] }}</h1>
                <p class="text-3xl font-bold text-gray-900 mb-6">${{ number_format($product['price'], 2) }}</p>
                
                <div class="mb-6">
                    <h2 class="text-xl font-semibold mb-2">Description</h2>
                    <p class="text-gray-600">{{ $product['description'] }}</p>
                </div>

                <div class="space-y-4">
                    <button class="w-full bg-gray-900 text-white py-3 rounded-md hover:bg-gray-800 transition-colors text-lg font-medium">
                        Add to Cart
                    </button>
                    <button class="w-full bg-white border-2 border-gray-900 text-gray-900 py-3 rounded-md hover:bg-gray-50 transition-colors text-lg font-medium">
                        Add to Wishlist
                    </button>
                </div>

                <!-- Product Info -->
                <div class="mt-8 space-y-4">
                    <div class="border-t pt-4">
                        <h3 class="font-semibold mb-2">Product Information</h3>
                        <ul class="space-y-2 text-gray-600">
                            <li>Free shipping on orders over $50</li>
                            <li>30-day return policy</li>
                            <li>Secure payment processing</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
