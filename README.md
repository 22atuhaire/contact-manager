

## Contact Manager

A simple Laravel contact manager app.

## Requirements

- PHP 8.1+
- Composer
- Node.js 18+ and npm
- A database (SQLite, MySQL, or Postgres)

If you are using XAMPP, make sure Apache and MySQL are running before you migrate or serve the app.

## Setup

If you followed a local stack like XAMPP, the usual order is: XAMPP -> Composer -> Laravel -> Node.js -> npm.

1. Install PHP dependencies:

	```bash
	composer install
	```

2. Install JS dependencies:

	```bash
	npm install
	```

3. Create your environment file:

	```bash
	# Contact Manager

	A Laravel-based contact management system for storing, organizing, searching, and maintaining personal or professional contacts in one place.

	## Overview

	This project provides a clean, account-based workspace where each user can manage their own contact directory. It includes authentication, contact CRUD, search and filtering, groups, tags, favorites, soft deletion, interaction notes, and CSV import/export.

	## Key Features

	- User registration, login, logout, and password reset
	- Create, edit, search, filter, and delete contacts
	- Multi-user data isolation with policy-based authorization
	- Contact groups and tags for better organization
	- Favorite contacts for quick access
	- Soft delete and restore support
	- Interaction notes with timestamps
	- CSV import and export
	- Duplicate prevention using normalized phone numbers and email checks

	## Technology Stack

	- Backend: Laravel 12 / PHP 8.2+
	- Frontend: Blade templates, Tailwind CSS, Vite
	- Database: SQLite, MySQL, or PostgreSQL
	- Tooling: Composer, npm, Laravel Artisan

	## Requirements

	- PHP 8.2 or newer
	- Composer
	- Node.js 18+ and npm
	- A supported database engine

	If you are using XAMPP or another local stack, make sure the web server and database service are running before you migrate or serve the app.

	## Installation

	1. Install PHP dependencies.

	```bash
	composer install
	```

	2. Install frontend dependencies.

	```bash
	npm install
	```

	3. Create your environment file.

	```bash
	cp .env.example .env
	```

	4. Generate the application key.

	```bash
	php artisan key:generate
	```

	5. Configure your database credentials in `.env`, then run the migrations.

	```bash
	php artisan migrate
	```

	## Running the Project

	Start the Laravel backend server:

	```bash
	php artisan serve
	```

	In a second terminal, start Vite for frontend assets:

	```bash
	npm run dev
	```

	Open the application in your browser at:

	```text
	http://127.0.0.1:8000
	```

	## Useful Commands

	- Build frontend assets for production: `npm run build`
	- Run the test suite: `composer test`
	- Use the combined development script: `composer run dev`

	## Project Structure

	- `app/Http/Controllers` - application controllers
	- `app/Models` - Eloquent models and relationships
	- `app/Policies` - authorization rules
	- `database/migrations` - schema changes
	- `resources/views` - Blade UI templates
	- `routes/web.php` - web routes

	## Notes

	- Contacts are linked to the authenticated user.
	- Data entry is validated before saving.
	- Soft deleted contacts can be restored instead of being permanently removed.
	- CSV import/export is designed for practical data transfer and backup workflows.

	## License

	This project is intended for academic and learning use unless a different license is added later.

