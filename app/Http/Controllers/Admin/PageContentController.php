<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageContentController extends Controller
{
    /**
     * Show Terms and Conditions edit page
     */
    public function editTermsConditions()
    {
        $content = $this->getContent('terms-conditions');
        return view('admin.page-content.terms-conditions', [
            'content' => $content,
            'pageType' => 'terms-conditions'
        ]);
    }

    /**
     * Show Seller Agreement edit page
     */
    public function editSellerAgreement()
    {
        $content = $this->getContent('seller-agreement');
        return view('admin.page-content.seller-agreement', [
            'content' => $content,
            'pageType' => 'seller-agreement'
        ]);
    }

    /**
     * Update Terms and Conditions
     */
    public function updateTermsConditions(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $this->saveContent('terms-conditions', $request->input('content'));

        return redirect()->route('admin.page-content.terms-conditions.edit')
            ->with('success', 'Terms and Conditions updated successfully!');
    }

    /**
     * Update Seller Agreement
     */
    public function updateSellerAgreement(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $this->saveContent('seller-agreement', $request->input('content'));

        return redirect()->route('admin.page-content.seller-agreement.edit')
            ->with('success', 'Seller Agreement updated successfully!');
    }

    /**
     * Get content from storage
     */
    private function getContent($pageType)
    {
        $filePath = "page-content/{$pageType}.html";

        if (Storage::disk('local')->exists($filePath)) {
            return Storage::disk('local')->get($filePath);
        }

        // Return default content if file doesn't exist
        return $this->getDefaultContent($pageType);
    }

    /**
     * Save content to storage
     */
    private function saveContent($pageType, $content)
    {
        $filePath = "page-content/{$pageType}.html";
        Storage::disk('local')->put($filePath, $content);
    }

    /**
     * Get default content for pages
     */
    private function getDefaultContent($pageType)
    {
        $defaults = [
            'terms-conditions' => '<h1>Terms and Conditions</h1><p>Please update the terms and conditions content here.</p>',
            'seller-agreement' => '<h1>Seller Agreement</h1><p>Please update the seller agreement content here.</p>',
        ];

        return $defaults[$pageType] ?? '';
    }
}
