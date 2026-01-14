@extends('layouts.app')

@section('content')
    <!-- Category Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold mb-2">{{ $categoryName }}</h1>
        <p class="text-gray-600">Browse our collection of {{ strtolower($categoryName) }}</p>
    </div>

    <!-- Products Grid -->
    @if(count($products) > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
            @foreach($products as $product)
                <a href="{{ route('product.show', $product['id']) }}" class="group bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <div class="relative overflow-hidden aspect-square">
                        <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-900 mb-1">{{ $product['name'] }}</h3>
                        <p class="text-gray-600 font-medium">${{ number_format($product['price'], 2) }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <p class="text-gray-600 text-lg">No products found in this category.</p>
        </div>
    @endif
@endsection
