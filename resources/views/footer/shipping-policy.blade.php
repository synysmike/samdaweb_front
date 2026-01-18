@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-4xl font-bold mb-6">Shipping Policy</h1>
    
    <div class="bg-white rounded-lg shadow-md p-8 space-y-6">
        <section>
            <h2 class="text-2xl font-semibold mb-4">Shipping Options</h2>
            <p class="text-gray-600 leading-relaxed mb-4">
                We offer various shipping options to meet your needs. Shipping costs and delivery times vary depending on your location and the shipping method selected.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="p-4 border border-gray-200 rounded-lg">
                    <h3 class="font-semibold mb-2">Standard Shipping</h3>
                    <p class="text-sm text-gray-600">5-10 business days</p>
                </div>
                <div class="p-4 border border-gray-200 rounded-lg">
                    <h3 class="font-semibold mb-2">Express Shipping</h3>
                    <p class="text-sm text-gray-600">2-5 business days</p>
                </div>
            </div>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">Processing Time</h2>
            <p class="text-gray-600 leading-relaxed">
                Orders are typically processed within 1-3 business days after payment confirmation. Processing time may be longer during peak seasons or for custom items.
            </p>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">Shipping Costs</h2>
            <p class="text-gray-600 leading-relaxed mb-2">
                Shipping costs are calculated at checkout based on:</p>
            <ul class="list-disc list-inside text-gray-600 space-y-1 ml-4">
                <li>Item weight and dimensions</li>
                <li>Destination address</li>
                <li>Selected shipping method</li>
            </ul>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">Order Tracking</h2>
            <p class="text-gray-600 leading-relaxed">
                Once your order ships, you will receive a tracking number via email. You can use this number to track your package on our website or the carrier's website.
            </p>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">International Shipping</h2>
            <p class="text-gray-600 leading-relaxed mb-2">
                We ship to various countries worldwide. Please note:
            </p>
            <ul class="list-disc list-inside text-gray-600 space-y-1 ml-4">
                <li>International shipping times may vary</li>
                <li>Customs duties and taxes may apply</li>
                <li>These charges are the responsibility of the recipient</li>
            </ul>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">Shipping Address</h2>
            <p class="text-gray-600 leading-relaxed">
                Please ensure your shipping address is accurate and complete. We are not responsible for packages delivered to incorrect addresses provided by customers.
            </p>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">Lost or Stolen Packages</h2>
            <p class="text-gray-600 leading-relaxed">
                If your package is lost or stolen, please contact us immediately. We will work with the carrier to resolve the issue and arrange for a replacement or refund.
            </p>
        </section>
    </div>
</div>
@endsection
