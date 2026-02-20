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

### Realtime Notifications (Pusher)

Coachly uses **Pusher Channels** for realtime notification delivery.

1. Create a **Channels** app in Pusher (not Beams).
2. Add your credentials to `.env`:

```ini
BROADCAST_CONNECTION=pusher

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=ap1

VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

3. Clear cached config after updating env values:

```bash
php artisan config:clear
```

`composer run dev` already runs the app server, queue worker, logs, and Vite.

The notification sound is played when a new realtime notification arrives. Place your audio file at `public/audio/new-notification.mp3` (or update the path in the coach and client layouts).

### Test Users

After running `php artisan migrate:fresh --seed`, use these credentials:

| Role   | Email                | Password |
| ------ | -------------------- | -------- |
| Client | client@example.com   | password |
| Coach  | coachlee@coachly.fit | password |

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
- **Book a session** when applying: choose a date (no past dates) and start time (8 AM–6 PM, 12-hour format). Time slots already booked by other clients are disabled for the selected date and validated on submit. Requested session is shown on your dashboard while pending or active.
- View assigned program and training details.
- Update personal profile information from their account.
- Re-apply after finishing a coaching cycle.
- **Realtime notifications**: sound plays for new notifications; browser tab title shows e.g. “1 new notification” when there are unread notifications.

## Coach Experience

- Review new applications and manage client pipeline.
- See **requested session** (date and time) for pending and active clients on the client list and client detail page. Not shown for finished clients; a new session appears when a client applies again.
- Move clients through coaching stages (lead, pending, active, finished).
- Assign training programs to active clients.
- View client profile details and preferences.
- Edit public coaching style cards shown across the website.
- Mark one coaching style as **Most Popular** with live preview before saving.
- **Realtime notifications**: new application notifications include requested session when provided; sound and browser tab title for unread notifications.

## Public Website Features

- Home, About, Contact, Programs, and Blog pages.
- Dynamic Programs section that stays in sync with coach-managed style content.
- Public blog listing and blog detail pages.
- Consistent branding and UI across key pages.

---

**Note:** This project is currently a work in progress, and new features are continuously being added.
