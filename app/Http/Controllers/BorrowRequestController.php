<?php

namespace App\Http\Controllers;

use App\Models\BorrowRequest;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\AdminMiddleware;

class BorrowRequestController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index()
    {
        return BorrowRequest::with(['book', 'user'])->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'borrow_date' => 'required|date|after:today',
        ]);

        // Check if book is available
        $book = Book::findOrFail($request->book_id);
        if ($book->available_copies < 1) {
            return response()->json([
                'message' => 'No available copies of this book'
            ], 400);
        }

        $borrowRequest = BorrowRequest::create([
            'book_id' => $request->book_id,
            'user_id' => Auth::id(),
            'borrow_date' => $request->borrow_date,
            'status' => 'pending'
        ]);

        return response()->json($borrowRequest, 201);
    }

    public function approve($id)
    {
        $borrowRequest = BorrowRequest::findOrFail($id);

        DB::transaction(function () use ($borrowRequest) {
            $borrowRequest->update(['status' => 'approved']);
            
            // Decrease available copies
            $book = $borrowRequest->book;
            $book->decrement('available_copies');
        });

        return response()->json($borrowRequest);
    }

    public function returnBook($id)
    {
        $borrowRequest = BorrowRequest::findOrFail($id);

        DB::transaction(function () use ($borrowRequest) {
            $borrowRequest->update([
                'status' => 'returned',
                'return_date' => now()
            ]);
            
            // Increase available copies
            $book = $borrowRequest->book;
            $book->increment('available_copies');
        });

        return response()->json($borrowRequest);
    }
}