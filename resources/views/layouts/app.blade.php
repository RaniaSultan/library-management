<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
  <nav class="bg-blue-600 text-white p-4">
    <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-xl font-bold"> Library System</h1>
        
        @auth
        <div class="space-x-4">
            <a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a>
            <a href="{{ route('books') }}" class="hover:underline">Books</a>
            <a href="{{ route('borrow.book.form') }}" class="hover:underline">Borrow Book</a>
            <a href="{{ route('my.requests') }}" class="hover:underline">My Requests</a>
            
            @if(Auth::user()->isAdmin())
                <a href="{{ route('authors') }}" class="hover:underline">Authors</a>
                <a href="{{ route('borrow.requests') }}" class="hover:underline">All Requests</a>
                <a href="{{ route('reports') }}" class="hover:underline">Reports</a>
            @endif
            
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="hover:underline">
                    Logout ({{ Auth::user()->name }})
                    @if(Auth::user()->isAdmin())
                        <span class="text-yellow-300">(Admin)</span>
                    @endif
                </button>
            </form>
        </div>
        @else
        <div class="space-x-4">
            <a href="{{ route('login') }}" class="hover:underline">Login</a>
            <a href="{{ route('register') }}" class="hover:underline">Register</a>
        </div>
        @endauth
    </div>
</nav>

    <main class="container mx-auto p-4">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>