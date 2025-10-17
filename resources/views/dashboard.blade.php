@extends('layouts.app')

@section('content')
@if(Auth::user()->isAdmin())
\<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-2">Total Books</h3>
        <p class="text-3xl font-bold text-blue-600">{{ $stats['total_books'] }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-2">Total Authors</h3>
        <p class="text-3xl font-bold text-green-600">{{ $stats['total_authors'] }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-2">Total Requests</h3>
        <p class="text-3xl font-bold text-yellow-600">{{ $stats['total_borrow_requests'] }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-2">Pending Requests</h3>
        <p class="text-3xl font-bold text-red-600">{{ $stats['pending_requests'] }}</p>
    </div>
</div>

<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-semibold mb-4">Admin Quick Actions</h2>
    <div class="flex space-x-4">
        <a href="{{ route('books') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Manage Books
        </a>
        <a href="{{ route('authors') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
            Manage Authors
        </a>
        <a href="{{ route('borrow.requests') }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
            View All Requests
        </a>
        <a href="{{ route('reports') }}" class="bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600">
            View Reports
        </a>
    </div>
</div>

@else

<!--  Dashboard for user -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-2">My Borrowed Books</h3>
        <p class="text-3xl font-bold text-blue-600">{{ $stats['my_books_borrowed'] }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-2">Pending Requests</h3>
        <p class="text-3xl font-bold text-yellow-600">{{ $stats['my_pending_requests'] }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-2">Approved Requests</h3>
        <p class="text-3xl font-bold text-green-600">{{ $stats['my_approved_requests'] }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-2">Available Books</h3>
        <p class="text-3xl font-bold text-purple-600">{{ $stats['available_books'] }}</p>
    </div>
</div>

<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-semibold mb-4">Quick Actions</h2>
    <div class="flex space-x-4">
        <a href="{{ route('books') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Browse Books
        </a>
        <a href="{{ route('borrow.book.form') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
            Borrow a Book
        </a>
        <a href="{{ route('my.requests') }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
            My Requests
        </a>
    </div>
</div>
@endif
@endsection