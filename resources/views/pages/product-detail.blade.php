@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="grid md:grid-cols-2 gap-8">
        <!-- Product Image -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden relative">
            <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="w-full h-auto object-cover">
            @php
            $discountPercent = $product['discount'] ?? 25;
            @endphp
            <div class="absolute top-4 left-4 bg-red-500 text-white px-3 py-2 rounded-md text-sm font-bold z-10">
                {{ $discountPercent }}% OFF
            </div>
            <button class="absolute top-4 right-4 w-12 h-12 bg-white rounded-full shadow-lg flex items-center justify-center hover:bg-red-50 transition-colors wishlist-btn" data-product-id="{{ $product['id'] }}" onclick="toggleWishlist({{ $product['id'] }});">
                <svg class="w-6 h-6 text-gray-400 wishlist-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
            </button>
        </div>

        <!-- Product Details -->
        <div>
            <h1 class="text-4xl font-bold mb-4">{{ $product['name'] }}</h1>
            <div class="flex items-center gap-2 mb-4">
                <div class="flex items-center star-rating" data-rating="{{ $product['rating'] ?? 4.5 }}">
                    @php
                    $rating = $product['rating'] ?? 4.5;
                    $fullStars = floor($rating);
                    $hasHalfStar = ($rating - $fullStars) >= 0.5;
                    @endphp
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <=$fullStars)
                        <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" /></svg>
                        @elseif($i == $fullStars + 1 && $hasHalfStar)
                        <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                            <path d="M10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545L10 15l-5.878-3.09 1.123-6.545L.489 6.91l6.572-.955L10 0z" />
                        </svg>
                        @else
                        <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 20 20">
                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                        </svg>
                        @endif
                        @endfor
                </div>
                <span class="text-sm text-gray-600">({{ number_format($rating, 1) }})</span>
            </div>
            @php
            $discountPercent = $product['discount'] ?? 25;
            $originalPrice = $product['price'] / (1 - ($discountPercent / 100));
            @endphp
            <div class="flex items-center gap-3 mb-6">
                <p class="text-2xl text-gray-400 font-medium line-through">${{ number_format($originalPrice, 2) }}</p>
                <p class="text-3xl font-bold text-gray-900">${{ number_format($product['price'], 2) }}</p>
            </div>

            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-2">Description</h2>
                <p class="text-gray-600">{{ $product['description'] }}</p>
            </div>

            <div class="space-y-4">
                <button class="w-full bg-gray-900 text-white py-3 rounded-md hover:bg-gray-800 transition-colors text-lg font-medium">
                    Add to Cart
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