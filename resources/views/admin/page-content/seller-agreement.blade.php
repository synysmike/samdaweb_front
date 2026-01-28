@extends('admin.layouts.app')

@section('title', 'Edit Seller Agreement')
@section('page-title', 'Edit Seller Agreement')

@section('content')
<div class="bg-white rounded-lg shadow">
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('admin.page-content.seller-agreement.update') }}" method="POST" class="p-6">
        @csrf

        <div class="mb-6">
            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Content</label>
            <textarea id="content" name="content" rows="20" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent font-mono text-sm"
                placeholder="Enter Seller Agreement content...">{{ old('content', $content) }}</textarea>
            <p class="text-xs text-gray-500 mt-2">You can use HTML formatting. The content will be displayed on the public Seller Agreement page.</p>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('seller-agreement') }}" target="_blank" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                View Public Page
            </a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                Save Changes
            </button>
        </div>
    </form>
</div>

@push('js')
<script>
    // Show success message with SweetAlert2 if session has success
    @if(session('success'))
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    });
    @endif
</script>
@endpush
@endsection
