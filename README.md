# Library Management System (Laravel)

A Laravel-based web application to manage library data such as books, shelves, students, borrowings, and returns.  
All features are protected and can only be accessed after login.

## Default Login
- Email: `admin@gmail.com`
- Password: `123`

## Setup & Run

1. Clone the project

git clone https://github.com/username/app-perpus.git 
cd app-perpus

2. Install dependencies

composer install

3. Copy environment file

cp .env.example .env

4. Configure database in `.env`

DB_DATABASE=app-perpus 
DB_USERNAME=root 
DB_PASSWORD=

5. Generate application key

php artisan key:generate

6. Run the server

php artisan serve

Open in browser:

http://127.0.0.1:8000
