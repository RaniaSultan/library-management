@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-6"> Borrow a Book</h2>

    <form action="{{ route('borrow.book.store') }}" method="POST">
        @csrf
        <div class="space-y-4 max-w-md">
            <div>
                <label class="block text-sm font-medium text-gray-700">Select Book</label>
                <select name="book_id" required class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                    <option value="">Choose a book...</option>
                    @foreach($books as $book)
                        <option value="{{ $book->id }}">
                            {{ $book->title }} by {{ $book->author->name }} 
                            ({{ $book->available_copies }} available)
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Borrow Date</label>
                <input type="date" name="borrow_date" required 
                       min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                       class="mt-1 block w-full border border-gray-300 rounded-md p-2">
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Submit Borrow Request
            </button>
        </div>
    </form>

    <!-- Available Books List -->
    <div class="mt-8">
        <h3 class="text-xl font-semibold mb-4">Available Books</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($books as $book)
            <div class="border border-gray-200 rounded-lg p-4">
                <h4 class="font-semibold">{{ $book->title }}</h4>
                <p class="text-gray-600">By {{ $book->author->name }}</p>
                <p class="text-sm text-gray-500 mt-1">{{ Str::limit($book->description, 100) }}</p>
                <div class="flex justify-between items-center mt-2">
                    <span class="text-sm text-gray-500">Published: {{ $book->published_at->format('M Y') }}</span>
                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded">
                        {{ $book->available_copies }} available
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection