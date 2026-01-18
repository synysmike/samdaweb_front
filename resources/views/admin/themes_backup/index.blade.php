@extends('admin.layouts.app')

@section('title', 'Banners')
@section('page-title', 'Banner Management')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-900">Banner List</h3>
        <a href="{{ route('admin.banners.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
            Add New Banner
        </a>
    </div>
    
    <div class="p-6">
        <p class="text-gray-500">Banner management functionality will be implemented here.</p>
        <!-- Banner table/list will go here -->
    </div>
</div>
@endsection
