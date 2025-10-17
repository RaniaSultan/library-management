# 📚 Library Management System

A complete Laravel-based library management system with RESTful API and web interface. Manage books, authors, and borrowing requests efficiently with role-based access control.

## 🎯 Features

### 🔐 Authentication & Authorization

-   **JWT Token-based API Authentication** using Laravel Sanctum
-   **Session-based Web Authentication**
-   **Role-based Access Control** (Admin & User)
-   Secure password hashing

### 📖 Book Management

-   **CRUD Operations** for books and authors
-   **Advanced Search & Filtering** by title, author, genre
-   **Book Availability Tracking**
-   **Image upload support** for book covers

### 🔄 Borrowing System

-   **Borrow Request Workflow** (Request → Approve → Return)
-   **Due Date Management**
-   **Borrowing History**
-   **Overdue Notifications**

### 🌐 Dual Interface

-   **RESTful API** for mobile apps and third-party integrations
-   **Web Interface** for administrative tasks
-   **Responsive Design** with Tailwind CSS

## 🛠 Tech Stack

-   **Backend:** Laravel 10+, PHP 8.1+
-   **Frontend:** Blade Templates, Tailwind CSS
-   **Database:** MySQL
-   **Authentication:** Laravel Sanctum
-   **API Testing:** Postman

## 🚀 Quick Start

### Prerequisites

-   PHP 8.1 or higher
-   Composer
-   MySQL 5.7+
-   Git

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
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
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

### 5. Start Development Server

```bash
php artisan serve
```

Visit: **http://localhost:8000**

## 🗃 Database Setup

### Migrations

Run the following command to create all database tables:

```bash
php artisan migrate
```

#### Database Tables Created:

-   `users` - System users with role management
-   `authors` - Book authors with biography
-   `books` - Library books with availability status
-   `borrow_requests` - Borrowing records and history
-   `personal_access_tokens` - API authentication tokens
-   `migrations` - Migration history
-   `password_reset_tokens` - Password reset functionality
-   `failed_jobs` - Failed queue jobs
-   `cache` - Application cache
-   `sessions` - User sessions

### Seeding

Populate the database with sample data:

```bash
php artisan db:seed
```

#### Default Accounts Created:

-   **👑 Admin User:**

    -   Email: `admin@library.com`
    -   Password: `password`
    -   Role: Administrator

-   **👤 Regular User:**
    -   Email: `user@library.com`
    -   Password: `password`
    -   Role: Member

#### Sample Data Includes:

-   10+ sample authors with biographies
-   20+ sample books across various genres
-   Pre-configured borrowing requests
-   Book-author relationships
-   Availability status for all books

## 🔌 API Usage

### Base URL

```
http://localhost:8000/api
```

### Authentication Endpoints

#### 🔐 Register New User

```http
POST /api/register
Content-Type: application/json

{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password",
    "password_confirmation": "password"
}
```

#### 🔑 Login

```http
POST /api/login
Content-Type: application/json

{
    "email": "john@example.com",
    "password": "password"
}
```

**Response:**

```json
{
    "access_token": "1|abc123...",
    "token_type": "Bearer",
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com"
    }
}
```

#### 🚪 Logout

```http
POST /api/logout
Authorization: Bearer {token}
```

### 👥 Author Management

#### Get All Authors

```http
GET /api/authors
Authorization: Bearer {token}
```

#### Create Author (Admin Only)

```http
POST /api/authors
Authorization: Bearer {token}
Content-Type: application/json

{
    "name": "J.K. Rowling",
    "bio": "British author best known for the Harry Potter series",
    "birth_date": "1965-07-31"
}
```

#### Get Author Details

```http
GET /api/authors/{id}
Authorization: Bearer {token}
```

#### Update Author

```http
PUT /api/authors/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
    "name": "Updated Author Name",
    "bio": "Updated biography"
}
```

#### Delete Author

```http
DELETE /api/authors/{id}
Authorization: Bearer {token}
```

### 📚 Book Management

#### Get All Books

```http
GET /api/books
Authorization: Bearer {token}
```

#### Search & Filter Books

```http
GET /api/books?search=laravel&author_id=1
Authorization: Bearer {token}
```

**Query Parameters:**

-   `search` - Search in book titles and descriptions
-   `author_id` - Filter by specific author
-   `genre` - Filter by genre
-   `available` - Show only available books (true/false)

#### Get Single Book

```http
GET /api/books/{id}
Authorization: Bearer {token}
```

#### Create Book (Admin Only)

```http
POST /api/books
Authorization: Bearer {token}
Content-Type: application/json

{
    "title": "New Book Title",
    "author_id": 1,
    "isbn": "978-0123456789",
    "description": "Book description here",
    "genre": "Fiction",
    "published_year": 2024,
    "total_copies": 5,
    "available_copies": 5
}
```

#### Update Book

```http
PUT /api/books/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
    "title": "Updated Book Title",
    "description": "Updated description"
}
```

#### Delete Book

```http
DELETE /api/books/{id}
Authorization: Bearer {token}
```

### 📖 Borrowing System

#### Submit Borrow Request

```http
POST /api/borrow
Authorization: Bearer {token}
Content-Type: application/json

{
    "book_id": 1,
    "borrow_date": "2024-12-25",
    "due_date": "2025-01-25"
}
```

#### Get My Borrow Requests

```http
GET /api/my-requests
Authorization: Bearer {token}
```

#### Approve Borrow Request (Admin Only)

```http
PUT /api/borrow/{id}/approve
Authorization: Bearer {token}
```

#### Return Book (Admin Only)

```http
PUT /api/borrow/{id}/return
Authorization: Bearer {token}
```

#### Get All Borrow Requests (Admin Only)

```http
GET /api/borrow-requests
Authorization: Bearer {token}
```

## 📬 Postman Collection

### Import Instructions:

1. Open Postman
2. Click **Import** → **File**
3. Select `Library-API.postman_collection.json` from the project root
4. Create environment variables:
    - `base_url`: `http://localhost:8000`
    - `api_token`: (will be auto-set after login)

### Collection Structure:

#### 🏠 Authentication

-   `POST /api/register` - User registration
-   `POST /api/login` - User login (auto-sets token)
-   `POST /api/logout` - User logout

#### 👥 Authors Management

-   `GET /api/authors` - List all authors
-   `POST /api/authors` - Create new author
-   `GET /api/authors/{id}` - Get author details
-   `PUT /api/authors/{id}` - Update author
-   `DELETE /api/authors/{id}` - Delete author

#### 📚 Books Management

-   `GET /api/books` - List all books
-   `GET /api/books?search={query}` - Search books
-   `GET /api/books?author_id={id}` - Filter by author
-   `POST /api/books` - Create new book
-   `GET /api/books/{id}` - Get book details
-   `PUT /api/books/{id}` - Update book
-   `DELETE /api/books/{id}` - Delete book

#### 🔄 Borrowing System

-   `POST /api/borrow` - Submit borrow request
-   `GET /api/my-requests` - Get user's requests
-   `PUT /api/borrow/{id}/approve` - Approve request
-   `PUT /api/borrow/{id}/return` - Return book
-   `GET /api/borrow-requests` - Get all requests (Admin)

#### Pre-request Scripts:

-   Automatically sets Authorization header for protected endpoints
-   Handles token management

#### Tests:

-   Validates response status codes
-   Checks response structure
-   Verifies authentication

## 🏃‍♂️ Running the Application

### Development

```bash
php artisan serve
```

Access: http://localhost:8000

### Additional Setup (Optional)

```bash
# Link storage for file uploads
php artisan storage:link

# Run queue worker for notifications
php artisan queue:work

# Clear caches if needed
php artisan config:clear
php artisan route:clear
php artisan cache:clear
```

## 👥 Default Login Credentials

After running migrations and seeding:

### Web Interface:

-   **Admin Panel:** http://localhost:8000/login

    -   Email: `admin@library.com`
    -   Password: `password`

-   **User Registration:** http://localhost:8000/register
    -   Create new accounts or use:
    -   Email: `user@library.com`
    -   Password: `password`

### API Access:

Use the provided Postman collection or any API client with the endpoints above.

## 🐛 Troubleshooting

### Common Issues:

1. **Migration Errors**

    ```bash
    # Reset and re-run migrations
    php artisan migrate:fresh --seed
    ```

2. **Authentication Issues**

    - Verify Sanctum is installed: `composer require laravel/sanctum`
    - Check token in Authorization header

3. **Database Connection**

    - Verify database exists and credentials in `.env`
    - Check MySQL service is running

4. **File Permissions**
    ```bash
    chmod -R 755 storage
    chmod -R 755 bootstrap/cache
    ```

### Logs & Debugging

```bash
# View application logs
tail -f storage/logs/laravel.log

# Check all registered routes
php artisan route:list

# Verify database connection
php artisan db:show
```

## 📁 Project Structure

```
library-management/
├── app/
│   ├── Http/Controllers/     # API and Web controllers
│   ├── Models/              # Eloquent models
│   └── Providers/           # Service providers
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/            # Database seeders
├── routes/
│   ├── api.php             # API routes
│   └── web.php             # Web routes
├── storage/                # Storage for files, logs
└── tests/                  # PHPUnit tests
```

## 🤝 Support

For issues and questions:

1. Check the application logs: `storage/logs/laravel.log`
2. Verify migration status: `php artisan migrate:status`
3. Ensure all environment variables are set in `.env`

---

<div align="center">

**Built with ❤️ using Laravel**

_Start managing your library efficiently today!_

</div>
