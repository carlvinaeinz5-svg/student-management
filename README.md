# Student Management System

A Laravel application for managing students, lecturers, courses, and course registrations. The application uses Laravel Breeze for authentication and Spatie Laravel Permission for role-based access.

## Requirements

- PHP 8.2 or later with the SQLite extension enabled
- Composer
- Node.js with npm

## Setup on Windows PowerShell

Run these commands from the project folder:

```powershell
composer install
if (!(Test-Path .env)) { Copy-Item .env.example .env }
php artisan key:generate
if (!(Test-Path .\database\database.sqlite)) { New-Item -Path .\database\database.sqlite -ItemType File }
npm.cmd install
npm.cmd run build
php artisan migrate --seed
php artisan serve
```

If PowerShell says scripts are disabled when you type `npm`, use `npm.cmd` as shown above. If `npm.cmd` is not found, install the LTS version of Node.js and reopen VS Code.

Open <http://127.0.0.1:8000> in your browser. Keep the terminal running `php artisan serve` open while you use the app.

## Demo accounts

The database seeder creates these local demo accounts. They all use the password `password`:

| Role | Email |
| --- | --- |
| Admin | `admin@test.com` |
| Lecturer | `lecturer@test.com` |
| Student | `student1@test.com` through `student5@test.com` |

These are for local development only. Change demo passwords before using the application beyond local development.

## Features

- **Admin:** manage students, lecturers, and courses; view student registrations; search records; view the registration report.
- **Lecturer:** view assigned courses and their enrolled students.
- **Student:** browse and search available courses, register, view registered courses, and drop a course.
- New accounts created through the public registration form receive the Student role.

## Useful commands

```powershell
php artisan serve
php artisan migrate --seed
npm.cmd run build
```

Run `php artisan serve` in one terminal. After changing CSS or JavaScript, run `npm.cmd run build` again to refresh the production assets.
