# Translation Management Service

## Overview

This is a simple API-based Translation Management Service built with Laravel.

It allows you to:

* Store translations for multiple languages (e.g., en, fr, es)
* Tag translations (e.g., mobile, web, desktop)
* Create, update, delete, and search translations
* Export translations as JSON for frontend applications
* Secure all endpoints using token authentication

---

## Requirements

* PHP 8.2+
* Composer
* MySQL (or compatible database)

---

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/supremojvy25/translation-service.git
cd translation-service
```

### 2. Install dependencies

```bash
composer install
```

### 3. Setup environment

Copy the environment file:

```bash
cp .env.example .env
```

Generate app key:

```bash
php artisan key:generate
```

Update your database settings inside `.env`:

```
DB_DATABASE=translation_service
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Run migrations

```bash
php artisan migrate
```

### 5. Install Sanctum (for API authentication)

```bash
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

---

## Running the Project

Start the development server:

```bash
php artisan serve
```

The API will be available at:

```
http://127.0.0.1:8000/api
```

---

## Authentication

Create a test user using Tinker:

```bash
php artisan tinker
```

```php
\App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => bcrypt('password')
]);
```

Generate API token:

```php
$user = \App\Models\User::first();
$user->createToken('api-token')->plainTextToken;
```

Use the token in your requests:

```
Authorization: Bearer YOUR_TOKEN
Accept: application/json
```

---

## API Endpoints

### Create Translation

POST `/api/translations`

Sample:
```
http://127.0.0.1:8000/api/translations
{
    "key": "welcome",
    "locale": "en",
    "content": "Welcome",
    "tags": ["web"]
}
```

### Get All Translations

GET `/api/translations`

Sample:
```
http://127.0.0.1:8000/api/translations
```

### Search Translation

GET `/api/translations/search?key=welcome`

Sample:
```
http://127.0.0.1:8000/api/translations/search?key=welcome
```

### Export Translations

GET `/api/translations-export?locale=en`

Sample:
```
http://127.0.0.1:8000/api/translations-export?locale=en
```

---

## Seeding Large Data (Optional)

To generate 100,000 test records:

```bash
php artisan db:seed --class=TranslationSeeder
```

---

## Design Choices

* Single `translations` table with indexed `key` and `locale`
* JSON column used for flexible tagging
* Unique constraint on `key + locale`
* Token-based authentication using Sanctum
* Streaming export for handling large datasets efficiently

---

## Testing

Run automated tests:

```bash
php artisan test
```
