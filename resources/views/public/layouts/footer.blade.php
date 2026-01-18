<footer class="bg-gray-100 text-gray-700 mt-12">
    <div class="container mx-auto px-6 py-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- COMPANY Column -->
            <div id="company-info-container">
                <h3 class="text-lg font-bold text-gray-900 mb-4">COMPANY</h3>
                <div class="space-y-3 text-sm" id="company-contact-info">
                    <!-- Contact info will be rendered by JavaScript -->
                </div>
                
                <!-- Social Media Icons -->
                <div class="flex gap-3 mt-4" id="company-social-media">
                    <!-- Social media icons will be rendered by JavaScript -->
                </div>
            </div>

            <!-- INFORMATION Column -->
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-4">INFORMATION</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="/contact-us" class="hover:text-blue-600 transition-colors">Contact Us</a></li>
                    <li><a href="/blog" class="hover:text-blue-600 transition-colors">Blog</a></li>
                    <li><a href="/about-us" class="hover:text-blue-600 transition-colors">About Us</a></li>
                    <li><a href="/disclaimer" class="hover:text-blue-600 transition-colors">Disclaimer</a></li>
                    <li><a href="/faq" class="hover:text-blue-600 transition-colors">FAQ</a></li>
                    <li><a href="/how-it-works" class="hover:text-blue-600 transition-colors">How It Works</a></li>
                    <li><a href="/help-center" class="hover:text-blue-600 transition-colors">Help Center</a></li>
                </ul>
            </div>

            <!-- BUY Column -->
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-4">BUY</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="/terms-conditions" class="hover:text-blue-600 transition-colors">Terms & Conditions</a></li>
                    <li><a href="/privacy-policy" class="hover:text-blue-600 transition-colors">Privacy Policy</a></li>
                    <li><a href="/return-refund-policy" class="hover:text-blue-600 transition-colors">Return & Refund Policy</a></li>
                    <li><a href="/shipping-policy" class="hover:text-blue-600 transition-colors">Shipping Policy</a></li>
                    <li><a href="/payment-policy" class="hover:text-blue-600 transition-colors">Payment Policy</a></li>
                    <li><a href="/cookie-policy" class="hover:text-blue-600 transition-colors">Cookie Policy</a></li>
                    <li><a href="/buyer-protection-policy" class="hover:text-blue-600 transition-colors">Buyer Protection Policy</a></li>
                    <li><a href="/intellectual-property-policy" class="hover:text-blue-600 transition-colors">Intellectual Property Policy</a></li>
                </ul>
            </div>

            <!-- SELL Column -->
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-4">SELL</h3>
                <ul class="space-y-2 text-sm mb-4">
                    <li><a href="/sell-on-begja" class="hover:text-blue-600 transition-colors">Sell on MyShop</a></li>
                    <li><a href="/seller-agreement" class="hover:text-blue-600 transition-colors">Seller Agreement</a></li>
                    <li><a href="/fees-commission" class="hover:text-blue-600 transition-colors">Fees & Commission</a></li>
                    <li><a href="/listing-guidelines" class="hover:text-blue-600 transition-colors">Listing Guidelines</a></li>
                </ul>
                
                <!-- Payment Methods -->
                <div class="mt-4">
                    <p class="text-xs text-gray-600 mb-2">We Accept:</p>
                    <div class="flex flex-wrap gap-2">
                        <!-- PayPal -->
                        <div class="bg-white px-3 py-2 rounded border border-gray-300 flex items-center justify-center h-9 hover:border-blue-500 transition-colors">
                            <img src="{{ asset('assets/images/payments/paypal.png') }}" alt="PayPal" class="h-5 object-contain">
                        </div>
                        <!-- Visa -->
                        <div class="bg-white px-3 py-2 rounded border border-gray-300 flex items-center justify-center h-9 hover:border-blue-500 transition-colors">
                            <img src="{{ asset('assets/images/payments/visa.png') }}" alt="Visa" class="h-5 object-contain">
                        </div>
                        <!-- Mastercard -->
                        <div class="bg-white px-3 py-2 rounded border border-gray-300 flex items-center justify-center h-9 hover:border-red-500 transition-colors">
                            <img src="{{ asset('assets/images/payments/mastercard.png') }}" alt="Mastercard" class="h-5 object-contain">
                        </div>
                        <!-- American Express -->
                        <div class="bg-white px-3 py-2 rounded border border-gray-300 flex items-center justify-center h-9 hover:border-blue-600 transition-colors">
                            <img src="{{ asset('assets/images/payments/amex.png') }}" alt="American Express" class="h-5 object-contain">
                        </div>
                        <!-- Discover -->
                        <div class="bg-white px-3 py-2 rounded border border-gray-300 flex items-center justify-center h-9 hover:border-orange-500 transition-colors">
                            <img src="{{ asset('assets/images/payments/discover.png') }}" alt="Discover" class="h-5 object-contain">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="border-t border-gray-300 py-4 text-center text-sm text-gray-600">
        © {{ date('Y') }} MyShop. All rights reserved.
    </div>
</footer>
