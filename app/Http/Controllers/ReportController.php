<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\BorrowRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function mostBorrowedAuthor()
    {
        $mostBorrowedAuthor = Author::withCount(['books as total_borrows' => function($query) {
            $query->join('borrow_requests', 'books.id', '=', 'borrow_requests.book_id')
                  ->select(\DB::raw('count(borrow_requests.id)'));
        }])->orderBy('total_borrows', 'desc')
        ->first();

        return response()->json($mostBorrowedAuthor);
    }

    public function requestsPerUser()
    {
        $requestsPerUser = User::withCount('borrowRequests')
            ->having('borrow_requests_count', '>', 0)
            ->orderBy('borrow_requests_count', 'desc')
            ->get(['id', 'name', 'email', 'borrow_requests_count']);

        return response()->json($requestsPerUser);
    }

    // frontend report page
    public function reports()
    {
        $mostBorrowedAuthor = Author::withCount(['books as total_borrows' => function($query) {
            $query->join('borrow_requests', 'books.id', '=', 'borrow_requests.book_id')
                  ->select(\DB::raw('count(borrow_requests.id)'));
        }])->orderBy('total_borrows', 'desc')
        ->first();

        $requestsPerUser = User::withCount('borrowRequests')
            ->having('borrow_requests_count', '>', 0)
            ->orderBy('borrow_requests_count', 'desc')
            ->get();

        return view('reports', compact('mostBorrowedAuthor', 'requestsPerUser'));
    }
}
