@extends('public.layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-4xl font-bold mb-6">Sell on MyShop</h1>
    
    <div class="bg-white rounded-lg shadow-md p-8 space-y-6">
        <section>
            <h2 class="text-2xl font-semibold mb-4">Start Selling Today</h2>
            <p class="text-gray-600 leading-relaxed mb-4">
                Join thousands of sellers on MyShop and reach millions of customers worldwide. Our platform makes it easy to start selling your products online.
            </p>
            <div class="bg-blue-50 p-6 rounded-lg">
                <h3 class="font-semibold mb-2">Why Sell on MyShop?</h3>
                <ul class="list-disc list-inside text-gray-700 space-y-1 ml-4">
                    <li>Large customer base and reach</li>
                    <li>Easy-to-use seller dashboard</li>
                    <li>Secure payment processing</li>
                    <li>Marketing and promotional tools</li>
                    <li>Dedicated seller support</li>
                </ul>
            </div>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">Getting Started</h2>
            <div class="space-y-4">
                <div class="flex gap-4">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-green-600 font-bold">1</span>
                    </div>
                    <div>
                        <h3 class="font-semibold mb-1">Create Seller Account</h3>
                        <p class="text-gray-600 text-sm">Sign up and complete your seller profile with business information.</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-green-600 font-bold">2</span>
                    </div>
                    <div>
                        <h3 class="font-semibold mb-1">Add Your Products</h3>
                        <p class="text-gray-600 text-sm">List your products with high-quality images, descriptions, and pricing.</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-green-600 font-bold">3</span>
                    </div>
                    <div>
                        <h3 class="font-semibold mb-1">Start Selling</h3>
                        <p class="text-gray-600 text-sm">Your products go live and customers can start purchasing immediately.</p>
                    </div>
                </div>
            </div>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">Seller Requirements</h2>
            <ul class="list-disc list-inside text-gray-600 space-y-1 ml-4">
                <li>Valid business registration (if applicable)</li>
                <li>Bank account for payments</li>
                <li>Tax identification number</li>
                <li>Agreement to Seller Agreement and policies</li>
            </ul>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">Fees & Commission</h2>
            <p class="text-gray-600 leading-relaxed">
                We offer competitive commission rates. Please review our <a href="/fees-commission" class="text-blue-600 hover:text-blue-700">Fees & Commission</a> page for detailed information about our fee structure.
            </p>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">Need Help?</h2>
            <p class="text-gray-600 leading-relaxed">
                Our seller support team is here to help. Contact us at support@myshop.com or call +1 (555) 123-4567 to learn more about selling on MyShop.
            </p>
        </section>
        
        <div class="pt-6">
            <a href="#" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                Get Started as a Seller
            </a>
        </div>
    </div>
</div>
@endsection
