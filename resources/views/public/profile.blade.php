@extends('public.layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden" x-data="{ activeTab: 'profile' }">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-8">
            <h1 class="text-3xl font-bold text-white">Edit Profile</h1>
            <p class="text-blue-100 mt-2">Update your personal information and preferences</p>
        </div>

        <!-- Success/Error Messages (will be shown via SweetAlert2) -->
        @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('
                    success ') }}',
                    timer: 3000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            });
        </script>
        @endif

        @if($errors->any())
        <div class="mx-6 mt-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Tabs Navigation -->
        <div class="px-6 pt-6 border-b border-gray-200">
            <nav class="flex space-x-8" aria-label="Tabs">
                <button @click="activeTab = 'profile'"
                    :class="activeTab === 'profile' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Profile Settings
                </button>
                <button @click="activeTab = 'password'"
                    :class="activeTab === 'password' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Change Password
                </button>
                <button @click="activeTab = 'shipping'; setTimeout(() => loadShippingAddresses(), 100)"
                    :class="activeTab === 'shipping' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Shipping Address
                </button>
            </nav>
        </div>

        <!-- Profile Settings Tab -->
        <div x-show="activeTab === 'profile'" x-cloak>
            <form id="profileForm" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="p-6 space-y-8">
                @csrf

                @php
                $userData = session('user_data', []);
                $coverImageRaw = $userData['cover_image'] ?? null;
                $profilePictureRaw = $userData['profile_picture'] ?? $userData['image'] ?? $userData['avatar'] ?? null;
                $userName = $userData['name'] ?? 'User';
                $userInitials = strtoupper(substr($userName, 0, 1));

                // Convert image path/URL to API storage URL for display
                $apiBaseUrl = config('api.base_url');

                $coverImage = null;
                if ($coverImageRaw) {
                    // If it's already a full URL (data URL or http/https), use as is
                    if (str_starts_with($coverImageRaw, 'data:') || str_starts_with($coverImageRaw, 'http://') || str_starts_with($coverImageRaw, 'https://')) {
                        $coverImage = $coverImageRaw;
                    }
                    // If it starts with /, it's an absolute path from API storage
                    elseif (str_starts_with($coverImageRaw, '/')) {
                        // If path is /cover_images/ or /profile_pictures/, add /storage prefix
                        if (str_starts_with($coverImageRaw, '/cover_images/') || str_starts_with($coverImageRaw, '/profile_pictures/')) {
                            $coverImage = rtrim($apiBaseUrl, '/') . '/storage' . $coverImageRaw;
                        } else {
                            $coverImage = rtrim($apiBaseUrl, '/') . $coverImageRaw;
                        }
                    }
                    // If it contains / or ., it's a relative path from API storage
                    elseif (str_contains($coverImageRaw, '/') || str_contains($coverImageRaw, '.')) {
                        // If path starts with cover_images/ or profile_pictures/, add /storage prefix
                        if (str_starts_with($coverImageRaw, 'cover_images/') || str_starts_with($coverImageRaw, 'profile_pictures/')) {
                            $coverImage = rtrim($apiBaseUrl, '/') . '/storage/' . ltrim($coverImageRaw, '/');
                        } else {
                            $coverImage = rtrim($apiBaseUrl, '/') . '/' . ltrim($coverImageRaw, '/');
                        }
                    }
                    // Otherwise, assume it's base64 (shouldn't happen after API save, but handle it)
                    else {
                        $coverImage = 'data:image/jpeg;base64,' . $coverImageRaw;
                    }
                }

                $profilePicture = null;
                if ($profilePictureRaw) {
                    // If it's already a full URL (data URL or http/https), use as is
                    if (str_starts_with($profilePictureRaw, 'data:') || str_starts_with($profilePictureRaw, 'http://') || str_starts_with($profilePictureRaw, 'https://')) {
                        $profilePicture = $profilePictureRaw;
                    }
                    // If it starts with /, it's an absolute path from API storage
                    elseif (str_starts_with($profilePictureRaw, '/')) {
                        // If path is /cover_images/ or /profile_pictures/, add /storage prefix
                        if (str_starts_with($profilePictureRaw, '/cover_images/') || str_starts_with($profilePictureRaw, '/profile_pictures/')) {
                            $profilePicture = rtrim($apiBaseUrl, '/') . '/storage' . $profilePictureRaw;
                        } else {
                            $profilePicture = rtrim($apiBaseUrl, '/') . $profilePictureRaw;
                        }
                    }
                    // If it contains / or ., it's a relative path from API storage
                    elseif (str_contains($profilePictureRaw, '/') || str_contains($profilePictureRaw, '.')) {
                        // If path starts with cover_images/ or profile_pictures/, add /storage prefix
                        if (str_starts_with($profilePictureRaw, 'cover_images/') || str_starts_with($profilePictureRaw, 'profile_pictures/')) {
                            $profilePicture = rtrim($apiBaseUrl, '/') . '/storage/' . ltrim($profilePictureRaw, '/');
                        } else {
                            $profilePicture = rtrim($apiBaseUrl, '/') . '/' . ltrim($profilePictureRaw, '/');
                        }
                    }
                    // Otherwise, assume it's base64 (shouldn't happen after API save, but handle it)
                    else {
                        $profilePicture = 'data:image/jpeg;base64,' . $profilePictureRaw;
                    }
                }
                @endphp

                <!-- Profile Picture & Cover Image Section -->
                <div class="space-y-6">
                    <h2 class="text-xl font-semibold text-gray-900 border-b border-gray-200 pb-2">Profile Images</h2>

                    <!-- Cover Image -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cover Image</label>
                        <div class="relative">
                            @if($coverImage)
                            <div id="coverImagePreview" class="w-full h-48 bg-gray-200 rounded-lg overflow-hidden mb-3">
                                <img id="coverImagePreviewImg" src="{{ $coverImage }}" alt="Cover preview" class="w-full h-full object-cover">
                            </div>
                            <div id="coverImagePlaceholder" class="w-full h-48 bg-gray-200 rounded-lg flex items-center justify-center mb-3 hidden">
                                <p class="text-gray-500">No cover image selected</p>
                            </div>
                            @else
                            <div id="coverImagePreview" class="w-full h-48 bg-gray-200 rounded-lg overflow-hidden mb-3 hidden">
                                <img id="coverImagePreviewImg" src="" alt="Cover preview" class="w-full h-full object-cover">
                            </div>
                            <div id="coverImagePlaceholder" class="w-full h-48 bg-gray-200 rounded-lg flex items-center justify-center mb-3">
                                <p class="text-gray-500">No cover image selected</p>
                            </div>
                            @endif
                            <input type="file" id="coverImage" name="cover_image" accept="image/*" class="hidden" onchange="previewCoverImage(this)">
                            <button type="button" onclick="document.getElementById('coverImage').click()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium">
                                Choose Cover Image
                            </button>
                            <button type="button" id="removeCoverImage" onclick="removeCoverImage()" class="ml-2 px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors text-sm font-medium {{ $coverImage ? '' : 'hidden' }}">
                                Remove
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Recommended size: 1200x300px. Max file size: 1MB</p>
                    </div>

                    <!-- Profile Picture -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Profile Picture</label>
                        <div class="flex items-start gap-6">
                            <div class="relative">
                                @if($profilePicture)
                                <div id="profilePicturePreview" class="w-32 h-32 rounded-full bg-gray-200 overflow-hidden border-4 border-gray-300">
                                    <img id="profilePicturePreviewImg" src="{{ $profilePicture }}" alt="Profile preview" class="w-full h-full object-cover">
                                </div>
                                <div id="profilePicturePlaceholder" class="w-32 h-32 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold text-2xl border-4 border-gray-300 hidden">
                                    {{ $userInitials }}
                                </div>
                                @else
                                <div id="profilePicturePreview" class="w-32 h-32 rounded-full bg-gray-200 overflow-hidden border-4 border-gray-300 hidden">
                                    <img id="profilePicturePreviewImg" src="" alt="Profile preview" class="w-full h-full object-cover">
                                </div>
                                <div id="profilePicturePlaceholder" class="w-32 h-32 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold text-2xl border-4 border-gray-300">
                                    {{ $userInitials }}
                                </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <input type="file" id="profilePicture" name="profile_picture" accept="image/*" class="hidden" onchange="previewProfilePicture(this)">
                                <button type="button" onclick="document.getElementById('profilePicture').click()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium mb-2">
                                    Choose Profile Picture
                                </button>
                                <button type="button" id="removeProfilePicture" onclick="removeProfilePicture()" class="block px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors text-sm font-medium {{ $profilePicture ? '' : 'hidden' }}">
                                    Remove
                                </button>
                                <p class="text-xs text-gray-500 mt-2">Recommended size: 400x400px. Max file size: 1MB</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Personal Information -->
                <div class="space-y-6">
                    <h2 class="text-xl font-semibold text-gray-900 border-b border-gray-200 pb-2">Personal Information</h2>

                    @php
                    $userData = session('user_data', []);
                    $name = old('name', $userData['name'] ?? '');
                    $email = old('email', $userData['email'] ?? '');
                    $phoneNumber = old('phone_number', $userData['phone_number'] ?? '');
                    $taxIdNumber = old('tax_id_number', $userData['tax_id_number'] ?? '');
                    @endphp

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                            <input type="text" id="name" name="name" value="{{ $name }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address *</label>
                            <input type="email" id="email" name="email" value="{{ $email }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="text" id="phone_number" name="phone_number" value="{{ $phoneNumber }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="tax_id_number" class="block text-sm font-medium text-gray-700 mb-1">Tax ID Number</label>
                            <input type="text" id="tax_id_number" name="tax_id_number" value="{{ $taxIdNumber }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Privacy Settings -->
                <div class="space-y-6">
                    <h2 class="text-xl font-semibold text-gray-900 border-b border-gray-200 pb-2">Privacy Settings</h2>

                    <div class="space-y-4">
                        @php
                        $showEmail = old('show_email', $userData['show_email'] ?? false);
                        $showPhoneNumber = old('show_phone_number', $userData['show_phone_number'] ?? false);
                        $notifyOnMessage = old('notify_on_message', $userData['notify_on_message'] ?? true);

                        // Handle string values from API (convert to boolean)
                        if (is_string($showEmail)) {
                        $showEmail = in_array(strtolower($showEmail), ['1', 'true', 'yes', 'on']);
                        }
                        if (is_string($showPhoneNumber)) {
                        $showPhoneNumber = in_array(strtolower($showPhoneNumber), ['1', 'true', 'yes', 'on']);
                        }
                        if (is_string($notifyOnMessage)) {
                        $notifyOnMessage = in_array(strtolower($notifyOnMessage), ['1', 'true', 'yes', 'on']);
                        }
                        @endphp

                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div>
                                <label for="show_email" class="text-sm font-medium text-gray-900">Show Email Address</label>
                                <p class="text-xs text-gray-500 mt-1">Allow others to see your email address on your profile</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="show_email" name="show_email" value="1" {{ $showEmail ? 'checked' : '' }}
                                    class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div>
                                <label for="show_phone_number" class="text-sm font-medium text-gray-900">Show Phone Number</label>
                                <p class="text-xs text-gray-500 mt-1">Allow others to see your phone number on your profile</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="show_phone_number" name="show_phone_number" value="1" {{ $showPhoneNumber ? 'checked' : '' }}
                                    class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div>
                                <label for="notify_on_message" class="text-sm font-medium text-gray-900">Notify on Message</label>
                                <p class="text-xs text-gray-500 mt-1">Receive notifications when you receive a new message</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="notify_on_message" name="notify_on_message" value="1" {{ $notifyOnMessage ? 'checked' : '' }}
                                    class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
                    <a href="/" class="px-6 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" id="submitBtn" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        <span id="submitBtnText">Save Changes</span>
                        <span id="submitBtnLoading" class="hidden">Saving...</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Change Password Tab -->
        <div x-show="activeTab === 'password'" x-cloak>
            <form id="changePasswordForm" method="POST" action="{{ route('profile.change-password') }}" class="p-6 space-y-6">
                @csrf

                <div>
                    <h2 class="text-xl font-semibold text-gray-900 border-b border-gray-200 pb-2 mb-6">Change Password</h2>

                    <!-- Success/Error Messages -->
                    <div id="passwordSuccessMessage" class="hidden mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    </div>
                    <div id="passwordErrorMessage" class="hidden mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label for="old_password" class="block text-sm font-medium text-gray-700 mb-1">Current Password *</label>
                            <input type="password" id="old_password" name="old_password" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <div id="old_password_error" class="text-red-600 text-sm mt-1 hidden"></div>
                        </div>

                        <div>
                            <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">New Password *</label>
                            <input type="password" id="new_password" name="new_password" required minlength="8"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Password must be at least 8 characters long</p>
                            <div id="new_password_error" class="text-red-600 text-sm mt-1 hidden"></div>
                        </div>

                        <div>
                            <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password *</label>
                            <input type="password" id="confirm_password" name="confirm_password" required minlength="8"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <div id="confirm_password_error" class="text-red-600 text-sm mt-1 hidden"></div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-4 pt-6 border-t border-gray-200 mt-6">
                        <button type="button" onclick="resetPasswordForm()" class="px-6 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                            Cancel
                        </button>
                        <button type="submit" id="changePasswordBtn" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                            <span id="changePasswordBtnText">Change Password</span>
                            <span id="changePasswordBtnLoading" class="hidden">Changing...</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Shipping Address Tab -->
        <div x-show="activeTab === 'shipping'" x-cloak>
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-900">Shipping Addresses</h2>
                    <button onclick="openShippingAddressModal()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        + Add New Address
                    </button>
                </div>

                <!-- Success/Error Messages -->
                <div id="shippingSuccessMessage" class="hidden mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                </div>
                <div id="shippingErrorMessage" class="hidden mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                </div>

                <!-- Shipping Addresses List -->
                <div id="shippingAddressesList" class="space-y-4">
                    <div class="text-center py-8 text-gray-500">
                        <p>Loading addresses...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Shipping Address Modal -->
<div id="shippingAddressModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-gray-900" id="shippingModalTitle">Add Shipping Address</h3>
                <button onclick="closeShippingAddressModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="shippingAddressForm" class="space-y-4">
                @csrf
                <input type="hidden" id="shippingAddressId" name="id">

                <!-- Use Profile Data Switch -->
                <div class="mb-4 p-3 bg-gray-50 rounded-lg border border-gray-200">
                    <label class="flex items-center justify-between cursor-pointer">
                        <div>
                            <span class="text-sm font-medium text-gray-900">Use profile information</span>
                            <p class="text-xs text-gray-500 mt-1">Automatically fill name and phone from your profile</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="useProfileData" onchange="toggleUseProfileData(this.checked)"
                                class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </label>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="shipping_first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name *</label>
                        <input type="text" id="shipping_first_name" name="first_name" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <div id="shipping_first_name_error" class="text-red-600 text-sm mt-1 hidden"></div>
                    </div>

                    <div>
                        <label for="shipping_last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name *</label>
                        <input type="text" id="shipping_last_name" name="last_name" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <div id="shipping_last_name_error" class="text-red-600 text-sm mt-1 hidden"></div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="shipping_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="shipping_email" name="email"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <div id="shipping_email_error" class="text-red-600 text-sm mt-1 hidden"></div>
                    </div>

                    <div>
                        <label for="shipping_phone_number" class="block text-sm font-medium text-gray-700 mb-1">Phone Number *</label>
                        <input type="text" id="shipping_phone_number" name="phone_number" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <div id="shipping_phone_number_error" class="text-red-600 text-sm mt-1 hidden"></div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="shipping_address_type" class="block text-sm font-medium text-gray-700 mb-1">Address Type</label>
                        <select id="shipping_address_type" name="address_type"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select type</option>
                            <option value="home">Home</option>
                            <option value="office">Office</option>
                            <option value="other">Other</option>
                        </select>
                        <div id="shipping_address_type_error" class="text-red-600 text-sm mt-1 hidden"></div>
                    </div>

                    <div>
                        <label for="shipping_address_title" class="block text-sm font-medium text-gray-700 mb-1">Address Title</label>
                        <input type="text" id="shipping_address_title" name="address_title" placeholder="e.g., Home, Office"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <div id="shipping_address_title_error" class="text-red-600 text-sm mt-1 hidden"></div>
                    </div>
                </div>

                <div>
                    <label for="shipping_address_description" class="block text-sm font-medium text-gray-700 mb-1">Street Address *</label>
                    <textarea id="shipping_address_description" name="address_description" rows="2" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    <div id="shipping_address_description_error" class="text-red-600 text-sm mt-1 hidden"></div>
                </div>

                <div>
                    <label for="shipping_country_id" class="block text-sm font-medium text-gray-700 mb-1">Country *</label>
                    <select id="shipping_country_id" name="country_id" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Country</option>
                    </select>
                    <input type="hidden" id="shipping_country_name" name="country_name">
                    <div id="shipping_country_id_error" class="text-red-600 text-sm mt-1 hidden"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="shipping_state_id" class="block text-sm font-medium text-gray-700 mb-1">State/Province *</label>
                        <select id="shipping_state_id" name="state_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select State</option>
                        </select>
                        <input type="hidden" id="shipping_state_name" name="state_name">
                        <div id="shipping_state_id_error" class="text-red-600 text-sm mt-1 hidden"></div>
                    </div>

                    <div>
                        <label for="shipping_city_id" class="block text-sm font-medium text-gray-700 mb-1">City *</label>
                        <select id="shipping_city_id" name="city_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select City</option>
                        </select>
                        <input type="hidden" id="shipping_city_name" name="city_name">
                        <div id="shipping_city_id_error" class="text-red-600 text-sm mt-1 hidden"></div>
                    </div>

                    <div>
                        <label for="shipping_zip_code" class="block text-sm font-medium text-gray-700 mb-1">Zip Code *</label>
                        <input type="text" id="shipping_zip_code" name="zip_code" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <div id="shipping_zip_code_error" class="text-red-600 text-sm mt-1 hidden"></div>
                    </div>
                </div>

                <div>
                    <label class="flex items-center">
                        <input type="checkbox" id="shipping_is_default" name="is_default" value="1"
                            class="mr-2 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="text-sm font-medium text-gray-700">Set as default shipping address</span>
                    </label>
                </div>

                <div class="flex justify-end gap-4 pt-4 border-t border-gray-200">
                    <button type="button" onclick="closeShippingAddressModal()" class="px-6 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" id="saveShippingAddressBtn" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        <span id="saveShippingAddressBtnText">Save Address</span>
                        <span id="saveShippingAddressBtnLoading" class="hidden">Saving...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('js')
<!-- jQuery and Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<style>
    .select2-container--default .select2-selection--single {
        height: 42px;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        padding: 0.25rem;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 40px;
        padding-left: 0.75rem;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px;
        right: 0.5rem;
    }

    .select2-container {
        width: 100% !important;
    }

    .select2-dropdown {
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
    }
</style>
<script>
    // Store existing images when page loads (raw values for submission)
    let existingProfilePictureRaw = @json($profilePictureRaw ?? null);
    let existingCoverImageRaw = @json($coverImageRaw ?? null);

    // Store display URLs (already converted to data URLs in PHP)
    let existingProfilePicture = @json($profilePicture ?? null);
    let existingCoverImage = @json($coverImage ?? null);

    // Initialize existing images on page load - replace preview with saved data
    document.addEventListener('DOMContentLoaded', function() {
        // Handle profile picture - replace preview with saved data
        const profilePreviewImg = document.getElementById('profilePicturePreviewImg');
        const profilePreview = document.getElementById('profilePicturePreview');
        const profilePlaceholder = document.getElementById('profilePicturePlaceholder');
        const removeBtn = document.getElementById('removeProfilePicture');
        const profileInput = document.getElementById('profilePicture');

        if (existingProfilePicture && profilePreviewImg && profilePreview && profilePlaceholder) {
            // Replace preview with saved image
            profilePreviewImg.src = existingProfilePicture;
            profilePreview.classList.remove('hidden');
            profilePlaceholder.classList.add('hidden');
            if (removeBtn) removeBtn.classList.remove('hidden');

            // Store the raw existing image (base64 or URL) for submission
            if (existingProfilePictureRaw && profileInput) {
                profileInput.setAttribute('data-existing', existingProfilePictureRaw);
            }
        } else if (!existingProfilePicture && profilePreview && profilePlaceholder) {
            // No saved image, show placeholder
            profilePreview.classList.add('hidden');
            profilePlaceholder.classList.remove('hidden');
            if (removeBtn) removeBtn.classList.add('hidden');
        }

        // Handle cover image - replace preview with saved data
        const coverPreviewImg = document.getElementById('coverImagePreviewImg');
        const coverPreview = document.getElementById('coverImagePreview');
        const coverPlaceholder = document.getElementById('coverImagePlaceholder');
        const removeCoverBtn = document.getElementById('removeCoverImage');
        const coverInput = document.getElementById('coverImage');

        if (existingCoverImage && coverPreviewImg && coverPreview && coverPlaceholder) {
            // Replace preview with saved image
            coverPreviewImg.src = existingCoverImage;
            coverPreview.classList.remove('hidden');
            coverPlaceholder.classList.add('hidden');
            if (removeCoverBtn) removeCoverBtn.classList.remove('hidden');

            // Store the raw existing image (base64 or URL) for submission
            if (existingCoverImageRaw && coverInput) {
                coverInput.setAttribute('data-existing', existingCoverImageRaw);
            }
        } else if (!existingCoverImage && coverPreview && coverPlaceholder) {
            // No saved image, show placeholder
            coverPreview.classList.add('hidden');
            coverPlaceholder.classList.remove('hidden');
            if (removeCoverBtn) removeCoverBtn.classList.add('hidden');
        }
    });

    // Preview cover image and convert to base64
    function previewCoverImage(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const maxSize = 1 * 1024 * 1024; // 1MB in bytes

            // Validate file type - only images allowed
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
            if (!allowedTypes.includes(file.type)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid File Type',
                    text: 'Only JPEG, PNG, GIF, and WebP images are allowed.',
                    confirmButtonColor: '#3085d6'
                });
                input.value = ''; // Clear the input
                return;
            }

            // Validate file size
            if (file.size > maxSize) {
                Swal.fire({
                    icon: 'error',
                    title: 'File Too Large',
                    text: 'Cover image must be less than 1MB. Please choose a smaller file.',
                    confirmButtonColor: '#3085d6'
                });
                input.value = ''; // Clear the input
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('coverImagePreviewImg').src = e.target.result;
                document.getElementById('coverImagePreview').classList.remove('hidden');
                document.getElementById('coverImagePlaceholder').classList.add('hidden');
                document.getElementById('removeCoverImage').classList.remove('hidden');

                // Store base64 string (remove data:image/...;base64, prefix for storage)
                const base64String = e.target.result.split(',')[1];
                document.getElementById('coverImage').setAttribute('data-base64', base64String);
            };
            reader.readAsDataURL(file);
        }
    }

    // Remove cover image
    function removeCoverImage() {
        document.getElementById('coverImage').value = '';
        document.getElementById('coverImage').removeAttribute('data-base64');
        document.getElementById('coverImage').setAttribute('data-removed', 'true');
        document.getElementById('coverImagePreview').classList.add('hidden');
        document.getElementById('coverImagePlaceholder').classList.remove('hidden');
        document.getElementById('removeCoverImage').classList.add('hidden');
    }

    // Preview profile picture and convert to base64
    function previewProfilePicture(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const maxSize = 1 * 1024 * 1024; // 1MB in bytes

            // Validate file type - only images allowed
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
            if (!allowedTypes.includes(file.type)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid File Type',
                    text: 'Only JPEG, PNG, GIF, and WebP images are allowed.',
                    confirmButtonColor: '#3085d6'
                });
                input.value = ''; // Clear the input
                return;
            }

            // Validate file size
            if (file.size > maxSize) {
                Swal.fire({
                    icon: 'error',
                    title: 'File Too Large',
                    text: 'Profile picture must be less than 1MB. Please choose a smaller file.',
                    confirmButtonColor: '#3085d6'
                });
                input.value = ''; // Clear the input
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profilePicturePreviewImg').src = e.target.result;
                document.getElementById('profilePicturePreview').classList.remove('hidden');
                document.getElementById('profilePicturePlaceholder').classList.add('hidden');
                document.getElementById('removeProfilePicture').classList.remove('hidden');

                // Store base64 string (remove data:image/...;base64, prefix for storage)
                const base64String = e.target.result.split(',')[1];
                document.getElementById('profilePicture').setAttribute('data-base64', base64String);
                document.getElementById('profilePicture').removeAttribute('data-removed'); // Clear removed flag if new image selected
            };
            reader.readAsDataURL(file);
        }
    }

    // Remove profile picture
    function removeProfilePicture() {
        document.getElementById('profilePicture').value = '';
        document.getElementById('profilePicture').removeAttribute('data-base64');
        document.getElementById('profilePicture').setAttribute('data-removed', 'true');
        document.getElementById('profilePicturePreview').classList.add('hidden');
        document.getElementById('profilePicturePlaceholder').classList.remove('hidden');
        document.getElementById('removeProfilePicture').classList.add('hidden');
    }

    // Helper function to convert image URL/path to base64 (fetches actual image file)
    function convertImageUrlToBase64(imagePathOrUrl) {
        return new Promise((resolve, reject) => {
            // If it's already a base64 data URL, extract the base64 part
            if (imagePathOrUrl.startsWith('data:image')) {
                const base64Part = imagePathOrUrl.split(',')[1];
                resolve(base64Part);
                return;
            }

            // If it's already a base64 string (no data: prefix, no slashes, no extension), return as is
            if (!imagePathOrUrl.includes('/') && !imagePathOrUrl.includes('.')) {
                // Likely a base64 string without prefix
                resolve(imagePathOrUrl);
                return;
            }

            // Build full URL if it's a relative path
            let imageUrl = imagePathOrUrl;
            if (!imageUrl.startsWith('http://') && !imageUrl.startsWith('https://')) {
                // It's a relative path, prepend API base URL
                const apiBaseUrl = 'http://36.93.42.27:4340';
                if (imageUrl.startsWith('/')) {
                    imageUrl = apiBaseUrl + imageUrl;
                } else {
                    imageUrl = apiBaseUrl + '/' + imageUrl;
                }
            }

            console.log('Fetching image from URL to convert to base64:', imageUrl);

            // Fetch the actual image file from the URL and convert to base64
            fetch(imageUrl)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Failed to fetch image: ${response.status} ${response.statusText}`);
                    }
                    return response.blob();
                })
                .then(blob => {
                    // Check blob size (max 1MB)
                    if (blob.size > 1 * 1024 * 1024) {
                        reject(new Error('Image file is too large (max 1MB)'));
                        return;
                    }

                    const reader = new FileReader();
                    reader.onloadend = function() {
                        // Extract base64 part (remove data:image/...;base64, prefix)
                        const base64String = reader.result.split(',')[1];
                        console.log('Image converted to base64, length:', base64String.length);
                        resolve(base64String);
                    };
                    reader.onerror = function(error) {
                        reject(new Error('Failed to read image file: ' + error));
                    };
                    reader.readAsDataURL(blob);
                })
                .catch(error => {
                    console.error('Error fetching image:', imageUrl, error);
                    reject(new Error('Failed to fetch image from URL: ' + error.message));
                });
        });
    }

    // Handle profile form submission
    document.getElementById('profileForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = this;
        const submitBtn = document.getElementById('submitBtn');
        const submitBtnText = document.getElementById('submitBtnText');
        const submitBtnLoading = document.getElementById('submitBtnLoading');

        // Disable submit button
        submitBtn.disabled = true;
        submitBtnText.classList.add('hidden');
        submitBtnLoading.classList.remove('hidden');

        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
            form.querySelector('input[name="_token"]')?.value;

        // Prepare form data as JSON (with base64 strings)
        const formData = {
            _token: csrfToken,
            name: form.querySelector('#name').value,
            email: form.querySelector('#email').value,
            phone_number: form.querySelector('#phone_number').value || null,
            tax_id_number: form.querySelector('#tax_id_number').value || null,
            notify_on_message: form.querySelector('#notify_on_message').checked ? true : null,
            show_email: form.querySelector('#show_email').checked ? true : null,
            show_phone_number: form.querySelector('#show_phone_number').checked ? true : null,
        };

        // Handle profile picture
        const profilePictureInput = document.getElementById('profilePicture');
        const profilePictureBase64 = profilePictureInput.getAttribute('data-base64');
        const profilePictureRemoved = profilePictureInput.getAttribute('data-removed');
        const profilePictureExisting = profilePictureInput.getAttribute('data-existing');

        if (profilePictureRemoved === 'true') {
            // User explicitly removed the image
            formData.profile_picture = null;
        } else if (profilePictureBase64) {
            // User selected a new image
            formData.profile_picture = profilePictureBase64;
        } else if (profilePictureExisting) {
            // User didn't change the image, convert existing URL to base64
            // Note: We'll handle this conversion in the promise chain below
            formData._profilePictureExisting = profilePictureExisting;
        }

        // Handle cover image
        const coverImageInput = document.getElementById('coverImage');
        const coverImageBase64 = coverImageInput.getAttribute('data-base64');
        const coverImageRemoved = coverImageInput.getAttribute('data-removed');
        const coverImageExisting = coverImageInput.getAttribute('data-existing');

        if (coverImageRemoved === 'true') {
            // User explicitly removed the image
            formData.cover_image = null;
        } else if (coverImageBase64) {
            // User selected a new image
            formData.cover_image = coverImageBase64;
        } else if (coverImageExisting) {
            // User didn't change the image, convert existing URL to base64
            // Note: We'll handle this conversion in the promise chain below
            formData._coverImageExisting = coverImageExisting;
        }

        // Convert existing images to base64 if needed (before sending)
        const promises = [];

        if (formData._profilePictureExisting) {
            promises.push(
                convertImageUrlToBase64(formData._profilePictureExisting)
                .then(base64 => {
                    formData.profile_picture = base64;
                    delete formData._profilePictureExisting;
                })
                .catch(error => {
                    console.error('Error converting profile picture to base64:', error);
                    delete formData._profilePictureExisting;
                    // Don't include profile_picture if conversion fails
                })
            );
        }

        if (formData._coverImageExisting) {
            promises.push(
                convertImageUrlToBase64(formData._coverImageExisting)
                .then(base64 => {
                    formData.cover_image = base64;
                    delete formData._coverImageExisting;
                })
                .catch(error => {
                    console.error('Error converting cover image to base64:', error);
                    delete formData._coverImageExisting;
                    // Don't include cover_image if conversion fails
                })
            );
        }

        // Wait for all conversions to complete, then send request
        Promise.all(promises).then(() => {
            // Make AJAX request
            fetch('{{ route("profile.update") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => {
                    // Check if response is JSON
                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        return response.json();
                    }
                    // If not JSON, it might be a redirect or HTML response
                    return response.text().then(text => {
                        // Try to parse as JSON if possible
                        try {
                            return JSON.parse(text);
                        } catch (e) {
                            // If it's HTML (redirect response), treat as success
                            return {
                                success: true,
                                message: 'Profile updated successfully!'
                            };
                        }
                    });
                })
                .then(data => {
                    if (data.success || data.status === 'success' || (data.message && !data.errors)) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: data.message || 'Profile updated successfully!',
                            timer: 3000,
                            showConfirmButton: false,
                            toast: true,
                            position: 'top-end'
                        }).then(() => {
                            // Reload page to show updated data (including navbar)
                            // Use replace to avoid back button issues and ensure fresh session data
                            window.location.replace(window.location.href);
                        });
                    } else {
                        // Handle validation errors
                        let errorMessage = data.message || 'Failed to update profile.';
                        if (data.errors) {
                            if (typeof data.errors === 'object') {
                                const errorMessages = Object.values(data.errors).flat();
                                errorMessage = errorMessages.join(' ');
                            } else {
                                errorMessage = data.errors;
                            }
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage,
                            confirmButtonColor: '#3085d6'
                        });

                        submitBtn.disabled = false;
                        submitBtnText.classList.remove('hidden');
                        submitBtnLoading.classList.add('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while updating profile. Please try again.',
                        confirmButtonColor: '#3085d6'
                    });

                    submitBtn.disabled = false;
                    submitBtnText.classList.remove('hidden');
                    submitBtnLoading.classList.add('hidden');
                });
        }).catch(error => {
            // Error during image conversion
            console.error('Error converting images:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while processing images. Please try again.',
                confirmButtonColor: '#3085d6'
            });

            submitBtn.disabled = false;
            submitBtnText.classList.remove('hidden');
            submitBtnLoading.classList.add('hidden');
        });
    });

    // Handle change password form submission
    document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = this;
        const submitBtn = document.getElementById('changePasswordBtn');
        const submitBtnText = document.getElementById('changePasswordBtnText');
        const submitBtnLoading = document.getElementById('changePasswordBtnLoading');

        // Clear previous errors
        document.getElementById('passwordSuccessMessage').classList.add('hidden');
        document.getElementById('passwordErrorMessage').classList.add('hidden');
        document.getElementById('old_password_error').classList.add('hidden');
        document.getElementById('new_password_error').classList.add('hidden');
        document.getElementById('confirm_password_error').classList.add('hidden');

        // Get form values
        const oldPassword = document.getElementById('old_password').value;
        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('confirm_password').value;

        // Validation
        if (!oldPassword || !newPassword || !confirmPassword) {
            showPasswordError('Please fill in all fields.');
            return;
        }

        if (newPassword.length < 8) {
            showPasswordError('New password must be at least 8 characters long.');
            document.getElementById('new_password_error').textContent = 'Password must be at least 8 characters long.';
            document.getElementById('new_password_error').classList.remove('hidden');
            return;
        }

        if (newPassword !== confirmPassword) {
            showPasswordError('New password and confirm password do not match.');
            document.getElementById('confirm_password_error').textContent = 'Passwords do not match.';
            document.getElementById('confirm_password_error').classList.remove('hidden');
            return;
        }

        // Disable submit button
        submitBtn.disabled = true;
        submitBtnText.classList.add('hidden');
        submitBtnLoading.classList.remove('hidden');

        // Get CSRF token - try meta tag first, fallback to form input
        let csrfToken = null;
        const csrfMeta = document.querySelector('meta[name="csrf-token"]');
        if (csrfMeta) {
            csrfToken = csrfMeta.getAttribute('content');
        } else {
            // Fallback: get from form's CSRF input
            const csrfInput = form.querySelector('input[name="_token"]');
            if (csrfInput) {
                csrfToken = csrfInput.value;
            }
        }

        if (!csrfToken) {
            showPasswordError('CSRF token not found. Please refresh the page and try again.');
            submitBtn.disabled = false;
            submitBtnText.classList.remove('hidden');
            submitBtnLoading.classList.add('hidden');
            return;
        }

        // Make API request (token will be handled by backend)
        fetch('{{ route("profile.change-password") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    old_password: oldPassword,
                    new_password: newPassword,
                    confirm_password: confirmPassword
                })
            })
            .then(response => {
                return response.json().then(data => {
                    return {
                        response,
                        data
                    };
                });
            })
            .then(({
                response,
                data
            }) => {
                if (response.ok && (data.status === 'success' || !data.status)) {
                    showPasswordSuccess(data.message || 'Password changed successfully!');
                    form.reset();
                } else {
                    // Handle authentication errors - redirect to login
                    if (response.status === 401 || data.requires_login || data.message === 'Unauthenticated.' || data.message?.includes('session has expired')) {
                        showPasswordError(data.message || 'Your session has expired. Please login again.');
                        setTimeout(() => {
                            window.location.href = '/login';
                        }, 2000);
                        return;
                    }

                    // Handle validation errors
                    if (data.errors && Object.keys(data.errors).length > 0) {
                        let errorMessages = [];
                        Object.keys(data.errors).forEach(field => {
                            const messages = Array.isArray(data.errors[field]) ? data.errors[field] : [data.errors[field]];
                            messages.forEach(msg => {
                                errorMessages.push(msg);
                                // Show field-specific errors
                                const errorElement = document.getElementById(field + '_error');
                                if (errorElement) {
                                    errorElement.textContent = msg;
                                    errorElement.classList.remove('hidden');
                                }
                            });
                        });
                        showPasswordError(errorMessages.join(' ') || data.message || 'Failed to change password.');
                    } else {
                        showPasswordError(data.message || 'Failed to change password.');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showPasswordError('An error occurred. Please try again.');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtnText.classList.remove('hidden');
                submitBtnLoading.classList.add('hidden');
            });
    });

    function showPasswordSuccess(message) {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: message,
            timer: 3000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    }

    function showPasswordError(message) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: message,
            confirmButtonColor: '#3085d6'
        });
    }

    function resetPasswordForm() {
        document.getElementById('changePasswordForm').reset();
        document.getElementById('passwordSuccessMessage').classList.add('hidden');
        document.getElementById('passwordErrorMessage').classList.add('hidden');
        document.getElementById('old_password_error').classList.add('hidden');
        document.getElementById('new_password_error').classList.add('hidden');
        document.getElementById('confirm_password_error').classList.add('hidden');
    }

    // ========== Shipping Address Functions ==========

    // Load shipping addresses from API
    function loadShippingAddresses() {
        const listContainer = document.getElementById('shippingAddressesList');
        if (!listContainer) return;

        listContainer.innerHTML = '<div class="text-center py-8 text-gray-500"><p>Loading addresses...</p></div>';

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        fetch('{{ route("profile.shipping-address.index") }}', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success' && data.data && Array.isArray(data.data)) {
                    renderShippingAddresses(data.data);
                } else {
                    listContainer.innerHTML = '<div class="text-center py-8 text-gray-500"><p>No shipping addresses found. Click "Add New Address" to create one.</p></div>';
                }
            })
            .catch(error => {
                console.error('Error loading shipping addresses:', error);
                listContainer.innerHTML = '<div class="text-center py-8 text-red-500"><p>Error loading addresses. Please try again.</p></div>';
            });
    }

    // Render shipping addresses list
    function renderShippingAddresses(addresses) {
        const listContainer = document.getElementById('shippingAddressesList');

        if (addresses.length === 0) {
            listContainer.innerHTML = '<div class="text-center py-8 text-gray-500"><p>No shipping addresses found. Click "Add New Address" to create one.</p></div>';
            return;
        }

        listContainer.innerHTML = addresses.map((address) => {
            // Map new API response structure to display format
            const fullName = [address.first_name || '', address.last_name || ''].filter(Boolean).join(' ') || address.address_title || 'N/A';
            const phone = address.phone_number || 'N/A';
            const addressText = address.address_description || 'N/A';
            const location = [
                address.city_name || address.city || '',
                address.state_name || address.province || '',
                address.zip_code || address.postal_code || ''
            ].filter(Boolean).join(', ') || 'N/A';

            return `
            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <h4 class="font-semibold text-gray-900">${escapeHtml(fullName)}</h4>
                            ${address.address_title ? `<span class="px-2 py-1 text-xs bg-gray-600 text-white rounded">${escapeHtml(address.address_title)}</span>` : ''}
                        </div>
                        ${address.email ? `<p class="text-sm text-gray-600 mb-1">${escapeHtml(address.email)}</p>` : ''}
                        <p class="text-sm text-gray-600 mb-1">${escapeHtml(phone)}</p>
                        <p class="text-sm text-gray-600 mb-1">${escapeHtml(addressText)}</p>
                        <p class="text-sm text-gray-600">${escapeHtml(location)}</p>
                        ${address.country_name ? `<p class="text-xs text-gray-500 mt-1">${escapeHtml(address.country_name)}</p>` : ''}
                    </div>
                    <div class="flex gap-2 ml-4">
                        <button onclick="editShippingAddress('${address.id}')" class="px-3 py-1 text-sm text-blue-600 hover:text-blue-800 border border-blue-600 rounded hover:bg-blue-50">
                            Edit
                        </button>
                        <button onclick="deleteShippingAddress('${address.id}')" class="px-3 py-1 text-sm text-red-600 hover:text-red-800 border border-red-600 rounded hover:bg-red-50">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
            `;
        }).join('');
    }

    // Open shipping address modal
    function openShippingAddressModal(addressId = null) {
        const modal = document.getElementById('shippingAddressModal');
        const form = document.getElementById('shippingAddressForm');
        const title = document.getElementById('shippingModalTitle');
        const useProfileCheckbox = document.getElementById('useProfileData');

        // Clear form
        form.reset();
        document.getElementById('shippingAddressId').value = '';
        clearShippingErrors();

        // Reset use profile data switch
        if (useProfileCheckbox) {
            useProfileCheckbox.checked = false;
        }

        // Reset field states
        const nameField = document.getElementById('shipping_name');
        const phoneField = document.getElementById('shipping_phone');
        if (nameField) {
            nameField.readOnly = false;
            nameField.classList.remove('bg-gray-100', 'cursor-not-allowed');
        }
        if (phoneField) {
            phoneField.readOnly = false;
            phoneField.classList.remove('bg-gray-100', 'cursor-not-allowed');
        }

        // Initialize Select2 on dropdowns
        $('#shipping_country_id').select2({
            placeholder: 'Select Country',
            allowClear: true,
            width: '100%'
        }).on('change', function() {
            loadStates($(this).val());
        });

        $('#shipping_state_id').select2({
            placeholder: 'Select State',
            allowClear: true,
            width: '100%'
        }).on('change', function() {
            loadCities($(this).val());
        });

        $('#shipping_city_id').select2({
            placeholder: 'Select City',
            allowClear: true,
            width: '100%'
        }).on('change', function() {
            updateCityName(this);
        });

        if (addressId) {
            title.textContent = 'Edit Shipping Address';
            // Load countries first, then load address data
            loadCountries().then(() => {
                // Wait a bit more to ensure Select2 is fully ready
                setTimeout(() => {
                    loadShippingAddress(addressId);
                }, 500);
            }).catch(() => {
                // If countries fail to load, still try to load address
                setTimeout(() => {
                    loadShippingAddress(addressId);
                }, 1000);
            });
        } else {
            title.textContent = 'Add Shipping Address';
            // Load countries for new address
            loadCountries();
            // Reset dropdowns
            $('#shipping_state_id').empty().append('<option value="">Select State</option>').val('').trigger('change');
            $('#shipping_city_id').empty().append('<option value="">Select City</option>').val('').trigger('change');
        }

        modal.classList.remove('hidden');
    }

    // Load countries - returns a promise
    function loadCountries() {
        return new Promise((resolve, reject) => {
            fetch('{{ route("api.world.countries") }}', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const countrySelect = $('#shipping_country_id');
                    if (data.status === 'success' && data.data && Array.isArray(data.data)) {
                        // Clear existing options except the first one
                        countrySelect.empty().append('<option value="">Select Country</option>');
                        data.data.forEach(country => {
                            const option = $('<option></option>')
                                .attr('value', country.id || country.country_id || '')
                                .text(country.name || country.country_name || '');
                            countrySelect.append(option);
                        });
                        // Reinitialize Select2
                        countrySelect.select2({
                            placeholder: 'Select Country',
                            allowClear: true,
                            width: '100%'
                        }).on('change', function() {
                            loadStates($(this).val());
                        });
                        resolve();
                    } else {
                        reject('Failed to load countries');
                    }
                })
                .catch(error => {
                    console.error('Error loading countries:', error);
                    reject(error);
                });
        });
    }

    // Load states by country
    function loadStates(countryId) {
        if (!countryId) {
            const stateSelect = $('#shipping_state_id');
            const citySelect = $('#shipping_city_id');
            stateSelect.empty().append('<option value="">Select State</option>').val('').trigger('change');
            citySelect.empty().append('<option value="">Select City</option>').val('').trigger('change');
            return;
        }

        // Update country name
        const countrySelect = $('#shipping_country_id');
        const selectedText = countrySelect.find('option:selected').text();
        document.getElementById('shipping_country_name').value = selectedText || '';

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        fetch('{{ route("api.world.states") }}', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    country_id: parseInt(countryId)
                })
            })
            .then(response => response.json())
            .then(data => {
                const stateSelect = $('#shipping_state_id');
                if (data.status === 'success' && data.data && Array.isArray(data.data)) {
                    stateSelect.empty().append('<option value="">Select State</option>');
                    data.data.forEach(state => {
                        const option = $('<option></option>')
                            .attr('value', state.id || state.state_id || '')
                            .text(state.name || state.state_name || '');
                        stateSelect.append(option);
                    });
                    // Reinitialize Select2
                    stateSelect.select2({
                        placeholder: 'Select State',
                        allowClear: true,
                        width: '100%'
                    }).on('change', function() {
                        loadCities($(this).val());
                    });
                }
                // Reset city dropdown
                const citySelect = $('#shipping_city_id');
                citySelect.empty().append('<option value="">Select City</option>').val('').trigger('change');
            })
            .catch(error => {
                console.error('Error loading states:', error);
            });
    }

    // Load cities by state
    function loadCities(stateId) {
        if (!stateId) {
            const citySelect = $('#shipping_city_id');
            citySelect.empty().append('<option value="">Select City</option>').val('').trigger('change');
            document.getElementById('shipping_city_name').value = '';
            return;
        }

        // Update state name
        const stateSelect = $('#shipping_state_id');
        const selectedText = stateSelect.find('option:selected').text();
        document.getElementById('shipping_state_name').value = selectedText || '';

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        fetch('{{ route("api.world.cities") }}', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    state_id: parseInt(stateId)
                })
            })
            .then(response => response.json())
            .then(data => {
                const citySelect = $('#shipping_city_id');
                if (data.status === 'success' && data.data && Array.isArray(data.data)) {
                    citySelect.empty().append('<option value="">Select City</option>');
                    data.data.forEach(city => {
                        const option = $('<option></option>')
                            .attr('value', city.id || city.city_id || '')
                            .text(city.name || city.city_name || '');
                        citySelect.append(option);
                    });
                    // Reinitialize Select2
                    citySelect.select2({
                        placeholder: 'Select City',
                        allowClear: true,
                        width: '100%'
                    }).on('change', function() {
                        updateCityName(this);
                    });
                }
            })
            .catch(error => {
                console.error('Error loading cities:', error);
            });
    }

    // Update city name when city is selected
    function updateCityName(citySelect) {
        const $select = $(citySelect);
        const selectedText = $select.find('option:selected').text();
        document.getElementById('shipping_city_name').value = selectedText || '';
    }

    // Close shipping address modal
    function closeShippingAddressModal() {
        document.getElementById('shippingAddressModal').classList.add('hidden');
        document.getElementById('shippingAddressForm').reset();
        clearShippingErrors();

        // Reset dropdowns and destroy Select2
        $('#shipping_country_id').val('').trigger('change');
        $('#shipping_state_id').empty().append('<option value="">Select State</option>').val('').trigger('change');
        $('#shipping_city_id').empty().append('<option value="">Select City</option>').val('').trigger('change');
        document.getElementById('shipping_country_name').value = '';
        document.getElementById('shipping_state_name').value = '';
        document.getElementById('shipping_city_name').value = '';
    }

    // Load single shipping address for editing
    function loadShippingAddress(id) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        // Build the show URL - route expects /profile/shipping-address/{id}
        const showUrl = `/profile/shipping-address/${id}`;

        fetch(showUrl, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    id: id
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success' && data.data) {
                    const addr = data.data;
                    document.getElementById('shippingAddressId').value = addr.id || '';
                    document.getElementById('shipping_first_name').value = addr.first_name || '';
                    document.getElementById('shipping_last_name').value = addr.last_name || '';
                    document.getElementById('shipping_email').value = addr.email || '';
                    document.getElementById('shipping_phone_number').value = addr.phone_number || '';
                    if (document.getElementById('shipping_address_type')) {
                        document.getElementById('shipping_address_type').value = addr.address_type || '';
                    }
                    document.getElementById('shipping_address_title').value = addr.address_title || '';
                    document.getElementById('shipping_address_description').value = addr.address_description || '';
                    document.getElementById('shipping_zip_code').value = addr.zip_code || '';

                    // Store address data for later use
                    window.currentEditingAddress = addr;

                    // Set country, state, and city - countries should already be loaded
                    setCountryStateCity(addr);
                } else {
                    showShippingError(data.message || 'Failed to load address details.');
                }
            })
            .catch(error => {
                console.error('Error loading shipping address:', error);
                showShippingError('Failed to load address details.');
            });
    }

    // Helper function to set country, state, and city with proper Select2 updates
    function setCountryStateCity(addr) {
        const countrySelect = $('#shipping_country_id');
        const stateSelect = $('#shipping_state_id');
        const citySelect = $('#shipping_city_id');

        // Convert IDs to strings for comparison
        const countryId = String(addr.country_id || '');
        const stateId = String(addr.state_id || '');
        const cityId = String(addr.city_id || '');

        // Set country
        if (countryId) {
            // Wait to ensure Select2 is ready
            setTimeout(() => {
                // Try to find country by value (try both string and number)
                let countryOption = countrySelect.find(`option[value="${countryId}"]`);
                if (countryOption.length === 0) {
                    // Try with integer value
                    countryOption = countrySelect.find(`option[value="${parseInt(countryId)}"]`);
                }

                if (countryOption.length > 0) {
                    // Set country value - use the actual value from the option
                    const actualValue = countryOption.attr('value');
                    countrySelect.val(actualValue);
                    countrySelect.trigger('change.select2');
                    document.getElementById('shipping_country_name').value = addr.country_name || '';

                    // Wait before loading states
                    setTimeout(() => {
                        loadStatesForEdit(actualValue, stateId, addr.state_name, cityId, addr.city_name);
                    }, 800);
                } else {
                    // Country not found, try again after a longer delay
                    console.log('Country not found, retrying...', countryId);
                    setTimeout(() => {
                        countryOption = countrySelect.find(`option[value="${countryId}"]`);
                        if (countryOption.length === 0) {
                            countryOption = countrySelect.find(`option[value="${parseInt(countryId)}"]`);
                        }
                        if (countryOption.length > 0) {
                            const actualValue = countryOption.attr('value');
                            countrySelect.val(actualValue);
                            countrySelect.trigger('change.select2');
                            document.getElementById('shipping_country_name').value = addr.country_name || '';
                            setTimeout(() => {
                                loadStatesForEdit(actualValue, stateId, addr.state_name, cityId, addr.city_name);
                            }, 800);
                        }
                    }, 1000);
                }
            }, 500);
        }
    }

    // Helper function to load states and set state/city for editing
    function loadStatesForEdit(countryId, stateId, stateName, cityId, cityName) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        const stateSelect = $('#shipping_state_id');

        fetch('{{ route("api.world.states") }}', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    country_id: parseInt(countryId)
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success' && data.data && Array.isArray(data.data)) {
                    stateSelect.empty().append('<option value="">Select State</option>');
                    data.data.forEach(state => {
                        const option = $('<option></option>')
                            .attr('value', state.id || state.state_id || '')
                            .text(state.name || state.state_name || '');
                        stateSelect.append(option);
                    });

                    // Reinitialize Select2
                    stateSelect.select2({
                        placeholder: 'Select State',
                        allowClear: true,
                        width: '100%'
                    }).on('change', function() {
                        loadCities($(this).val());
                    });

                    // Set state value after Select2 is ready
                    if (stateId) {
                        setTimeout(() => {
                            // Try to find state by value (try both string and number)
                            let stateOption = stateSelect.find(`option[value="${stateId}"]`);
                            if (stateOption.length === 0) {
                                stateOption = stateSelect.find(`option[value="${parseInt(stateId)}"]`);
                            }

                            if (stateOption.length > 0) {
                                const actualValue = stateOption.attr('value');
                                stateSelect.val(actualValue);
                                stateSelect.trigger('change.select2');
                                document.getElementById('shipping_state_name').value = stateName || '';

                                // Wait before loading cities
                                setTimeout(() => {
                                    loadCitiesForEdit(actualValue, cityId, cityName);
                                }, 800);
                            } else {
                                // State not found, try again
                                console.log('State not found, retrying...', stateId);
                                setTimeout(() => {
                                    stateOption = stateSelect.find(`option[value="${stateId}"]`);
                                    if (stateOption.length === 0) {
                                        stateOption = stateSelect.find(`option[value="${parseInt(stateId)}"]`);
                                    }
                                    if (stateOption.length > 0) {
                                        const actualValue = stateOption.attr('value');
                                        stateSelect.val(actualValue);
                                        stateSelect.trigger('change.select2');
                                        document.getElementById('shipping_state_name').value = stateName || '';
                                        setTimeout(() => {
                                            loadCitiesForEdit(actualValue, cityId, cityName);
                                        }, 800);
                                    }
                                }, 500);
                            }
                        }, 500);
                    }
                }
            })
            .catch(error => {
                console.error('Error loading states:', error);
            });
    }

    // Helper function to load cities and set city for editing
    function loadCitiesForEdit(stateId, cityId, cityName) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        const citySelect = $('#shipping_city_id');

        fetch('{{ route("api.world.cities") }}', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    state_id: parseInt(stateId)
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success' && data.data && Array.isArray(data.data)) {
                    citySelect.empty().append('<option value="">Select City</option>');
                    data.data.forEach(city => {
                        const option = $('<option></option>')
                            .attr('value', city.id || city.city_id || '')
                            .text(city.name || city.city_name || '');
                        citySelect.append(option);
                    });

                    // Reinitialize Select2
                    citySelect.select2({
                        placeholder: 'Select City',
                        allowClear: true,
                        width: '100%'
                    }).on('change', function() {
                        updateCityName(this);
                    });

                    // Set city value after Select2 is ready
                    if (cityId) {
                        setTimeout(() => {
                            // Try to find city by value (try both string and number)
                            let cityOption = citySelect.find(`option[value="${cityId}"]`);
                            if (cityOption.length === 0) {
                                cityOption = citySelect.find(`option[value="${parseInt(cityId)}"]`);
                            }

                            if (cityOption.length > 0) {
                                const actualValue = cityOption.attr('value');
                                citySelect.val(actualValue);
                                citySelect.trigger('change.select2');
                                document.getElementById('shipping_city_name').value = cityName || '';
                            } else {
                                // City not found, try again
                                console.log('City not found, retrying...', cityId);
                                setTimeout(() => {
                                    cityOption = citySelect.find(`option[value="${cityId}"]`);
                                    if (cityOption.length === 0) {
                                        cityOption = citySelect.find(`option[value="${parseInt(cityId)}"]`);
                                    }
                                    if (cityOption.length > 0) {
                                        const actualValue = cityOption.attr('value');
                                        citySelect.val(actualValue);
                                        citySelect.trigger('change.select2');
                                        document.getElementById('shipping_city_name').value = cityName || '';
                                    }
                                }, 500);
                            }
                        }, 500);
                    }
                }
            })
            .catch(error => {
                console.error('Error loading cities:', error);
            });
    }

    function editShippingAddress(id) {
        openShippingAddressModal(id);
    }

    // Toggle use profile data
    function toggleUseProfileData(enabled) {
        const firstNameField = document.getElementById('shipping_first_name');
        const lastNameField = document.getElementById('shipping_last_name');
        const phoneField = document.getElementById('shipping_phone_number');
        const emailField = document.getElementById('shipping_email');

        if (enabled) {
            // Get profile data from session (passed via Blade)
            const profileName = '{{ session("user_data.name", "") }}';
            const profilePhone = '{{ session("user_data.phone_number", "") }}';
            const profileEmail = '{{ session("user_data.email", "") }}';

            // Split name into first and last name
            if (profileName) {
                const nameParts = profileName.trim().split(/\s+/);
                firstNameField.value = nameParts[0] || '';
                lastNameField.value = nameParts.slice(1).join(' ') || '';
            }
            if (profilePhone) {
                phoneField.value = profilePhone;
            }
            if (profileEmail) {
                emailField.value = profileEmail;
            }

            // Disable fields if data is loaded
            if (profileName) {
                firstNameField.readOnly = true;
                lastNameField.readOnly = true;
                firstNameField.classList.add('bg-gray-100', 'cursor-not-allowed');
                lastNameField.classList.add('bg-gray-100', 'cursor-not-allowed');
            }
            if (profilePhone) {
                phoneField.readOnly = true;
                phoneField.classList.add('bg-gray-100', 'cursor-not-allowed');
            }
            if (profileEmail) {
                emailField.readOnly = true;
                emailField.classList.add('bg-gray-100', 'cursor-not-allowed');
            }
        } else {
            // Re-enable fields
            firstNameField.readOnly = false;
            lastNameField.readOnly = false;
            phoneField.readOnly = false;
            emailField.readOnly = false;
            firstNameField.classList.remove('bg-gray-100', 'cursor-not-allowed');
            lastNameField.classList.remove('bg-gray-100', 'cursor-not-allowed');
            phoneField.classList.remove('bg-gray-100', 'cursor-not-allowed');
            emailField.classList.remove('bg-gray-100', 'cursor-not-allowed');
        }
    }

    // Make functions available globally
    window.loadShippingAddresses = loadShippingAddresses;
    // Delete shipping address
    function deleteShippingAddress(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to delete this shipping address? This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (!result.isConfirmed) {
                return;
            }

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

            // Build the delete URL - route expects /profile/shipping-address/{id}/delete
            const deleteUrl = `/profile/shipping-address/${id}/delete`;

            fetch(deleteUrl, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        id: id
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: data.message || 'Shipping address deleted successfully!',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        // Reload the addresses list
                        loadShippingAddresses();
                    } else {
                        showShippingError(data.message || 'Failed to delete shipping address.');
                    }
                })
                .catch(error => {
                    console.error('Error deleting shipping address:', error);
                    showShippingError('An error occurred while deleting the address. Please try again.');
                });
        });
    }

    window.openShippingAddressModal = openShippingAddressModal;
    window.closeShippingAddressModal = closeShippingAddressModal;
    window.editShippingAddress = editShippingAddress;
    window.toggleUseProfileData = toggleUseProfileData;
    window.loadCountries = loadCountries;
    window.loadStates = loadStates;
    window.loadCities = loadCities;
    window.updateCityName = updateCityName;
    window.deleteShippingAddress = deleteShippingAddress;

    // Handle shipping address form submission
    document.addEventListener('DOMContentLoaded', function() {
        const shippingForm = document.getElementById('shippingAddressForm');
        if (shippingForm) {
            shippingForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const form = this;
                const submitBtn = document.getElementById('saveShippingAddressBtn');
                const submitBtnText = document.getElementById('saveShippingAddressBtnText');
                const submitBtnLoading = document.getElementById('saveShippingAddressBtnLoading');
                const addressId = document.getElementById('shippingAddressId').value;

                // Clear previous errors
                clearShippingErrors();
                document.getElementById('shippingSuccessMessage').classList.add('hidden');
                document.getElementById('shippingErrorMessage').classList.add('hidden');

                // Get selected values from dropdowns using jQuery/Select2
                const $countrySelect = $('#shipping_country_id');
                const $stateSelect = $('#shipping_state_id');
                const $citySelect = $('#shipping_city_id');

                const countryId = $countrySelect.val() ? parseInt($countrySelect.val()) : null;
                const stateId = $stateSelect.val() ? parseInt($stateSelect.val()) : null;
                const cityId = $citySelect.val() ? parseInt($citySelect.val()) : null;

                // Get names from selected options
                const countryName = $countrySelect.find('option:selected').text() || document.getElementById('shipping_country_name').value || null;
                const stateName = $stateSelect.find('option:selected').text() || document.getElementById('shipping_state_name').value || null;
                const cityName = $citySelect.find('option:selected').text() || document.getElementById('shipping_city_name').value || null;

                // Get form data - map to new API structure (all fields required, can be null)
                const formData = {
                    id: addressId || null, // null for new addresses
                    user_id: null, // Will be set by backend from session
                    address_type: document.getElementById('shipping_address_type')?.value || null,
                    address_title: document.getElementById('shipping_address_title')?.value || null,
                    first_name: document.getElementById('shipping_first_name').value || null,
                    last_name: document.getElementById('shipping_last_name').value || null,
                    email: document.getElementById('shipping_email')?.value || null,
                    phone_number: document.getElementById('shipping_phone_number').value || null,
                    country_name: countryName,
                    state_id: stateId,
                    state_name: stateName,
                    city_id: cityId,
                    city_name: cityName,
                    zip_code: document.getElementById('shipping_zip_code').value || null,
                    address_description: document.getElementById('shipping_address_description').value || null,
                    created_at: null, // Will be set by API
                    updated_at: null, // Will be set by API
                    country_id: countryId,
                };

                // Validation
                if (!formData.first_name || !formData.last_name || !formData.phone_number ||
                    !formData.address_description || !formData.city_name || !formData.state_name || !formData.zip_code) {
                    showShippingError('Please fill in all required fields.');
                    return;
                }

                // Disable submit button
                submitBtn.disabled = true;
                submitBtnText.classList.add('hidden');
                submitBtnLoading.classList.remove('hidden');

                // Get CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                    form.querySelector('input[name="_token"]')?.value;

                // Always use store endpoint for both create and update
                const url = '{{ route("profile.shipping-address.store") }}';
                const method = 'POST';

                // Make API request
                fetch(url, {
                        method: method,
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify(formData)
                    })
                    .then(response => {
                        return response.json().then(data => {
                            return {
                                response,
                                data
                            };
                        });
                    })
                    .then(({
                        response,
                        data
                    }) => {
                        if (response.ok && (data.status === 'success' || !data.status)) {
                            showShippingSuccess(data.message || 'Shipping address saved successfully!');
                            form.reset();
                            setTimeout(() => {
                                closeShippingAddressModal();
                                loadShippingAddresses();
                            }, 1000);
                        } else {
                            // Handle validation errors
                            if (data.errors && Object.keys(data.errors).length > 0) {
                                let errorMessages = [];
                                // Map API field names to form field names
                                const fieldMapping = {
                                    'first_name': 'first_name',
                                    'last_name': 'last_name',
                                    'phone_number': 'phone_number',
                                    'address_description': 'address_description',
                                    'city_name': 'city_name',
                                    'state_name': 'state_name',
                                    'zip_code': 'zip_code',
                                    'email': 'email',
                                    'address_title': 'address_title',
                                    'city_id': 'city_name',
                                    'state_id': 'state_name',
                                    'country_id': 'country_name',
                                    'country_name': 'country_name',
                                };

                                Object.keys(data.errors).forEach(field => {
                                    const messages = Array.isArray(data.errors[field]) ? data.errors[field] : [data.errors[field]];
                                    const mappedField = fieldMapping[field] || field;
                                    messages.forEach(msg => {
                                        errorMessages.push(msg);
                                        const errorElement = document.getElementById('shipping_' + mappedField + '_error');
                                        if (errorElement) {
                                            errorElement.textContent = msg;
                                            errorElement.classList.remove('hidden');
                                        }
                                    });
                                });
                                showShippingError(errorMessages.join(' ') || data.message || 'Failed to save address.');
                            } else {
                                showShippingError(data.message || 'Failed to save address.');
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showShippingError('An error occurred. Please try again.');
                    })
                    .finally(() => {
                        submitBtn.disabled = false;
                        submitBtnText.classList.remove('hidden');
                        submitBtnLoading.classList.add('hidden');
                    });
            });
        }

        // Watch for tab changes to load addresses
        const profileContainer = document.querySelector('[x-data*="activeTab"]');
        if (profileContainer) {
            // Use Alpine.js reactive system
            setTimeout(() => {
                // Check if shipping tab is visible
                const checkShippingTab = setInterval(() => {
                    const shippingTab = document.querySelector('[x-show*="shipping"]');
                    if (shippingTab && !shippingTab.hasAttribute('x-cloak') && shippingTab.offsetParent !== null) {
                        clearInterval(checkShippingTab);
                        loadShippingAddresses();
                    }
                }, 200);

                // Clear interval after 10 seconds
                setTimeout(() => clearInterval(checkShippingTab), 10000);
            }, 500);
        }
    });

    function showShippingSuccess(message) {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: message,
            timer: 3000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    }

    function showShippingError(message) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: message,
            confirmButtonColor: '#3085d6'
        });
    }

    function clearShippingErrors() {
        document.querySelectorAll('[id^="shipping_"][id$="_error"]').forEach(el => {
            el.classList.add('hidden');
            el.textContent = '';
        });
    }

    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
</script>
@endpush

@endsection