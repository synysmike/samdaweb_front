@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-4xl font-bold mb-6">Privacy Policy</h1>
    
    <div class="bg-white rounded-lg shadow-md p-8 space-y-6">
        <section>
            <p class="text-gray-600 leading-relaxed mb-4">
                <strong>Last updated:</strong> {{ date('F j, Y') }}
            </p>
            <p class="text-gray-600 leading-relaxed">
                MyShop respects your privacy and is committed to protecting your personal data. This privacy policy explains how we collect, use, and safeguard your information.
            </p>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">1. Information We Collect</h2>
            <p class="text-gray-600 leading-relaxed mb-2">We collect the following types of information:</p>
            <ul class="list-disc list-inside text-gray-600 space-y-1 ml-4">
                <li>Personal identification information (name, email, phone number)</li>
                <li>Payment information (processed securely through payment processors)</li>
                <li>Shipping and billing addresses</li>
                <li>Account credentials</li>
                <li>Browsing and purchase history</li>
            </ul>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">2. How We Use Your Information</h2>
            <p class="text-gray-600 leading-relaxed mb-2">We use your information to:</p>
            <ul class="list-disc list-inside text-gray-600 space-y-1 ml-4">
                <li>Process and fulfill your orders</li>
                <li>Communicate with you about your account and orders</li>
                <li>Improve our website and services</li>
                <li>Send marketing communications (with your consent)</li>
                <li>Prevent fraud and ensure security</li>
            </ul>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">3. Data Protection</h2>
            <p class="text-gray-600 leading-relaxed">
                We implement appropriate security measures to protect your personal information. However, no method of transmission over the Internet is 100% secure.
            </p>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">4. Sharing Your Information</h2>
            <p class="text-gray-600 leading-relaxed">
                We do not sell your personal information. We may share your information with trusted service providers who assist in operating our website, conducting business, or serving users.
            </p>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">5. Your Rights</h2>
            <p class="text-gray-600 leading-relaxed mb-2">You have the right to:</p>
            <ul class="list-disc list-inside text-gray-600 space-y-1 ml-4">
                <li>Access your personal data</li>
                <li>Correct inaccurate data</li>
                <li>Request deletion of your data</li>
                <li>Opt-out of marketing communications</li>
            </ul>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">6. Cookies</h2>
            <p class="text-gray-600 leading-relaxed">
                We use cookies to enhance your browsing experience. For more information, please see our Cookie Policy.
            </p>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">7. Contact Us</h2>
            <p class="text-gray-600 leading-relaxed">
                If you have questions about this privacy policy, please contact us at support@myshop.com.
            </p>
        </section>
    </div>
</div>
@endsection
