@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-6">All Borrow Requests</h2>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">ID</th>
                    <th class="py-2 px-4 border-b">Book</th>
                    <th class="py-2 px-4 border-b">User</th>
                    <th class="py-2 px-4 border-b">Borrow Date</th>
                    <th class="py-2 px-4 border-b">Status</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($borrowRequests as $request)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $request->id }}</td>
                    <td class="py-2 px-4 border-b">{{ $request->book->title }}</td>
                    <td class="py-2 px-4 border-b">{{ $request->user->name }}</td>
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
                        @if($request->status == 'pending')
                            <form action="{{ route('borrow.requests.approve', $request->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600">
                                    Approve
                                </button>
                            </form>
                        @elseif($request->status == 'approved')
                            <form action="{{ route('borrow.requests.return', $request->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600">
                                    Mark Returned
                                </button>
                            </form>
                        @else
                            <span class="text-gray-500 text-sm">Completed</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection