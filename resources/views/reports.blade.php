@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-6">Library Reports</h2>

    <!-- most borrowed author -->
    <div class="mb-8">
        <h3 class="text-xl font-semibold mb-4"> Most Borrowed Author</h3>
        @if($mostBorrowedAuthor)
        <div class="bg-blue-50 p-4 rounded-lg">
            <h4 class="font-semibold text-lg">{{ $mostBorrowedAuthor->name }}</h4>
            <p class="text-gray-600">{{ $mostBorrowedAuthor->bio }}</p>
            <p class="text-sm text-gray-500 mt-2">
                Total Borrows: <span class="font-semibold">{{ $mostBorrowedAuthor->total_borrows }}</span>
            </p>
        </div>
        @else
        <p class="text-gray-500">No borrow data available yet.</p>
        @endif
    </div>

    <!-- requests per user -->
    <div>
        <h3 class="text-xl font-semibold mb-4"> Borrow Requests Per User</h3>
        @if($requestsPerUser->count() > 0)
        <div class="space-y-4">
            @foreach($requestsPerUser as $user)
            <div class="border border-gray-200 rounded-lg p-4">
                <div class="flex justify-between items-center">
                    <div>
                        <h4 class="font-semibold">{{ $user->name }}</h4>
                        <p class="text-sm text-gray-600">{{ $user->email }}</p>
                    </div>
                    <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm">
                        {{ $user->borrow_requests_count }} requests
                    </span>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-gray-500">No borrow requests from users yet.</p>
        @endif
    </div>
</div>
@endsection