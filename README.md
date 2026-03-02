# Career 180 Mini-LMS Task

This repository is a runnable Laravel 12 mini-LMS foundation focused on public course discovery, authenticated enrollment, lesson completion, and certificate issuance.

Assumptions:
- PHP 8.3
- Laravel 12 structure
- MySQL as the default database

## Start

1. Build and start containers:

```bash
docker compose up --build
```

2. Install PHP dependencies inside the app container:

```bash
docker compose exec app composer install
```

3. Run migrations and seeders:

```bash
docker compose exec app php artisan migrate --seed
```

4. Run the queue worker (already defined as a service):

```bash
docker compose up queue
```

5. Generate an application key if needed:

```bash
docker compose exec app php artisan key:generate
```

## Tests

Run the test suite:

```bash
docker compose exec app php artisan test
```

