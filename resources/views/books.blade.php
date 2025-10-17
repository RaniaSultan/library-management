@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Books Management - Admin</h2>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Add book form -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">Add New Book</h3>
        
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('books.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Title *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required 
                           class="mt-1 block w-full border border-gray-300 rounded-md p-2 @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" class="mt-1 block w-full border border-gray-300 rounded-md p-2 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Author *</label>
                    <select name="author_id" required class="mt-1 block w-full border border-gray-300 rounded-md p-2 @error('author_id') border-red-500 @enderror">
                        <option value="">Select Author</option>
                        @foreach($authors as $author)
                            <option value="{{ $author->id }}" {{ old('author_id') == $author->id ? 'selected' : '' }}>
                                {{ $author->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('author_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Published Date *</label>
                    <input type="date" name="published_at" value="{{ old('published_at') }}" required 
                           max="{{ date('Y-m-d') }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md p-2 @error('published_at') border-red-500 @enderror">
                    @error('published_at')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Available Copies *</label>
                    <input type="number" name="available_copies" value="{{ old('available_copies', 1) }}" required min="0" 
                           class="mt-1 block w-full border border-gray-300 rounded-md p-2 @error('available_copies') border-red-500 @enderror">
                    @error('available_copies')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Add Book
                </button>
            </div>
        </form>
    </div>

    <!-- books list -->
    <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">All Books ({{ $books->count() }})</h3>
        <div class="space-y-4">
            @foreach($books as $book)
            <div class="border border-gray-200 rounded-lg p-4">
                <h4 class="font-semibold text-lg">{{ $book->title }}</h4>
                <p class="text-gray-600">By {{ $book->author->name }}</p>
                <p class="text-sm text-gray-500">{{ $book->description }}</p>
                <div class="flex justify-between items-center mt-2">
                    <span class="text-sm text-gray-500">Published: {{ $book->published_at->format('M d, Y') }}</span>
                    <span class="px-2 py-1 text-xs rounded {{ $book->available_copies > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $book->available_copies }} copies available
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection