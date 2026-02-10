

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
	cp .env.example .env
	```

4. Generate the app key:

	```bash
	php artisan key:generate
	```

5. Configure the database in `.env` and run migrations:

	```bash
	php artisan migrate
	```

## Run the app

Start the Laravel dev server and Vite:

```bash
php artisan serve
```

In another terminal:

```bash
npm run dev
```

Open `http://127.0.0.1:8000` in your browser.

