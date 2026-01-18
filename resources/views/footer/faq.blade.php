@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-4xl font-bold mb-6">Frequently Asked Questions</h1>
    
    <div class="bg-white rounded-lg shadow-md p-8 space-y-6">
        <div x-data="{ open: false }">
            <button @click="open = !open" class="w-full text-left flex justify-between items-center py-4 border-b border-gray-200">
                <span class="font-semibold">How do I place an order?</span>
                <svg class="w-5 h-5 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="open" x-cloak class="py-4 text-gray-600">
                Simply browse our products, add items to your cart, and proceed to checkout. Follow the prompts to complete your purchase.
            </div>
        </div>
        
        <div x-data="{ open: false }">
            <button @click="open = !open" class="w-full text-left flex justify-between items-center py-4 border-b border-gray-200">
                <span class="font-semibold">What payment methods do you accept?</span>
                <svg class="w-5 h-5 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="open" x-cloak class="py-4 text-gray-600">
                We accept PayPal, Visa, Mastercard, American Express, and Discover. All payments are processed securely.
            </div>
        </div>
        
        <div x-data="{ open: false }">
            <button @click="open = !open" class="w-full text-left flex justify-between items-center py-4 border-b border-gray-200">
                <span class="font-semibold">How long does shipping take?</span>
                <svg class="w-5 h-5 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="open" x-cloak class="py-4 text-gray-600">
                Shipping times vary depending on your location and the seller. Most orders are processed within 1-3 business days and delivered within 5-10 business days.
            </div>
        </div>
        
        <div x-data="{ open: false }">
            <button @click="open = !open" class="w-full text-left flex justify-between items-center py-4 border-b border-gray-200">
                <span class="font-semibold">Can I return or exchange an item?</span>
                <svg class="w-5 h-5 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="open" x-cloak class="py-4 text-gray-600">
                Yes, please review our Return & Refund Policy for details on returns and exchanges. Most items can be returned within 30 days of purchase.
            </div>
        </div>
        
        <div x-data="{ open: false }">
            <button @click="open = !open" class="w-full text-left flex justify-between items-center py-4 border-b border-gray-200">
                <span class="font-semibold">How do I track my order?</span>
                <svg class="w-5 h-5 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="open" x-cloak class="py-4 text-gray-600">
                Once your order ships, you'll receive a tracking number via email. You can use this number to track your package on our website.
            </div>
        </div>
        
        <div x-data="{ open: false }">
            <button @click="open = !open" class="w-full text-left flex justify-between items-center py-4 border-b border-gray-200">
                <span class="font-semibold">How can I contact customer support?</span>
                <svg class="w-5 h-5 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="open" x-cloak class="py-4 text-gray-600">
                You can reach us via email at support@myshop.com, phone at +1 (555) 123-4567, or through our Contact Us page.
            </div>
        </div>
    </div>
</div>
@endsection
