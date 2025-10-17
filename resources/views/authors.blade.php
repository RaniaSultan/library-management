@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Authors Management</h2>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- add author form -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">Add New Author</h3>
        
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('authors.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required 
                           class="mt-1 block w-full border border-gray-300 rounded-md p-2 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Bio</label>
                    <textarea name="bio" class="mt-1 block w-full border border-gray-300 rounded-md p-2 @error('bio') border-red-500 @enderror">{{ old('bio') }}</textarea>
                    @error('bio')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Birth Date *</label>
                    <input type="date" name="birth_date" value="{{ old('birth_date') }}" required 
                           max="{{ date('Y-m-d') }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md p-2 @error('birth_date') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1">Select a date in the past</p>
                    @error('birth_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                    Add Author
                </button>
            </div>
        </form>
    </div>

    <!-- authors list -->
    <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">All Authors ({{ $authors->count() }})</h3>
        <div class="space-y-4">
            @foreach($authors as $author)
            <div class="border border-gray-200 rounded-lg p-4">
                <h4 class="font-semibold text-lg">{{ $author->name }}</h4>
                <p class="text-gray-600">{{ $author->bio }}</p>
                <div class="flex justify-between items-center mt-2">
                    <span class="text-sm text-gray-500">Born: {{ $author->birth_date->format('M d, Y') }}</span>
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded">
                        {{ $author->books_count }} books
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection