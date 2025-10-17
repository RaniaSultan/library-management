@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-6"> My Borrow Requests</h2>

    @if($borrowRequests->count() > 0)
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Book</th>
                    <th class="py-2 px-4 border-b">Borrow Date</th>
                    <th class="py-2 px-4 border-b">Status</th>
                    <th class="py-2 px-4 border-b">Return Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($borrowRequests as $request)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $request->book->title }}</td>
                    <td class="py-2 px-4 border-b">{{ $request->borrow_date->format('M d, Y') }}</td>
                    <td class="py-2 px-4 border-b">
                        <span class="px-2 py-1 text-xs rounded 
                            {{ $request->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $request->status == 'approved' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $request->status == 'returned' ? 'bg-blue-100 text-blue-800' : '' }}">
                            {{ ucfirst($request->status) }}
                        </span>
                    </td>
                    <td class="py-2 px-4 border-b">
                        {{ $request->return_date ? $request->return_date->format('M d, Y') : 'Not returned' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="text-center py-8">
        <p class="text-gray-500 text-lg">You haven't made any borrow requests yet.</p>
        <a href="{{ route('borrow.book.form') }}" class="inline-block mt-4 bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
            Borrow a Book
        </a>
    </div>
    @endif
</div>
@endsection