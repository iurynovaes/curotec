# Job Application Platform

## Description

This is a Job Application Platform that allows users to browse job listings, filter them by various criteria, and submit job applications securely. Built with modern technologies to ensure performance, scalability, and maintainability.

## Technologies Used

- PHP 8.2+
- Laravel 10
- MySQL
- PHPUnit

## API Routes

All API routes are protected by an `X-API-KEY` header for authentication.

| Method | Endpoint               | Description                   |
|--------|------------------------|-------------------------------|
| GET    | /api/jobs              | List jobs with optional filters |
| POST   | /api/jobs/{job_id}/apply | Submit a job application       |

## Request Payloads

### GET /api/jobs

Optional query parameters (filters):

- `type`: Job type (e.g., full-time, part-time)
- `experience_level`: Experience level (e.g., junior, mid, senior)
- `category_id`: Filter by category ID
- `location_id`: Filter by location ID
- `title`: Search job title
- `order_by`: Field to order results by
- `active`: Boolean, filter active jobs
- `remote`: Boolean, filter remote jobs
- `per_page`: Number of jobs per page (1 to 50)

Example:

```
GET /api/jobs?category_id=1&location_id=2&type=full-time&active=1&per_page=10
```

### POST /api/jobs/{job_id}/apply

Request JSON body or multipart form data:

```json
{
  "name": "Applicant Name",
  "email": "applicant@example.com",
  "job_id": 1,
  "user_id": 10,
  "phone": "(123) 456-7890",
  "last_position": "Developer",
  "experience_years": 5,
  "experience_level": "senior",
  "resume": "(file, pdf/doc/docx, max 2MB)",
  "cover_letter": "(optional file, pdf/doc/docx, max 2MB)"
}
```

Example successful response:

```json
{
  "message": "Application submitted successfully."
}
```

## Authentication Instructions

The API uses an `X-API-KEY` header for authentication. All requests must include this header:

```
X-API-KEY: your_global_api_key_here
```

A test user is created via seeder:

```php
User::create([
    'name' => 'Test User',
    'email' => 'test@example.com',
    'password' => Hash::make('password'),
]);
```

Use this user for authentication or testing purposes as needed.

## Running the Project

Follow these steps to set up and run the project locally:

1. **Clone the repository**

```bash
git clone https://your-repo-url.git
cd your-project-folder
```

2. **Install dependencies**

```bash
composer install
```

3. **Set up environment**

Generate the application key:

```bash
php artisan key:generate
```

Add the API_GLOBAL_TOKEN value in the .env file:

```bash
API_GLOBAL_TOKEN="curotec"
```

4. **Run migrations and seeders**

```bash
php artisan migrate --seed
```

5. **Serve the application**

```bash
php artisan serve
```

The app will be available at `http://localhost:8000`.
