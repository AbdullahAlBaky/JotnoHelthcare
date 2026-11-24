# JotnoHealthcare

JotnoHealthcare is a web-based healthcare project with a Vue 3 frontend and a Laravel 12 REST API. The current implementation provides user registration and login, authenticated patient dashboard/profile pages, and CRUD operations for a patient's medical history.

## Current features

- Account registration for `patient` and `caregiver` roles
- Login and logout using Laravel Sanctum personal access tokens
- Authenticated user profile endpoint
- Patient dashboard and profile pages
- Medical history: create, list, update, and delete
- Medical history records are associated with their owner (`users` → `medical_histories`)

> Scope note: Doctor consultation, health monitoring, notifications, appointment booking, and other future-facing dashboard menu items are not implemented by the source code reviewed for this documentation. Do not present them as completed features.

## Technology stack

| Layer | Technology |
|---|---|
| Frontend | Vue 3, TypeScript, Vue Router, Axios, Vite |
| Backend | PHP 8.2+, Laravel 12 |
| API authentication | Laravel Sanctum |
| Database | Laravel migrations; `.env.example` is configured for MySQL |

## Repository structure

```text
JotnoHelthcare/
├── frontend/                 # Vue application
│   └── src/
│       ├── router/            # Client-side routes and auth navigation guard
│       ├── services/          # Axios API client
│       └── views/             # Home, login, register, dashboard, profile, history
├── backend/                  # Laravel application and REST API
│   ├── app/Http/Controllers/Api/
│   ├── app/Models/
│   ├── database/migrations/
│   └── routes/api.php
├── docs/                     # Project, API, database and testing documentation
└── postman/                  # Importable API collection
```

## Local setup

### 1. Backend

Requirements: PHP 8.2+, Composer, and a database supported by the Laravel configuration.

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
```

Edit `backend/.env` and set the database connection details. The provided example uses MySQL (`jotnohealthcare` database). Create that database before migrating.

```bash
php artisan migrate
php artisan serve
```

The API base URL is `http://127.0.0.1:8000/api` in the current frontend Axios configuration.

### 2. Frontend

Use Node.js compatible with the frontend package's engine requirement (Node 22.18+ or 24.12+).

```bash
cd frontend
npm install
npm run dev
```

Open the local URL printed by Vite. Keep the Laravel API server running in another terminal.

### 3. Build check

```bash
cd frontend
npm run build
```

Backend tests can be run with:

```bash
cd backend
php artisan test
```

## API documentation and testing

- [API Reference](docs/API_DOCUMENTATION.md)
- [Database Design](docs/DATABASE_DESIGN.md)
- [Testing Checklist](docs/TESTING_CHECKLIST.md)
- [Postman Collection](postman/JotnoHealthcare.postman_collection.json)

Import the Postman collection and set `baseUrl` to `http://127.0.0.1:8000/api`. Register/login first; the collection stores the returned token in the `token` collection variable for protected requests.

## Security and privacy notes

- Never commit `.env`, database credentials, real patient information, or access tokens.
- Use fictional data when demonstrating or testing the application.
- Medical history is sensitive information. Keep access authenticated and verify ownership checks when adding new endpoints.
- The current frontend API URL is hard-coded for local development; configure environment-specific API URLs before deployment.

## Team contribution

This repository is a collaborative project. Add new work through a focused branch and pull request, and avoid overwriting another member's frontend/backend work. Update this documentation whenever implemented features or API contracts change.
