# Project Name
**Juicebox Laravel 11 Post**

## Description

This project is a showcase for the backend take-home test, demonstrating skills in Laravel 11, PHP 8.3, MySQL, and Redis.

## Installation

1. Clone the Repository:
Use Git to clone the repository:
`git clone <repository-url>`

2. Install Dependencies:
Navigate to the project directory and install the necessary libraries and packages:
`composer install`

3. Configure Environment:
Copy the .env.example file to .env and update it with your database connection settings:
Enable redis

4. Run Migrations:
Apply the database migrations to set up the schema:
php artisan migrate

5. Clear Redis Cache:
Flush the Redis cache to ensure a clean state:
`php artisan optimize:clear`

6. Run Tests:
Execute the test suite to verify the application:
`php artisan test`

This project requires PHP 8.3, MySQL, and Redis. To streamline the setup, the project is already deployed on my server. Details and API endpoint requirements have been shared via email. You are welcome to test the application.
