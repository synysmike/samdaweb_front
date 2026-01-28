@extends('public.layouts.app')

@section('title', 'Register Shop')

<!-- jQuery and Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<style>
    .select2-container--default .select2-selection--single {
        height: 42px;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 42px;
        padding-left: 16px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px;
        right: 10px;
    }
    .select2-container {
        width: 100% !important;
    }
    .select2-dropdown {
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
    }
</style>

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-8">
            <h1 class="text-3xl font-bold text-white">Register Your Shop</h1>
            <p class="text-blue-100 mt-2">Complete your shop registration to start selling</p>
        </div>

        <!-- Registration Form -->
        <form id="shopRegistrationForm" class="p-6 space-y-6">
            <div>
                <label for="shopName" class="block text-sm font-medium text-gray-700 mb-2">Shop Name <span class="text-red-500">*</span></label>
                <input type="text" id="shopName" name="name" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Enter your shop name">
            </div>

            <div>
                <label for="shopDescription" class="block text-sm font-medium text-gray-700 mb-2">Shop Description</label>
                <textarea id="shopDescription" name="description" rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Describe your shop..."></textarea>
            </div>

            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="shopPhone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    @php
                        $userData = session('user_data', []);
                        $userPhone = $userData['phone_number'] ?? $userData['phone'] ?? null;
                    @endphp
                    @if($userPhone)
                    <label class="flex items-center text-sm text-blue-600 cursor-pointer">
                        <input type="checkbox" id="useProfilePhone" class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mr-2">
                        <span>Use my profile phone number</span>
                    </label>
                    @endif
                </div>
                <input type="tel" id="shopPhone" name="phone"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="+1234567890"
                    value="{{ $userPhone ?? '' }}">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="shopCountryId" class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                    <select id="shopCountryId" name="country_id"
                        class="w-full">
                        <option value="">Select Country</option>
                    </select>
                </div>

                <div>
                    <label for="shopStateId" class="block text-sm font-medium text-gray-700 mb-2">State</label>
                    <select id="shopStateId" name="state_id"
                        class="w-full">
                        <option value="">Select State</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="shopCityId" class="block text-sm font-medium text-gray-700 mb-2">City</label>
                    <select id="shopCityId" name="city_id"
                        class="w-full">
                        <option value="">Select City</option>
                    </select>
                </div>

                <div>
                    <label for="shopZipCode" class="block text-sm font-medium text-gray-700 mb-2">Zip Code</label>
                    <input type="text" id="shopZipCode" name="zip_code"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="12345">
                </div>
            </div>

            <div class="flex items-center">
                <input type="checkbox" id="shopTerms" name="terms" required
                    class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="shopTerms" class="ml-2 text-sm text-gray-700">
                    I agree to the <a href="{{ route('terms-conditions') }}" target="_blank" class="text-blue-600 hover:underline">Terms and Conditions</a> and <a href="{{ route('seller-agreement') }}" target="_blank" class="text-blue-600 hover:underline">Seller Agreement</a>
                </label>
            </div>

            <div class="flex justify-end space-x-3 pt-4">
                <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    Register Shop
                </button>
            </div>
        </form>
    </div>
</div>

@push('js')
<script>
    $(document).ready(function() {
        // Initialize Select2 on dropdowns
        $('#shopCountryId').select2({
            placeholder: 'Select Country',
            allowClear: true,
            width: '100%'
        }).on('change', function() {
            loadShopStates($(this).val());
        });

        $('#shopStateId').select2({
            placeholder: 'Select State',
            allowClear: true,
            width: '100%'
        }).on('change', function() {
            loadShopCities($(this).val());
        });

        $('#shopCityId').select2({
            placeholder: 'Select City',
            allowClear: true,
            width: '100%'
        });

        // Load countries on page load
        loadShopCountries();

        // Handle use profile phone checkbox
        @if($userPhone)
        const useProfilePhoneCheckbox = document.getElementById('useProfilePhone');
        const shopPhoneInput = document.getElementById('shopPhone');
        const profilePhone = '{{ $userPhone }}';

        if (useProfilePhoneCheckbox && shopPhoneInput) {
            useProfilePhoneCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    shopPhoneInput.value = profilePhone;
                    shopPhoneInput.readOnly = true;
                    shopPhoneInput.classList.add('bg-gray-100', 'cursor-not-allowed');
                } else {
                    shopPhoneInput.readOnly = false;
                    shopPhoneInput.classList.remove('bg-gray-100', 'cursor-not-allowed');
                }
            });
        }
        @endif
    });

    // Load countries
    function loadShopCountries() {
        fetch('{{ route("api.world.countries") }}', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            const countrySelect = $('#shopCountryId');
            if (data.status === 'success' && data.data && Array.isArray(data.data)) {
                countrySelect.empty().append('<option value="">Select Country</option>');
                data.data.forEach(country => {
                    const option = $('<option></option>')
                        .attr('value', country.id || country.country_id || '')
                        .text(country.name || country.country_name || '');
                    countrySelect.append(option);
                });
                countrySelect.select2({
                    placeholder: 'Select Country',
                    allowClear: true,
                    width: '100%'
                }).on('change', function() {
                    loadShopStates($(this).val());
                });
            }
        })
        .catch(error => {
            console.error('Error loading countries:', error);
        });
    }

    // Load states by country
    function loadShopStates(countryId) {
        if (!countryId) {
            $('#shopStateId').empty().append('<option value="">Select State</option>').val('').trigger('change');
            $('#shopCityId').empty().append('<option value="">Select City</option>').val('').trigger('change');
            return;
        }

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
            const stateSelect = $('#shopStateId');
            if (data.status === 'success' && data.data && Array.isArray(data.data)) {
                stateSelect.empty().append('<option value="">Select State</option>');
                data.data.forEach(state => {
                    const option = $('<option></option>')
                        .attr('value', state.id || state.state_id || '')
                        .text(state.name || state.state_name || '');
                    stateSelect.append(option);
                });
                stateSelect.select2({
                    placeholder: 'Select State',
                    allowClear: true,
                    width: '100%'
                }).on('change', function() {
                    loadShopCities($(this).val());
                });
            }
            // Reset city dropdown
            $('#shopCityId').empty().append('<option value="">Select City</option>').val('').trigger('change');
        })
        .catch(error => {
            console.error('Error loading states:', error);
        });
    }

    // Load cities by state
    function loadShopCities(stateId) {
        if (!stateId) {
            $('#shopCityId').empty().append('<option value="">Select City</option>').val('').trigger('change');
            return;
        }

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
            const citySelect = $('#shopCityId');
            if (data.status === 'success' && data.data && Array.isArray(data.data)) {
                citySelect.empty().append('<option value="">Select City</option>');
                data.data.forEach(city => {
                    const option = $('<option></option>')
                        .attr('value', city.id || city.city_id || '')
                        .text(city.name || city.city_name || '');
                    citySelect.append(option);
                });
                citySelect.select2({
                    placeholder: 'Select City',
                    allowClear: true,
                    width: '100%'
                });
            }
        })
        .catch(error => {
            console.error('Error loading cities:', error);
        });
    }

    // Handle form submission
    document.getElementById('shopRegistrationForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = {
            name: document.getElementById('shopName').value.trim(),
            phone: document.getElementById('shopPhone').value.trim() || null,
            country_id: $('#shopCountryId').val() || null,
            state_id: $('#shopStateId').val() || null,
            city_id: $('#shopCityId').val() || null,
            zip_code: document.getElementById('shopZipCode').value.trim() || null,
            description: document.getElementById('shopDescription').value.trim() || null,
        };

        if (!formData.name) {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Shop name is required'
            });
            return;
        }

        try {
            const response = await fetch('{{ route("api.seller.shop.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin',
                body: JSON.stringify(formData)
            });

            const data = await response.json();

            if (response.status === 401) {
                Swal.fire({
                    icon: 'error',
                    title: 'Unauthorized',
                    text: data.message || 'Your session has expired. Please login again.',
                    confirmButtonText: 'Go to Login',
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '{{ route("login") }}';
                    }
                });
                return;
            }

            if (data.status === 'success' || response.ok) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: data.message || 'Shop registered successfully',
                    confirmButtonText: 'Go to Dashboard',
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '{{ route("seller.index") }}';
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Failed to register shop'
                });
            }
        } catch (error) {
            console.error('Error registering shop:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while registering your shop'
            });
        }
    });
</script>
@endpush
@endsection
