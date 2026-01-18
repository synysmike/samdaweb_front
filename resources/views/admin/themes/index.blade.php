@extends('admin.layouts.app')

@section('title', 'Themes')
@section('page-title', 'Theme Settings')

@section('content')
<div class="space-y-6">
    <!-- Theme Settings Form -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">General Settings</h3>
        
        <form action="{{ route('admin.themes.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- App Name -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Application Name</label>
                <input type="text" 
                       name="app_name" 
                       value="MyShop"
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                       required>
                @error('app_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
                <!-- Logo Upload -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Logo</label>
                <input type="file" 
                       name="logo" 
                       accept="image/*"
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                <p class="mt-1 text-xs text-gray-500">Upload a new logo (JPG, PNG, GIF, SVG - Max 2MB)</p>
                @error('logo')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Color Customization -->
            <div class="mb-6">
                <h4 class="text-md font-medium text-gray-900 mb-4">Color Customization</h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Primary Color -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Primary Color</label>
                        <div class="flex gap-3">
                            <input type="color" 
                                   name="primary_color" 
                                   value="#3b82f6"
                                   class="h-10 w-20 border border-gray-300 rounded cursor-pointer">
                            <input type="text" 
                                   name="primary_color" 
                                   value="#3b82f6"
                                   pattern="^#[a-fA-F0-9]{6}$"
                                   class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="#3b82f6">
                        </div>
                        @error('primary_color')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Secondary Color -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Secondary Color</label>
                        <div class="flex gap-3">
                            <input type="color" 
                                   name="secondary_color" 
                                   value="#8b5cf6"
                                   class="h-10 w-20 border border-gray-300 rounded cursor-pointer">
                            <input type="text" 
                                   name="secondary_color" 
                                   value="#8b5cf6"
                                   pattern="^#[a-fA-F0-9]{6}$"
                                   class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="#8b5cf6">
                        </div>
                        @error('secondary_color')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Submit Button -->
            <div class="flex gap-4">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                    Save Settings
                </button>
            </div>
        </form>
    </div>
    
    <!-- Banner Preview Section -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Banner Preview</h3>
        <p class="text-sm text-gray-500 mb-6">Preview how your banners will appear on the homepage</p>
        
        <div class="bg-gray-50 p-6 rounded-lg">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <!-- Main Carousel Preview (Left - 2/3) -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg border-2 border-dashed border-gray-300 p-8 text-center min-h-[300px] flex items-center justify-center">
                        <div class="text-gray-400">
                            <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-sm font-medium">Main Carousel Banner Preview</p>
                            <p class="text-xs mt-1">Banners will appear here</p>
                        </div>
                    </div>
                    <!-- Preview dots indicator -->
                    <div class="flex justify-center gap-2 mt-3">
                        <div class="w-2 h-2 rounded-full bg-red-500"></div>
                        <div class="w-2 h-2 rounded-full bg-gray-300"></div>
                        <div class="w-2 h-2 rounded-full bg-gray-300"></div>
                    </div>
                </div>
                
                <!-- Side Banners Preview (Right - 1/3) -->
                <div class="lg:col-span-1 flex flex-col gap-3">
                    <div class="bg-white rounded-lg border-2 border-dashed border-gray-300 p-4 text-center min-h-[90px] flex items-center justify-center">
                        <div class="text-gray-400">
                            <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-xs">Side Banner 1</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg border-2 border-dashed border-gray-300 p-4 text-center min-h-[90px] flex items-center justify-center">
                        <div class="text-gray-400">
                            <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-xs">Side Banner 2</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg border-2 border-dashed border-gray-300 p-4 text-center min-h-[90px] flex items-center justify-center">
                        <div class="text-gray-400">
                            <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-xs">Side Banner 3</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Carousel Banners Section -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Main Carousel Banners</h3>
                <p class="text-sm text-gray-500 mt-1">Upload banners for main carousel (max 5 banners)</p>
            </div>
            <button type="button" id="add-main-banner" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors text-sm">
                + Add Slide
            </button>
        </div>
        
        <div id="main-banners-container" class="space-y-6">
            <!-- Main banner items will be added here dynamically -->
            <div class="main-banner-item border border-gray-200 rounded-lg p-4">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="font-medium text-gray-900">Banner #1</h4>
                    <button type="button" class="remove-main-banner text-red-600 hover:text-red-700 text-sm" style="display: none;">
                        Remove
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Banner Image</label>
                        <input type="file" name="main_banner_image[]" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        <p class="mt-1 text-xs text-gray-500">JPG, PNG, GIF, SVG - Max 2MB</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Redirect Link</label>
                        <input type="url" name="main_banner_link[]" placeholder="https://example.com" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Side Banners Section -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Side Banners (Right)</h3>
            <p class="text-sm text-gray-500 mt-1">Upload 3 banners for the right side section</p>
        </div>
        
        <div id="side-banners-container" class="space-y-6">
            <!-- Side banner items - fixed 3 items -->
            <div class="side-banner-item border border-gray-200 rounded-lg p-4">
                <div class="mb-4">
                    <h4 class="font-medium text-gray-900">Side Banner #1</h4>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Banner Image</label>
                        <input type="file" name="side_banner_image[]" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        <p class="mt-1 text-xs text-gray-500">JPG, PNG, GIF, SVG - Max 2MB</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Redirect Link</label>
                        <input type="url" name="side_banner_link[]" placeholder="https://example.com" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>
            
            <div class="side-banner-item border border-gray-200 rounded-lg p-4">
                <div class="mb-4">
                    <h4 class="font-medium text-gray-900">Side Banner #2</h4>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Banner Image</label>
                        <input type="file" name="side_banner_image[]" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        <p class="mt-1 text-xs text-gray-500">JPG, PNG, GIF, SVG - Max 2MB</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Redirect Link</label>
                        <input type="url" name="side_banner_link[]" placeholder="https://example.com" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>
            
            <div class="side-banner-item border border-gray-200 rounded-lg p-4">
                <div class="mb-4">
                    <h4 class="font-medium text-gray-900">Side Banner #3</h4>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Banner Image</label>
                        <input type="file" name="side_banner_image[]" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        <p class="mt-1 text-xs text-gray-500">JPG, PNG, GIF, SVG - Max 2MB</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Redirect Link</label>
                        <input type="url" name="side_banner_link[]" placeholder="https://example.com" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sync color picker with text input
        const colorPickers = document.querySelectorAll('input[type="color"]');
        colorPickers.forEach(picker => {
            const textInput = picker.parentElement.querySelector('input[type="text"]');
            picker.addEventListener('input', function() {
                textInput.value = this.value;
            });
            textInput.addEventListener('input', function() {
                if (this.value.match(/^#[a-fA-F0-9]{6}$/)) {
                    picker.value = this.value;
                }
            });
        });
        
        // Main Banner Management
        const mainBannersContainer = document.getElementById('main-banners-container');
        const addMainBannerBtn = document.getElementById('add-main-banner');
        const maxMainBanners = 5;
        
        // Count existing main banners
        function updateMainBannerCount() {
            const mainBannerItems = mainBannersContainer.querySelectorAll('.main-banner-item');
            const count = mainBannerItems.length;
            
            // Show/hide remove buttons
            mainBannerItems.forEach((item, index) => {
                const removeBtn = item.querySelector('.remove-main-banner');
                if (count > 1) {
                    removeBtn.style.display = 'block';
                } else {
                    removeBtn.style.display = 'none';
                }
            });
            
            // Enable/disable add button
            if (count >= maxMainBanners) {
                addMainBannerBtn.disabled = true;
                addMainBannerBtn.classList.add('opacity-50', 'cursor-not-allowed');
                addMainBannerBtn.textContent = `Max ${maxMainBanners} banners`;
            } else {
                addMainBannerBtn.disabled = false;
                addMainBannerBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                addMainBannerBtn.textContent = '+ Add Slide';
            }
        }
        
        // Add new main banner
        addMainBannerBtn.addEventListener('click', function() {
            const mainBannerItems = mainBannersContainer.querySelectorAll('.main-banner-item');
            if (mainBannerItems.length >= maxMainBanners) {
                return;
            }
            
            const bannerNumber = mainBannerItems.length + 1;
            const newBannerHtml = `
                <div class="main-banner-item border border-gray-200 rounded-lg p-4">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="font-medium text-gray-900">Banner #${bannerNumber}</h4>
                        <button type="button" class="remove-main-banner text-red-600 hover:text-red-700 text-sm">
                            Remove
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Banner Image</label>
                            <input type="file" name="main_banner_image[]" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            <p class="mt-1 text-xs text-gray-500">JPG, PNG, GIF, SVG - Max 2MB</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Redirect Link</label>
                            <input type="url" name="main_banner_link[]" placeholder="https://example.com" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>
            `;
            
            mainBannersContainer.insertAdjacentHTML('beforeend', newBannerHtml);
            updateMainBannerCount();
        });
        
        // Remove main banner
        mainBannersContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-main-banner')) {
                const bannerItem = e.target.closest('.main-banner-item');
                const mainBannerItems = mainBannersContainer.querySelectorAll('.main-banner-item');
                
                if (mainBannerItems.length > 1) {
                    bannerItem.remove();
                    // Update banner numbers
                    mainBannersContainer.querySelectorAll('.main-banner-item').forEach((item, index) => {
                        item.querySelector('h4').textContent = `Banner #${index + 1}`;
                    });
                    updateMainBannerCount();
                }
            }
        });
        
        // Initialize
        updateMainBannerCount();
    });
</script>
@endsection
