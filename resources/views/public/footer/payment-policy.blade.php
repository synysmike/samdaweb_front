@extends('public.layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-4xl font-bold mb-6">Payment Policy</h1>
    
    <div class="bg-white rounded-lg shadow-md p-8 space-y-6">
        <section>
            <h2 class="text-2xl font-semibold mb-4">Accepted Payment Methods</h2>
            <p class="text-gray-600 leading-relaxed mb-4">
                We accept the following payment methods for your convenience:
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="p-4 border border-gray-200 rounded-lg">
                    <h3 class="font-semibold mb-2">Credit/Debit Cards</h3>
                    <p class="text-sm text-gray-600">Visa, Mastercard, American Express, Discover</p>
                </div>
                <div class="p-4 border border-gray-200 rounded-lg">
                    <h3 class="font-semibold mb-2">PayPal</h3>
                    <p class="text-sm text-gray-600">Secure online payment through PayPal</p>
                </div>
            </div>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">Payment Security</h2>
            <p class="text-gray-600 leading-relaxed">
                All payment transactions are processed securely through encrypted payment gateways. We do not store your complete credit card information on our servers.
            </p>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">Payment Processing</h2>
            <p class="text-gray-600 leading-relaxed mb-2">
                Payment is processed at the time of order placement. Your payment will be charged when:
            </p>
            <ul class="list-disc list-inside text-gray-600 space-y-1 ml-4">
                <li>You complete the checkout process</li>
                <li>Your payment method is verified</li>
                <li>Order is confirmed</li>
            </ul>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">Currency</h2>
            <p class="text-gray-600 leading-relaxed">
                All prices are displayed in the currency indicated on the website. If you make a payment in a different currency, your bank or payment provider may apply currency conversion fees.
            </p>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">Payment Verification</h2>
            <p class="text-gray-600 leading-relaxed">
                For security purposes, we may need to verify your payment information. This may include requesting additional identification documents.
            </p>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">Failed Payments</h2>
            <p class="text-gray-600 leading-relaxed">
                If your payment fails, we will notify you via email. Please verify your payment information and try again. Your order will not be processed until payment is successful.
            </p>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">Refunds</h2>
            <p class="text-gray-600 leading-relaxed">
                Refunds will be processed to the original payment method used for the purchase. Please see our Return & Refund Policy for more information.
            </p>
        </section>
    </div>
</div>
@endsection
