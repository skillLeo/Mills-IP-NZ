# CLAUDE.md — Mills IP NZ Trademark Search & Application Platform

## Project Overview

This is a full Laravel rebuild of a trademark search and application platform for **Mills IP NZ**, a
New Zealand trademark attorney firm. The old system was raw legacy PHP with no framework, no
structure, and inadequate security. This rebuild starts from scratch.

The platform has two sides:
- **Public side** — Anyone can search the IPONZ trademark register and submit a
  five-step trademark application form.
- **Admin side** — The Mills IP NZ legal team logs in privately to manage, track, and update all
  incoming applications.

**Current build scope: Phase 1 only** — Foundation, database, admin auth, and live trademark
search via the IPONZ API.

---

## Client Context

| Field         | Detail                                                    |
|---------------|-----------------------------------------------------------|
| Developer     | Aydin (intermediary agency developer)                     |
| End Client    | Mills IP NZ — New Zealand trademark attorney firm         |
| Market        | New Zealand — businesses and individuals                  |
| Stage         | MVP — concept validation before further investment        |
| Future        | May rebrand as TM.co.nz powered by Mills IP NZ            |
                                      |

> Quality matters significantly — Mills IP is a key client of Aydin's agency.

---

## Tech Stack

| Layer              | Technology                                                  |
|--------------------|-------------------------------------------------------------|
| Backend Framework  | Laravel (latest stable version)                             |
| Frontend           | Blade templating (Laravel native, server-side rendered)     |
| Database           | MySQL                                                       |
| Email              | Laravel Mail + SMTP                                         |
| External API       | IP Australia Government Trademark Database API              |
| API Auth           | OAuth 2.0 (client credentials flow)                         |
| File Storage       | Laravel filesystem (local disk, not publicly browsable)     |
| Admin Auth         | Laravel built-in session authentication                     |
| Security           | Laravel CSRF, XSS, SQL injection prevention, input validation|

---

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── AuthController.php          # Admin login/logout
│   │   │   ├── DashboardController.php     # Applications list (Phase 3)
│   │   │   └── ApplicationController.php  # Application detail/status/notes (Phase 3)
│   │   └── Public/
│   │       ├── SearchController.php        # Trademark search (Phase 1)
│   │       └── ApplicationFormController.php # 5-step form (Phase 2)
│   └── Middleware/
│       └── AdminAuthenticated.php          # Protect admin routes
├── Models/
│   ├── Application.php
│   ├── AdminUser.php
│   ├── ApplicationNote.php
│   └── ApplicationHistory.php
├── Services/
│   └── IPAustraliaService.php             # API wrapper (OAuth + search calls)
resources/
├── views/
│   ├── layouts/
│   │   ├── public.blade.php               # Public site layout
│   │   └── admin.blade.php                # Admin panel layout
│   ├── public/
│   │   ├── search.blade.php               # Homepage search bar
│   │   ├── results.blade.php              # Trademark search results
│   │   └── confirm.blade.php              # Post-submission thank-you (Phase 2)
│   ├── form/
│   │   ├── step1.blade.php                # Trademark description + logo (Phase 2)
│   │   ├── step2.blade.php                # Business description (Phase 2)
│   │   ├── step3.blade.php                # Legal owner details (Phase 2)
│   │   ├── step4.blade.php                # Contact details (Phase 2)
│   │   └── step5.blade.php                # Additional notes (Phase 2)
│   └── admin/
│       ├── login.blade.php                # Admin login page
│       ├── dashboard.blade.php            # Applications list (Phase 3)
│       └── application-detail.blade.php   # Full case view (Phase 3)
routes/
├── web.php                                # All public routes
└── admin.php                              # All admin routes (auth protected)
database/
└── migrations/
    ├── create_admin_users_table.php
    ├── create_applications_table.php
    ├── create_application_notes_table.php
    └── create_application_history_table.php
```

---

## Database Schema

### `admin_users`
| Column       | Type         | Notes                    |
|--------------|--------------|--------------------------|
| id           | bigint PK    |                          |
| name         | varchar      |                          |
| email        | varchar      | unique                   |
| password     | varchar      | bcrypt hashed            |
| created_at   | timestamp    |                          |
| updated_at   | timestamp    |                          |

### `applications`
| Column                  | Type         | Notes                                      |
|-------------------------|--------------|--------------------------------------------|
| id                      | bigint PK    |                                            |
| trademark_description   | text         | Step 1                                     |
| logo_file_path          | varchar      | Step 1 — path in local storage             |
| business_description    | text         | Step 2                                     |
| legal_owner_name        | varchar      | Step 3                                     |
| legal_owner_type        | enum         | individual / company                       |
| abn                     | varchar      | Step 3 — nullable                          |
| contact_name            | varchar      | Step 4                                     |
| contact_email           | varchar      | Step 4                                     |
| contact_phone           | varchar      | Step 4                                     |
| additional_notes        | text         | Step 5 — nullable                          |
| status                  | enum         | Received / Reviewing / Quoted / Filed /    |
|                         |              | Completed / On Hold / Rejected             |
| submitted_at            | timestamp    |                                            |
| created_at              | timestamp    |                                            |
| updated_at              | timestamp    |                                            |

### `application_notes`
| Column          | Type      | Notes                          |
|-----------------|-----------|--------------------------------|
| id              | bigint PK |                                |
| application_id  | bigint FK | → applications.id              |
| admin_user_id   | bigint FK | → admin_users.id               |
| note_text       | text      |                                |
| created_at      | timestamp |                                |

### `application_history`
| Column          | Type      | Notes                                       |
|-----------------|-----------|---------------------------------------------|
| id              | bigint PK |                                             |
| application_id  | bigint FK | → applications.id                           |
| admin_user_id   | bigint FK | → admin_users.id                            |
| action          | varchar   | Description of what changed                 |
| old_value       | varchar   | nullable                                    |
| new_value       | varchar   | nullable                                    |
| created_at      | timestamp | NEVER updatable or deletable — append only  |

> ⚠️ The `application_history` table must never have update or delete operations permitted.
> It is a permanent, read-only audit log.

---

## Common Commands

```bash
# Start local dev server
php artisan serve

# Run all migrations (create tables)
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Seed the first admin user
php artisan db:seed --class=AdminUserSeeder

# Clear config/cache (run after .env changes)
php artisan config:clear
php artisan cache:clear

# Create a new controller
php artisan make:controller Admin/DashboardController

# Create a new model with migration
php artisan make:model Application -m

# Create a new migration
php artisan make:migration create_applications_table

# Create a seeder
php artisan make:seeder AdminUserSeeder

# Run tests
php artisan test
```

---

## Environment Variables (`.env`)

```env
APP_NAME="Mills IP"
APP_ENV=local
APP_KEY=                        # Generated by: php artisan key:generate
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mills_ip
DB_USERNAME=root
DB_PASSWORD=

# IP Australia API — REQUIRED FOR PHASE 1 SEARCH FEATURE
IP_AUSTRALIA_CLIENT_ID=         # ⚠️ Must be provided by client
IP_AUSTRALIA_CLIENT_SECRET=     # ⚠️ Must be provided by client
IP_AUSTRALIA_TOKEN_URL=         # ⚠️ Must be provided by client
IP_AUSTRALIA_BASE_URL=          # ⚠️ Must be provided by client

# SMTP Email — REQUIRED FOR PHASE 2
MAIL_MAILER=smtp
MAIL_HOST=                      # To be confirmed by client
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@millsip.com.au
MAIL_FROM_NAME="Mills IP"
```

---

## IP Australia API — How It Works

The trademark search uses **OAuth 2.0 client credentials flow**.

### Step 1 — Fetch Access Token
```
POST {IP_AUSTRALIA_TOKEN_URL}
Content-Type: application/x-www-form-urlencoded

grant_type=client_credentials
&client_id={IP_AUSTRALIA_CLIENT_ID}
&client_secret={IP_AUSTRALIA_CLIENT_SECRET}

Response: { "access_token": "...", "expires_in": 3600 }
```

### Step 2 — Search Trademarks
```
GET {IP_AUSTRALIA_BASE_URL}/trademarks/search?q={brand_name}
Authorization: Bearer {access_token}

Response: Array of matching trademark records
```

### Service class location
```
app/Services/IPAustraliaService.php
```

The service class handles:
- Token fetching and caching (cache the token for its TTL, don't fetch on every request)
- Injecting the Bearer token into search requests
- Returning clean, structured results to the controller
- Error handling if the API is unavailable

---

## Admin Authentication

- Uses Laravel's built-in session authentication
- Guard: `web` (default)
- No public registration — admin accounts created manually via seeder
- All admin routes wrapped in `auth` middleware
- Session expires after inactivity (configured in `config/session.php`)

### Admin routes are defined in `routes/admin.php` and registered in `RouteServiceProvider`

```php
// All admin routes require authentication
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    // ... more routes
});

// Login routes are public
Route::get('/admin/login', [AuthController::class, 'showLogin']);
Route::post('/admin/login', [AuthController::class, 'login']);
Route::post('/admin/logout', [AuthController::class, 'logout']);
```

---

## Security Requirements

These are non-negotiable — this platform handles personal and legal data:

- ✅ CSRF tokens on every form (Laravel handles automatically with `@csrf`)
- ✅ All user input validated before processing (use Laravel Form Requests)
- ✅ Passwords hashed with bcrypt (never stored plain)
- ✅ Admin routes protected by auth middleware — no exceptions
- ✅ Uploaded files stored in `storage/app/private/` — not in `public/`
- ✅ No raw SQL — use Eloquent ORM to prevent SQL injection
- ✅ XSS protection via Blade's `{{ }}` auto-escaping (never use `{!! !!}` on user input)
- ✅ `.env` file never committed to version control

---

## Application Status Values

These are the only valid status values for an application:

```
Received   (default on submission)
Reviewing
Quoted
Filed
Completed
On Hold
Rejected
```

Store as an enum or a constants class. Never allow arbitrary string values.

---

## File Upload Rules

- Logo uploads accepted in Phase 2
- Accepted formats: JPEG, PNG, GIF, SVG, WEBP
- Max file size: to be confirmed (suggest 5MB)
- Store in: `storage/app/private/logos/`
- File path saved in `applications.logo_file_path`
- Files must NOT be publicly browsable — serve via authenticated controller method only

---

## Build Phases

### ✅ Phase 1 — Current Scope
- [ ] Laravel project scaffolded and running
- [ ] `.env` configured with DB and API placeholders
- [ ] All database migrations created and run cleanly
- [ ] AdminUser seeder created — first admin account seeded
- [ ] Admin login page built and working
- [ ] Admin logout working
- [ ] Admin routes protected — unauthenticated users redirected to login
- [ ] `IPAustraliaService` class built with OAuth token fetch
- [ ] Trademark search controller and route created
- [ ] Public search page (homepage) built with search bar
- [ ] Search results page built — displays real API results
- [ ] API credentials integrated from `.env` — search tested live

### 🔜 Phase 2 — Not Yet Started
- Five-step application form
- Logo file upload
- Database submission on form complete
- Two automated emails on submission
- Submission confirmation page

### 🔜 Phase 3 — Not Yet Started
- Admin dashboard (applications list, search, filter)
- Application detail page
- Status management
- Internal notes panel
- Audit history log
- Full testing, bug fixing, deployment

---

## Hard Blockers

| Blocker | Impact | Status |
|---------|--------|--------|
| IP Australia API credentials (Client ID, Secret, Token URL, Base URL) | Cannot build or test trademark search | ⚠️ Awaiting from client |
| SMTP credentials | Cannot build or test emails (Phase 2) | ⚠️ Awaiting from client |
| Hosting environment details | Cannot deploy (Phase 3) | ⚠️ Awaiting from client |

---

## Key Decisions & Constraints

- **Full rebuild in Laravel** — no patching of old raw PHP codebase. Decision is final.
- **MVP scope is fixed** — no features added without explicit client approval.
- **No payment processing** — out of scope for this MVP entirely.
- **Rebrand-ready** — design and code must support a domain/logo swap to TM.com.au without a rebuild.
- **Modular architecture** — must be able to add payment gateway and new features in future phases without structural changes to core.
- **Two submission emails are non-negotiable** — must fire reliably every single time.
- **Audit history log is permanent** — no update or delete operations ever allowed on that table.

---

## What Success Looks Like (Phase 1)

Phase 1 is complete when:
1. `php artisan serve` runs with no errors
2. `php artisan migrate` creates all tables cleanly
3. Admin can log in at `/admin/login` with seeded credentials
4. Unauthenticated users cannot access any `/admin/*` route
5. A brand name typed into the public search bar returns real trademark results from the IP Australia government database
6. The search results page displays those results clearly on screen
