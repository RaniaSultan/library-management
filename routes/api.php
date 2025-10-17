<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AuthController;

// Authentication routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/login', [AuthController::class, 'webLogin'])->name('login.post');
Route::post('/register', [AuthController::class, 'webRegister'])->name('register.post');
Route::post('/logout', [AuthController::class, 'webLogout'])->name('logout');

// Protected routes for all
Route::middleware('auth')->group(function () {
    // Dashboard all
    Route::get('/', [FrontendController::class, 'dashboard'])->name('dashboard');
    
    // Routes for user 
    Route::controller(FrontendController::class)->group(function () {
        Route::get('/books', 'books')->name('books');
        Route::get('/my-requests', 'myBorrowRequests')->name('my.requests');
        Route::post('/borrow-book', 'storeBorrowRequest')->name('borrow.book.store');
    });

    // Routes for admin
    Route::middleware('admin')->group(function () {
        Route::controller(FrontendController::class)->group(function () {
            Route::get('/admin/books', 'adminBooks')->name('admin.books');
            Route::get('/authors', 'authors')->name('authors');
            Route::get('/borrow-requests', 'borrowRequests')->name('borrow.requests');
            
            Route::post('/books', 'storeBook')->name('books.store');
            Route::post('/authors', 'storeAuthor')->name('authors.store');
            
            Route::post('/borrow-requests/{id}/approve', 'approveBorrowRequest')->name('borrow.requests.approve');
            Route::post('/borrow-requests/{id}/return', 'returnBorrowRequest')->name('borrow.requests.return');
        });

        Route::get('/reports', [ReportController::class, 'reports'])->name('reports');
    });

    Route::get('/borrow-book', [FrontendController::class, 'borrowBookForm'])->name('borrow.book.form');
});


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public API routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected API routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});