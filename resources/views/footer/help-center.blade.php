@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-4xl font-bold mb-6">Help Center</h1>
    
    <div class="bg-white rounded-lg shadow-md p-8 mb-6">
        <h2 class="text-2xl font-semibold mb-4">Need Help?</h2>
        <p class="text-gray-600 mb-6">We're here to assist you. Find answers to common questions or contact our support team.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <a href="/faq" class="p-4 border border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-colors">
                <h3 class="font-semibold mb-2">Frequently Asked Questions</h3>
                <p class="text-sm text-gray-600">Find answers to common questions</p>
            </a>
            <a href="/contact-us" class="p-4 border border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-colors">
                <h3 class="font-semibold mb-2">Contact Support</h3>
                <p class="text-sm text-gray-600">Get in touch with our team</p>
            </a>
            <a href="/how-it-works" class="p-4 border border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-colors">
                <h3 class="font-semibold mb-2">How It Works</h3>
                <p class="text-sm text-gray-600">Learn how to use our platform</p>
            </a>
            <a href="/shipping-policy" class="p-4 border border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-colors">
                <h3 class="font-semibold mb-2">Shipping Information</h3>
                <p class="text-sm text-gray-600">Learn about delivery options</p>
            </a>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-semibold mb-4">Popular Topics</h2>
        <ul class="space-y-3">
            <li><a href="/return-refund-policy" class="text-blue-600 hover:text-blue-700">Return and Refund Policy</a></li>
            <li><a href="/payment-policy" class="text-blue-600 hover:text-blue-700">Payment Methods</a></li>
            <li><a href="/buyer-protection-policy" class="text-blue-600 hover:text-blue-700">Buyer Protection</a></li>
            <li><a href="/seller-agreement" class="text-blue-600 hover:text-blue-700">Becoming a Seller</a></li>
        </ul>
    </div>
</div>
@endsection
