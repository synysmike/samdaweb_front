@extends('public.layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-4xl font-bold mb-6">Listing Guidelines</h1>
    
    <div class="bg-white rounded-lg shadow-md p-8 space-y-6">
        <section>
            <h2 class="text-2xl font-semibold mb-4">Product Listings Standards</h2>
            <p class="text-gray-600 leading-relaxed">
                To ensure a positive shopping experience for customers and maintain marketplace quality, all product listings must adhere to these guidelines.
            </p>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">1. Product Information</h2>
            <h3 class="text-lg font-semibold mb-2">Title Requirements</h3>
            <ul class="list-disc list-inside text-gray-600 space-y-1 ml-4">
                <li>Must be clear, accurate, and descriptive</li>
                <li>Include brand name and key product features</li>
                <li>Avoid excessive use of keywords or promotional text</li>
                <li>Should not exceed 100 characters</li>
            </ul>
            
            <h3 class="text-lg font-semibold mt-4 mb-2">Description Requirements</h3>
            <ul class="list-disc list-inside text-gray-600 space-y-1 ml-4">
                <li>Provide detailed product information</li>
                <li>Include specifications, dimensions, and features</li>
                <li>Mention condition (new, used, refurbished)</li>
                <li>List any included accessories or items</li>
            </ul>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">2. Product Images</h2>
            <ul class="list-disc list-inside text-gray-600 space-y-1 ml-4">
                <li>Use high-quality, clear images</li>
                <li>Minimum resolution: 1000x1000 pixels</li>
                <li>Show product from multiple angles</li>
                <li>Use white or neutral backgrounds</li>
                <li>Images must accurately represent the product</li>
                <li>Include at least 3-5 images per listing</li>
            </ul>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">3. Pricing</h2>
            <ul class="list-disc list-inside text-gray-600 space-y-1 ml-4">
                <li>Set competitive and fair prices</li>
                <li>Include all applicable taxes in price display (as required)</li>
                <li>Clearly indicate sale prices vs. regular prices</li>
                <li>Do not engage in price manipulation or price fixing</li>
            </ul>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">4. Category and Classification</h2>
            <ul class="list-disc list-inside text-gray-600 space-y-1 ml-4">
                <li>Select the most appropriate category</li>
                <li>Use accurate product attributes</li>
                <li>Do not list products in incorrect categories</li>
            </ul>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">5. Prohibited Items</h2>
            <p class="text-gray-600 leading-relaxed mb-2">You may not list:</p>
            <ul class="list-disc list-inside text-gray-600 space-y-1 ml-4">
                <li>Illegal items or items that violate laws</li>
                <li>Counterfeit or replica products</li>
                <li>Dangerous or hazardous materials</li>
                <li>Items that infringe intellectual property rights</li>
                <li>Prohibited or restricted items per our Terms & Conditions</li>
            </ul>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">6. Prohibited Practices</h2>
            <ul class="list-disc list-inside text-gray-600 space-y-1 ml-4">
                <li>Keyword stuffing or spam</li>
                <li>Misleading or false product information</li>
                <li>Duplicate listings of the same product</li>
                <li>Using competitor names or trademarks inappropriately</li>
                <li>Manipulating product rankings or reviews</li>
            </ul>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">7. Inventory Management</h2>
            <ul class="list-disc list-inside text-gray-600 space-y-1 ml-4">
                <li>Maintain accurate inventory counts</li>
                <li>Update listings when items are out of stock</li>
                <li>Remove listings for discontinued products</li>
                <li>Ensure products are available when listed</li>
            </ul>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">8. Consequences of Violations</h2>
            <p class="text-gray-600 leading-relaxed">
                Listings that violate these guidelines may be removed, and sellers may face warnings, restrictions, or account termination for repeated violations.
            </p>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">Questions?</h2>
            <p class="text-gray-600 leading-relaxed">
                If you have questions about listing guidelines, please contact us at support@myshop.com.
            </p>
        </section>
    </div>
</div>
@endsection
