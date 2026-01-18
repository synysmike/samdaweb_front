<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    // INFORMATION Pages
    public function contactUs()
    {
        return view('footer.contact-us');
    }

    public function blog()
    {
        return view('footer.blog');
    }

    public function aboutUs()
    {
        return view('footer.about-us');
    }

    public function disclaimer()
    {
        return view('footer.disclaimer');
    }

    public function faq()
    {
        return view('footer.faq');
    }

    public function howItWorks()
    {
        return view('footer.how-it-works');
    }

    public function helpCenter()
    {
        return view('footer.help-center');
    }

    // BUY Pages
    public function termsConditions()
    {
        return view('footer.terms-conditions');
    }

    public function privacyPolicy()
    {
        return view('footer.privacy-policy');
    }

    public function returnRefundPolicy()
    {
        return view('footer.return-refund-policy');
    }

    public function shippingPolicy()
    {
        return view('footer.shipping-policy');
    }

    public function paymentPolicy()
    {
        return view('footer.payment-policy');
    }

    public function cookiePolicy()
    {
        return view('footer.cookie-policy');
    }

    public function buyerProtectionPolicy()
    {
        return view('footer.buyer-protection-policy');
    }

    public function intellectualPropertyPolicy()
    {
        return view('footer.intellectual-property-policy');
    }

    // SELL Pages
    public function sellOnBegja()
    {
        return view('footer.sell-on-begja');
    }

    public function sellerAgreement()
    {
        return view('footer.seller-agreement');
    }

    public function feesCommission()
    {
        return view('footer.fees-commission');
    }

    public function listingGuidelines()
    {
        return view('footer.listing-guidelines');
    }
}
