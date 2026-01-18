@extends('public.layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-4xl font-bold mb-6">Return & Refund Policy</h1>
    
    <div class="bg-white rounded-lg shadow-md p-8 space-y-6">
        <section>
            <h2 class="text-2xl font-semibold mb-4">Returns</h2>
            <p class="text-gray-600 leading-relaxed mb-4">
                We want you to be completely satisfied with your purchase. You may return most items within 30 days of delivery for a full refund or exchange.
            </p>
            <h3 class="text-lg font-semibold mb-2">Return Conditions</h3>
            <ul class="list-disc list-inside text-gray-600 space-y-1 ml-4">
                <li>Items must be unused and in original packaging</li>
                <li>Items must be in original condition with all tags attached</li>
                <li>Return requests must be made within 30 days of delivery</li>
                <li>Some items may not be eligible for return (e.g., perishables, personalized items)</li>
            </ul>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">How to Return</h2>
            <ol class="list-decimal list-inside text-gray-600 space-y-2 ml-4">
                <li>Contact our customer service team to initiate a return</li>
                <li>Receive return authorization and shipping instructions</li>
                <li>Package the item securely in its original packaging</li>
                <li>Ship the item back to the provided address</li>
            </ol>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">Refunds</h2>
            <p class="text-gray-600 leading-relaxed mb-2">
                Once we receive and inspect your returned item, we will process your refund. Refunds will be issued to the original payment method within 5-10 business days.
            </p>
            <h3 class="text-lg font-semibold mb-2">Refund Processing</h3>
            <ul class="list-disc list-inside text-gray-600 space-y-1 ml-4">
                <li>Refund amount will include the item price and applicable taxes</li>
                <li>Original shipping charges are non-refundable unless the return is due to our error</li>
                <li>Return shipping costs are the responsibility of the customer unless otherwise stated</li>
            </ul>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">Exchanges</h2>
            <p class="text-gray-600 leading-relaxed">
                Exchanges are available for items of equal or greater value. If you need to exchange an item, please follow the return process and indicate that you wish to exchange the item.
            </p>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">Damaged or Defective Items</h2>
            <p class="text-gray-600 leading-relaxed">
                If you receive a damaged or defective item, please contact us immediately. We will arrange for a replacement or full refund at no additional cost to you.
            </p>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">Questions?</h2>
            <p class="text-gray-600 leading-relaxed">
                If you have questions about returns or refunds, please contact us at support@myshop.com or call +1 (555) 123-4567.
            </p>
        </section>
    </div>
</div>
@endsection
