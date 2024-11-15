# Laravel-Task-Manager

Laravel Task Manager is a simple and efficient task management application built with Laravel. Follow the steps below to set up the project.

## Getting Started

1. Clone the repository to your local machine:
   git clone https://github.com/arberejupi/Laravel-Task-Manager.git

2. Navigate to the project directory and install the required PHP dependencies:
   cd Laravel-Task-Manager
   composer install

3. Copy the `.env.example` file to `.env` to set up environment configurations:
   copy .env.example .env

4. Generate a unique application key:
   php artisan key:generate

5. Open the `.env` file and configure the database:
   DB_CONNECTION=mysql  
   DB_HOST=127.0.0.1  
   DB_PORT=3306  
   DB_DATABASE=laravel  
   DB_USERNAME=root  
   DB_PASSWORD=

7. Run the database migrations to set up the database structure:
   php artisan migrate

8. Install the required frontend dependencies:
   npm install

9. Compile the frontend assets:
   npm run dev

10. Start the Laravel development server:
   php artisan serve

---

Your Laravel Task Manager project should now be up and running! Open your browser and navigate to the URL provided by `php artisan serve` (usually `http://127.0.0.1:8000`).
