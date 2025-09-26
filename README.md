# Stoix Task List

A simple task management application built with Laravel backend and Vue 3 frontend.

## Features

-   Create, read, update, and delete tasks
-   Mark tasks as complete/incomplete
-   Clean and responsive user interface
-   RESTful API architecture

## Tech Stack

-   **Backend**: Laravel (PHP)
-   **Frontend**: Vue 3
-   **Database**: MySQL/SQLite

## Installation

### Prerequisites

-   PHP >= 8.1
-   Composer
-   Node.js >= 16
-   npm or yarn

### Setup Instructions

1. Clone the repository:

```bash
git clone https://github.com/your-username/stoix-task-list.git
cd stoix-task-list
```

2. Install PHP dependencies:

```bash
composer install
```

3. Install JavaScript dependencies:

```bash
npm install
```

4. Create environment file:

```bash
cp .env.example .env
```

5. Generate application key:

```bash
php artisan key:generate
```

6. Configure your database in `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=stoix_task_list
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

7. Run database migrations:

```bash
php artisan migrate
```

8. Build frontend assets:

```bash
npm run dev
```

## Running the Application

### Development Mode

1. Start the Laravel development server:

```bash
php artisan serve
```

2. In a separate terminal, run the frontend development server:

```bash
npm run dev
```

3. Visit `http://localhost:8000` in your browser

### Production Build

```bash
npm run build
php artisan serve
```

## API Endpoints

-   `GET /api/tasks` - Get all tasks
-   `POST /api/tasks` - Create a new task
-   `GET /api/tasks/{id}` - Get a specific task
-   `PUT /api/tasks/{id}` - Update a task
-   `DELETE /api/tasks/{id}` - Delete a task

## Project Structure

```
├── app/
│   ├── Http/Controllers/
│   │   └── TaskController.php
│   └── Models/
│       └── Task.php
├── resources/
│   ├── js/
│   │   ├── components/
│   │   └── app.js
│   └── views/
└── routes/
    ├── api.php
    └── web.php
```
