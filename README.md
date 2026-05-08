# Task Management Application

A simple task management web application built with Laravel.

## Features

- Create task
- Edit task
- Delete task
- Drag & drop task reordering
- Automatic priority management
- Project filtering (Bonus Feature)

## Tech Stack

- PHP 8.3+
- Laravel 12
- MySQL
- SortableJS (CDN)

---

# Installation

## 1. Clone the repository

```bash
git clone <repository-url>
cd taskmanagement
```

---

## 2. Install PHP dependencies

```bash
composer install
```

> Optional production install:
>
> ```bash
> composer install --no-dev
> ```

---

## 3. Create environment file

Copy the example environment file:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

---

## 4. Configure database

Update the database configuration in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=taskmanagement
DB_USERNAME=root
DB_PASSWORD=
```

If the database does not exist yet, create it manually:

```sql
CREATE DATABASE `taskmanagement`
COLLATE='utf8mb4_unicode_ci';
```

---

## 5. Run migrations

```bash
php artisan migrate
```

---

## 6. (Optional) Seed sample data

Populate the database with sample tasks and projects:

```bash
php artisan db:seed
```

Or run fresh migration with seeders:

```bash
php artisan migrate:fresh --seed
```

---

## 7. Run the application

```bash
php artisan serve
```

Application will be available at:

```text
http://127.0.0.1:8000
```

---

# Notes

## Task Reordering

Tasks can be reordered using drag & drop.

Priority is managed globally across all tasks.

When filtering by project:
- tasks can still be viewed and managed
- drag & drop reorder is disabled intentionally to preserve global priority consistency

## Project Management

This application includes basic project support as a bonus feature.

Tasks can be assigned to projects and filtered by project from the task list page.

To keep the implementation simple and focused on the assessment requirements:
- Project CRUD management is not included
- Projects are managed through database seeders or direct database updates

Sample projects are automatically created when running the seeders.

---

# Project Structure

Main components:

- `TaskController`
- `ProjectController`
- `Task` model
- `Project` model

---

# Author

Kristian Indra (https://github.com/kristianindra1412)