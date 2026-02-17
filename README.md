<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Coachly Fitness

Online strength & lifestyle coaching application.

This project uses **SQLite** for the database.

### Prerequisites

- [PHP](https://www.php.net/) 8.2 or higher
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/) and npm
- SQLite (PHP extension)

### Running Locally

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
composer run dev
```

### Test Users

After running `php artisan migrate:fresh --seed`, use these credentials:

| Role   | Email                | Password |
| ------ | -------------------- | -------- |
| Client | client@example.com   | password |
| Coach  | coachlee@coachly.fit | password |

### Render Docker CMD Reference

File reference: [Dockerfile](https://github.com/jmartindg/Coachly/blob/main/Dockerfile)

Current production CMD in `Dockerfile` (migrate + icon cache, no seed reset on deploy):

```dockerfile
CMD ["sh", "-c", "touch database/database.sqlite && php artisan migrate --force && php -d memory_limit=256M artisan icons:cache --no-interaction && php artisan serve --host=0.0.0.0 --port=${PORT:-10000}"]
```

Backup `Dockerfile` CMD (includes seeding on every deploy):

```dockerfile
CMD ["sh", "-c", "touch database/database.sqlite && php artisan migrate --force && php artisan db:seed --force && php -d memory_limit=256M artisan icons:cache --no-interaction && php artisan serve --host=0.0.0.0 --port=${PORT:-10000}"]
```

### Production Deployment

- The production app is deployed on **Render**.
- The production database uses **Neon Postgres**.
- Icon caching runs during startup with an increased PHP memory limit for reliability.
- If icon sets change manually, you can refresh cache with:
  - `php -d memory_limit=256M artisan icons:clear`
  - `php -d memory_limit=256M artisan icons:cache --no-interaction`

**Disclaimer:** This setup runs on free-tier services, so slower response times and cold starts are expected.

## Project Feature Overview

Coachly is an online fitness coaching platform that helps coaches manage clients, programs, and content in one place.

## Core Product Features

- **Client onboarding flow** with workout-style selection during application.
- **Coach dashboard** with a clear view of client progress and status.
- **Program management** where coaches can build and manage structured training plans.
- **Workout and exercise management** inside each program for organized delivery.
- **Blog/content management** so coaches can publish updates and educational posts.

## Client Experience

- Apply for coaching and select preferred training styles.
- View assigned program and training details.
- Update personal profile information from their account.
- Re-apply after finishing a coaching cycle.

## Coach Experience

- Review new applications and manage client pipeline.
- Move clients through coaching stages (lead, pending, active, finished).
- Assign training programs to active clients.
- View client profile details and preferences.
- Edit public coaching style cards shown across the website.
- Mark one coaching style as **Most Popular** with live preview before saving.

## Public Website Features

- Home, About, Contact, Programs, and Blog pages.
- Dynamic Programs section that stays in sync with coach-managed style content.
- Public blog listing and blog detail pages.
- Consistent branding and UI across key pages.

---

**Note:** This project is currently a work in progress, and new features are continuously being added.
