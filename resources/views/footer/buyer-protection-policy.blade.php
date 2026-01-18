@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-4xl font-bold mb-6">Buyer Protection Policy</h1>
    
    <div class="bg-white rounded-lg shadow-md p-8 space-y-6">
        <section>
            <h2 class="text-2xl font-semibold mb-4">Your Protection</h2>
            <p class="text-gray-600 leading-relaxed">
                At MyShop, we are committed to protecting buyers and ensuring a safe, secure shopping experience. Our Buyer Protection Policy covers you throughout your purchase journey.
            </p>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">What's Covered</h2>
            <ul class="list-disc list-inside text-gray-600 space-y-2 ml-4">
                <li><strong>Item Not Received:</strong> Protection if you don't receive your order</li>
                <li><strong>Item Not as Described:</strong> Coverage for items that don't match their description</li>
                <li><strong>Defective Items:</strong> Protection for damaged or faulty products</li>
                <li><strong>Unauthorized Transactions:</strong> Coverage for unauthorized charges</li>
            </ul>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">How It Works</h2>
            <div class="space-y-4">
                <div class="flex gap-4">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-blue-600 font-bold">1</span>
                    </div>
                    <div>
                        <h3 class="font-semibold mb-1">Report an Issue</h3>
                        <p class="text-gray-600 text-sm">Contact us within the specified timeframe if you encounter any problems with your order.</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-blue-600 font-bold">2</span>
                    </div>
                    <div>
                        <h3 class="font-semibold mb-1">Investigation</h3>
                        <p class="text-gray-600 text-sm">We will investigate your claim and work with the seller to resolve the issue.</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-blue-600 font-bold">3</span>
                    </div>
                    <div>
                        <h3 class="font-semibold mb-1">Resolution</h3>
                        <p class="text-gray-600 text-sm">We will provide a resolution, which may include a refund, replacement, or other appropriate remedy.</p>
                    </div>
                </div>
            </div>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">Time Limits</h2>
            <p class="text-gray-600 leading-relaxed">
                You must report issues within the specified timeframes:
            </p>
            <ul class="list-disc list-inside text-gray-600 space-y-1 ml-4">
                <li>Item not received: Within 30 days of expected delivery</li>
                <li>Item not as described: Within 7 days of receipt</li>
                <li>Defective items: Within 30 days of receipt</li>
            </ul>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">Seller Accountability</h2>
            <p class="text-gray-600 leading-relaxed">
                We hold sellers accountable for providing accurate product descriptions, timely shipping, and quality products. Sellers who violate our policies may face penalties or account restrictions.
            </p>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">Contact Us</h2>
            <p class="text-gray-600 leading-relaxed">
                If you need to file a buyer protection claim or have questions, please contact us at support@myshop.com or call +1 (555) 123-4567.
            </p>
        </section>
    </div>
</div>
@endsection
