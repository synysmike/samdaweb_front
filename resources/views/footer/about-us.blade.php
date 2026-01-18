@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-4xl font-bold mb-6">About Us</h1>
    
    <div class="bg-white rounded-lg shadow-md p-8 space-y-6">
        <section>
            <h2 class="text-2xl font-semibold mb-4">Welcome to MyShop</h2>
            <p class="text-gray-600 leading-relaxed">
                MyShop is a leading e-commerce platform dedicated to providing exceptional shopping experiences. We connect buyers and sellers in a seamless, secure, and user-friendly marketplace.
            </p>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">Our Mission</h2>
            <p class="text-gray-600 leading-relaxed">
                Our mission is to empower individuals and businesses by providing a platform that facilitates commerce while maintaining the highest standards of quality, security, and customer service.
            </p>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">What We Offer</h2>
            <ul class="list-disc list-inside text-gray-600 space-y-2">
                <li>Wide selection of quality products</li>
                <li>Secure payment processing</li>
                <li>Fast and reliable shipping</li>
                <li>Excellent customer support</li>
                <li>Buyer and seller protection policies</li>
            </ul>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">Our Values</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="font-semibold mb-2">Integrity</h3>
                    <p class="text-gray-600 text-sm">We conduct business with honesty and transparency.</p>
                </div>
                <div>
                    <h3 class="font-semibold mb-2">Customer First</h3>
                    <p class="text-gray-600 text-sm">Your satisfaction is our top priority.</p>
                </div>
                <div>
                    <h3 class="font-semibold mb-2">Innovation</h3>
                    <p class="text-gray-600 text-sm">We continuously improve our platform and services.</p>
                </div>
                <div>
                    <h3 class="font-semibold mb-2">Community</h3>
                    <p class="text-gray-600 text-sm">We build a strong and supportive marketplace community.</p>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
