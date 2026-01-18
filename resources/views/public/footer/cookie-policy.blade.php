@extends('public.layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-4xl font-bold mb-6">Cookie Policy</h1>
    
    <div class="bg-white rounded-lg shadow-md p-8 space-y-6">
        <section>
            <p class="text-gray-600 leading-relaxed mb-4">
                <strong>Last updated:</strong> {{ date('F j, Y') }}
            </p>
            <p class="text-gray-600 leading-relaxed">
                This Cookie Policy explains how MyShop uses cookies and similar technologies on our website to recognize you when you visit our site and how we use them.
            </p>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">What Are Cookies?</h2>
            <p class="text-gray-600 leading-relaxed">
                Cookies are small text files that are placed on your device when you visit a website. They are widely used to make websites work more efficiently and provide information to website owners.
            </p>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">How We Use Cookies</h2>
            <p class="text-gray-600 leading-relaxed mb-2">We use cookies for the following purposes:</p>
            <ul class="list-disc list-inside text-gray-600 space-y-1 ml-4">
                <li><strong>Essential Cookies:</strong> Required for the website to function properly</li>
                <li><strong>Performance Cookies:</strong> Help us understand how visitors interact with our website</li>
                <li><strong>Functionality Cookies:</strong> Remember your preferences and settings</li>
                <li><strong>Advertising Cookies:</strong> Used to deliver relevant advertisements (if applicable)</li>
            </ul>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">Types of Cookies We Use</h2>
            <div class="space-y-4">
                <div>
                    <h3 class="font-semibold mb-2">Session Cookies</h3>
                    <p class="text-gray-600 text-sm">Temporary cookies that are deleted when you close your browser.</p>
                </div>
                <div>
                    <h3 class="font-semibold mb-2">Persistent Cookies</h3>
                    <p class="text-gray-600 text-sm">Remain on your device for a set period or until you delete them.</p>
                </div>
            </div>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">Managing Cookies</h2>
            <p class="text-gray-600 leading-relaxed mb-2">
                You can control and manage cookies in various ways:
            </p>
            <ul class="list-disc list-inside text-gray-600 space-y-1 ml-4">
                <li>Browser settings allow you to refuse cookies or delete existing ones</li>
                <li>Note that blocking cookies may impact website functionality</li>
                <li>You can opt-out of certain third-party cookies through their websites</li>
            </ul>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">Third-Party Cookies</h2>
            <p class="text-gray-600 leading-relaxed">
                Some cookies are set by third-party services that appear on our pages. We do not control these cookies, so please refer to the third party's privacy policy.
            </p>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">More Information</h2>
            <p class="text-gray-600 leading-relaxed">
                If you have questions about our use of cookies, please contact us at support@myshop.com.
            </p>
        </section>
    </div>
</div>
@endsection
