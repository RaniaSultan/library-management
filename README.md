
# Library Management System

A complete Laravel-based library management system with RESTful API.

## Setup Steps

### 1. Install Dependencies
```bash
composer install
```

### 2. Configure Environment
```bash
cp .env.example .env
php artisan key:generate
```

Update `.env` with your database credentials:
```env
DB_DATABASE=library_management
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Run Migrations
```bash
php artisan migrate
```

### 4. Seed Database
```bash
php artisan db:seed
```

### 5. Start Server
```bash
php artisan serve
```

Visit: http://localhost:8000

## Default Login
- **Admin:** admin@library.com / admin123
- **Users:** Register new account

## API Endpoints

### Authentication
- `POST /api/register` - Register user
- `POST /api/login` - Login user
- `POST /api/logout` - Logout user

### Authors
- `GET /api/authors` - List authors
- `POST /api/authors` - Create author
- `GET /api/authors/{id}` - Get author
- `PUT /api/authors/{id}` - Update author
- `DELETE /api/authors/{id}` - Delete author

### Books
- `GET /api/books` - List books (filter with `?author_id=1` or `?search=php`)
- `POST /api/books` - Create book
- `GET /api/books/{id}` - Get book
- `PUT /api/books/{id}` - Update book
- `DELETE /api/books/{id}` - Delete book

### Borrow Requests
- `POST /api/borrow` - Submit borrow request
- `PUT /api/borrow/{id}/approve` - Approve request
- `PUT /api/borrow/{id}/return` - Return book

## Postman Collection
Import `Library-API.postman_collection.json` into Postman for API testing.
```
