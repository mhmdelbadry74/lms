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

## Notes

- This repo now includes a local Laravel scaffold copied from an existing on-machine installation because Packagist was unavailable in the current environment.
- `vendor/` is already present so the app can boot without downloading dependencies again.
- Livewire is installed and the UI uses Alpine-compatible directives. A dedicated frontend build step is not required for the current reviewer flow.
- The challenge requested Pest. The current environment had no package registry access, so the implemented automated coverage is PHPUnit-based while targeting the exact same integrity scenarios.
- A ready-to-record Arabic walkthrough script is available in `docs/VIDEO_WALKTHROUGH_AR.md`.
