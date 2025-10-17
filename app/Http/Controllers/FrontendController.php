<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\BorrowRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 

class FrontendController extends Controller
{
    public function dashboard()
    {
        if (Auth::user()->isAdmin()) {
            $stats = [
                'total_books' => Book::count(),
                'total_authors' => Author::count(),
                'total_borrow_requests' => BorrowRequest::count(),
                'pending_requests' => BorrowRequest::where('status', 'pending')->count(),
            ];
        } else {
            $stats = [
                'my_books_borrowed' => BorrowRequest::where('user_id', Auth::id())->count(),
                'my_pending_requests' => BorrowRequest::where('user_id', Auth::id())->where('status', 'pending')->count(),
                'my_approved_requests' => BorrowRequest::where('user_id', Auth::id())->where('status', 'approved')->count(),
                'available_books' => Book::where('available_copies', '>', 0)->count(),
            ];
        }

        return view('dashboard', compact('stats'));
    }

    public function adminBooks()
{
    $books = Book::with('author')->get();
    $authors = Author::all();
    return view('admin-books', compact('books', 'authors'));
}
    public function books()
    {
        $books = Book::with('author')->get();
        $authors = Author::all();
        return view('books', compact('books', 'authors'));
    }

    public function authors()
    {
        $authors = Author::withCount('books')->get();
        return view('authors', compact('authors'));
    }

    public function borrowRequests()
    {
        $borrowRequests = BorrowRequest::with(['book', 'user'])->get();
        return view('borrow-requests', compact('borrowRequests'));
    }

    public function borrowBookForm()
    {
        $books = Book::where('available_copies', '>', 0)->get();
        return view('borrow-book', compact('books'));
    }

    public function myBorrowRequests()
    {
        $borrowRequests = BorrowRequest::with(['book', 'user'])
            ->where('user_id', Auth::id())
            ->get();
        
        return view('my-requests', compact('borrowRequests'));
    }

    public function storeBook(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'author_id' => 'required|exists:authors,id',
            'published_at' => 'required|date',
            'available_copies' => 'required|integer|min:0',
        ]);

        Book::create($request->all());

        return redirect()->route('admin.books')->with('success', 'Book added successfully!');
    }

public function storeAuthor(Request $request)
{
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'birth_date' => [
                'required', 
                'date',
                'before_or_equal:today'
            ],
        ], [
            'name.required' => 'Author name is required.',
            'birth_date.required' => 'Birth date is required.',
            'birth_date.before_or_equal' => 'Birth date cannot be in the future.'
        ]);

        Author::create($validated);

        return redirect()->route('authors')->with('success', 'Author added successfully!');
        
}

    public function storeBorrowRequest(Request $request)
{
    $request->validate([
        'book_id' => 'required|exists:books,id',
    ]);

    $book = Book::findOrFail($request->book_id);
    
    // Check if book is available
    if ($book->available_copies < 1) {
        return redirect()->route('books')->with('error', 'No available copies of this book');
    }

    // Check if user already has a pending request for this book
    $existingRequest = BorrowRequest::where('user_id', Auth::id())
        ->where('book_id', $request->book_id)
        ->where('status', 'pending')
        ->first();

    if ($existingRequest) {
        return redirect()->route('books')->with('error', 'You already have a pending request for this book');
    }

    // Create borrow request
    BorrowRequest::create([
        'book_id' => $request->book_id,
        'user_id' => Auth::id(),
        'borrow_date' => date('Y-m-d', strtotime('+0 day')), 
        'status' => 'pending'
    ]);

    return redirect()->route('books')->with('success', 'Borrow request submitted successfully!');
}

    public function approveBorrowRequest($id)
    {
        $borrowRequest = BorrowRequest::findOrFail($id);

        DB::transaction(function () use ($borrowRequest) {
            $borrowRequest->update(['status' => 'approved']);
            
            // Decrease available copies
            $book = $borrowRequest->book;
            $book->decrement('available_copies');
        });

        return redirect()->route('borrow.requests')->with('success', 'Borrow request approved successfully!');
    }

    public function returnBorrowRequest($id)
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

        return redirect()->route('borrow.requests')->with('success', 'Book returned successfully!');
    }
}