# Collaboard

Collaboard is a collaborative project management tool built with [Laravel](https://laravel.com/) and [Livewire](https://laravel-livewire.com/). It provides a modern Kanban board experience with additional list and calendar views. Projects contain categories (columns) and tasks that can be labeled, assigned to users and reordered via drag and drop.

## Features

- **Project management** – create projects and invite members
- **Task management** – tasks have descriptions, due dates, priority levels and labels
- **Board, list & calendar views** – switch between views to organise work visually
- **Drag and drop** – move tasks between categories or calendar dates
- **Labels and filtering** – colour‑coded labels with powerful filters
- **User authentication** – registration, login, email verification and profile management
- **Appearance settings** – light/dark theme support stored per user

## Requirements

- PHP 8.2+
- Composer
- Node.js & npm
- A database supported by Laravel (MySQL used by default)

## Installation

```bash
# Clone the repository and install dependencies
composer install
npm install

# Copy the example environment and generate the application key
cp .env.config .env
php artisan key:generate

# Run database migrations
php artisan migrate

# Build assets and start the development server
npm run dev
php artisan serve
```

The project ships with a `docker-compose.yml` that uses [Laravel Sail](https://laravel.com/docs/sail) for local development if you prefer running everything in containers.

## Running Tests

To execute the test suite:

```bash
./vendor/bin/phpunit
```

## License

This project is released under the MIT License.
