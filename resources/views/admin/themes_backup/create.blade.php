@extends('admin.layouts.app')

@section('title', 'Create Banner')
@section('page-title', 'Create New Banner')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <form action="#" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="space-y-6">
            <!-- Banner details form will go here -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Banner Title</label>
                <input type="text" name="title" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div class="flex gap-4">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                    Save Banner
                </button>
                <a href="{{ route('admin.banners.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition-colors">
                    Cancel
                </a>
            </div>
        </div>
    </form>
</div>
@endsection
