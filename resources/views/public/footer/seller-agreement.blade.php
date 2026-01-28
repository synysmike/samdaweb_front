@extends('public.layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-4xl font-bold mb-6">Seller Agreement</h1>
    
    <div class="bg-white rounded-lg shadow-md p-8">
        @php
            $filePath = storage_path('app/page-content/seller-agreement.html');
            $content = file_exists($filePath) ? file_get_contents($filePath) : '';
            
            // If no content, use default
            if (empty($content)) {
                $content = '<section>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        <strong>Last updated:</strong> ' . date('F j, Y') . '
                    </p>
                    <p class="text-gray-600 leading-relaxed">
                        This Seller Agreement governs your participation as a seller on the MyShop platform. By registering as a seller, you agree to be bound by the terms of this agreement.
                    </p>
                </section>
                
                <section>
                    <h2 class="text-2xl font-semibold mb-4">1. Seller Eligibility</h2>
                    <p class="text-gray-600 leading-relaxed mb-2">To become a seller, you must:</p>
                    <ul class="list-disc list-inside text-gray-600 space-y-1 ml-4">
                        <li>Be at least 18 years old</li>
                        <li>Have the legal capacity to enter into contracts</li>
                        <li>Provide accurate business information</li>
                        <li>Comply with all applicable laws and regulations</li>
                    </ul>
                </section>
                
                <section>
                    <h2 class="text-2xl font-semibold mb-4">2. Seller Responsibilities</h2>
                    <p class="text-gray-600 leading-relaxed mb-2">As a seller, you agree to:</p>
                    <ul class="list-disc list-inside text-gray-600 space-y-1 ml-4">
                        <li>Provide accurate product descriptions and images</li>
                        <li>Ship products in a timely manner</li>
                        <li>Respond to customer inquiries promptly</li>
                        <li>Maintain adequate inventory levels</li>
                        <li>Comply with all platform policies and guidelines</li>
                    </ul>
                </section>
                
                <section>
                    <h2 class="text-2xl font-semibold mb-4">3. Product Listings</h2>
                    <p class="text-gray-600 leading-relaxed mb-2">Your product listings must:</p>
                    <ul class="list-disc list-inside text-gray-600 space-y-1 ml-4">
                        <li>Be accurate and truthful</li>
                        <li>Include high-quality images</li>
                        <li>Comply with our Listing Guidelines</li>
                        <li>Not violate any third-party rights</li>
                    </ul>
                </section>
                
                <section>
                    <h2 class="text-2xl font-semibold mb-4">4. Fees and Payments</h2>
                    <p class="text-gray-600 leading-relaxed">
                        You agree to pay applicable fees and commissions as outlined in our Fees & Commission policy. Payments to sellers are processed according to our payment schedule.
                    </p>
                </section>
                
                <section>
                    <h2 class="text-2xl font-semibold mb-4">5. Prohibited Activities</h2>
                    <p class="text-gray-600 leading-relaxed mb-2">Sellers may not:</p>
                    <ul class="list-disc list-inside text-gray-600 space-y-1 ml-4">
                        <li>Sell prohibited items</li>
                        <li>Engage in fraudulent activities</li>
                        <li>Manipulate ratings or reviews</li>
                        <li>Circumvent platform fees</li>
                        <li>Violate intellectual property rights</li>
                    </ul>
                </section>
                
                <section>
                    <h2 class="text-2xl font-semibold mb-4">6. Account Termination</h2>
                    <p class="text-gray-600 leading-relaxed">
                        We reserve the right to suspend or terminate seller accounts that violate this agreement or platform policies. Terminated sellers may be required to fulfill pending orders.
                    </p>
                </section>
                
                <section>
                    <h2 class="text-2xl font-semibold mb-4">7. Changes to Agreement</h2>
                    <p class="text-gray-600 leading-relaxed">
                        We may modify this agreement at any time. Material changes will be communicated to sellers via email. Continued use of the platform constitutes acceptance of changes.
                    </p>
                </section>
                
                <section>
                    <h2 class="text-2xl font-semibold mb-4">8. Contact</h2>
                    <p class="text-gray-600 leading-relaxed">
                        For questions about this agreement, please contact us at support@myshop.com.
                    </p>
                </section>';
            }
        @endphp
        <div class="space-y-6 prose max-w-none">
            {!! $content !!}
        </div>
    </div>
</div>
@endsection
