@extends('public.layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-4xl font-bold mb-6">Fees & Commission</h1>
    
    <div class="bg-white rounded-lg shadow-md p-8 space-y-6">
        <section>
            <h2 class="text-2xl font-semibold mb-4">Fee Structure</h2>
            <p class="text-gray-600 leading-relaxed mb-4">
                Our fee structure is designed to be competitive and fair. We charge fees based on successful sales and offer various payment options.
            </p>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">Commission Rates</h2>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 px-4 py-3 text-left">Category</th>
                            <th class="border border-gray-300 px-4 py-3 text-left">Commission Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border border-gray-300 px-4 py-3">Electronics</td>
                            <td class="border border-gray-300 px-4 py-3">10%</td>
                        </tr>
                        <tr class="bg-gray-50">
                            <td class="border border-gray-300 px-4 py-3">Clothing & Accessories</td>
                            <td class="border border-gray-300 px-4 py-3">12%</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 px-4 py-3">Home & Garden</td>
                            <td class="border border-gray-300 px-4 py-3">10%</td>
                        </tr>
                        <tr class="bg-gray-50">
                            <td class="border border-gray-300 px-4 py-3">Health & Beauty</td>
                            <td class="border border-gray-300 px-4 py-3">12%</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 px-4 py-3">Other Categories</td>
                            <td class="border border-gray-300 px-4 py-3">10-15%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">Payment Processing Fees</h2>
            <p class="text-gray-600 leading-relaxed mb-2">
                Payment processing fees are charged by payment processors and are separate from our commission. These fees typically range from 2.9% to 3.5% plus a small transaction fee, depending on the payment method used.
            </p>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">Listing Fees</h2>
            <p class="text-gray-600 leading-relaxed">
                Currently, there are no listing fees. You can list products for free, and we only charge a commission when you make a sale.
            </p>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">When Fees Are Charged</h2>
            <p class="text-gray-600 leading-relaxed mb-2">
                Fees are charged:
            </p>
            <ul class="list-disc list-inside text-gray-600 space-y-1 ml-4">
                <li>Commission: Deducted from the sale price before payment is sent to you</li>
                <li>Payment processing fees: Charged by the payment processor at the time of transaction</li>
                <li>Fees are only charged on completed sales, not on refunded or cancelled orders</li>
            </ul>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">Payment Schedule</h2>
            <p class="text-gray-600 leading-relaxed">
                Seller payments are processed on a bi-weekly basis. Payments are sent to your registered bank account after deducting applicable fees and commissions.
            </p>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">Fee Changes</h2>
            <p class="text-gray-600 leading-relaxed">
                We reserve the right to modify fee structures with 30 days notice to sellers. You will be notified of any changes via email.
            </p>
        </section>
        
        <section>
            <h2 class="text-2xl font-semibold mb-4">Questions?</h2>
            <p class="text-gray-600 leading-relaxed">
                If you have questions about our fees and commission structure, please contact us at support@myshop.com.
            </p>
        </section>
    </div>
</div>
@endsection
