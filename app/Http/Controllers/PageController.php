<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    // INFORMATION Pages
    public function contactUs()
    {
        return view('public.footer.contact-us');
    }

    public function blog()
    {
        return view('public.footer.blog');
    }

    public function aboutUs()
    {
        return view('public.footer.about-us');
    }

    public function disclaimer()
    {
        return view('public.footer.disclaimer');
    }

    public function faq()
    {
        return view('public.footer.faq');
    }

    public function howItWorks()
    {
        return view('public.footer.how-it-works');
    }

    public function helpCenter()
    {
        return view('public.footer.help-center');
    }

    // BUY Pages
    public function termsConditions()
    {
        return view('public.footer.terms-conditions');
    }

    public function privacyPolicy()
    {
        return view('public.footer.privacy-policy');
    }

    public function returnRefundPolicy()
    {
        return view('public.footer.return-refund-policy');
    }

    public function shippingPolicy()
    {
        return view('public.footer.shipping-policy');
    }

    public function paymentPolicy()
    {
        return view('public.footer.payment-policy');
    }

    public function cookiePolicy()
    {
        return view('public.footer.cookie-policy');
    }

    public function buyerProtectionPolicy()
    {
        return view('public.footer.buyer-protection-policy');
    }

    public function intellectualPropertyPolicy()
    {
        return view('public.footer.intellectual-property-policy');
    }

    // SELL Pages
    public function sellOnBegja()
    {
        return view('public.footer.sell-on-begja');
    }

    public function sellerAgreement()
    {
        return view('public.footer.seller-agreement');
    }

    public function feesCommission()
    {
        return view('public.footer.fees-commission');
    }

    public function listingGuidelines()
    {
        return view('public.footer.listing-guidelines');
    }
}
