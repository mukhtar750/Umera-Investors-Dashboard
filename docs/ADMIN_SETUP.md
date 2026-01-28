# Admin Setup Guide

This guide details the steps to set up and configure the Umera Investors Dashboard for administrators.

## Prerequisites

Ensure the following are installed on your server or local machine:
-   **PHP**: 8.1 or higher
-   **Composer**: Dependency manager for PHP
-   **Node.js & NPM**: For frontend asset compilation
-   **Database**: MySQL or PostgreSQL

## Installation

1.  **Clone the Repository**
    ```bash
    git clone <repository_url>
    cd umera-investors-dashboard
    ```

2.  **Install PHP Dependencies**
    ```bash
    composer install
    ```

3.  **Install Frontend Dependencies**
    ```bash
    npm install
    npm run build
    ```

4.  **Environment Configuration**
    Copy the example environment file and configure it:
    ```bash
    cp .env.example .env
    ```
    Update the database settings in `.env`:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=umera_dashboard
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5.  **Generate Application Key**
    ```bash
    php artisan key:generate
    ```

6.  **Database Migration & Seeding**
    Run the migrations and seed the database with default data:
    ```bash
    php artisan migrate --seed
    ```

## Default Credentials

The database seeder creates the following default accounts:

### Administrator
-   **Email**: `admin@umera.com`
-   **Password**: `password`

### Investor (Test User)
-   **Email**: `investor@umera.com`
-   **Password**: `password`

> **Security Note**: Please change these passwords immediately after the first login in a production environment.

## Running the Application

To start the local development server:
```bash
php artisan serve
```
Access the dashboard at `http://localhost:8000`.

To host on a specific IP (e.g., for local network access):
```bash
php artisan serve --host=192.168.100.41 --port=8000
```

## Admin Features

-   **User Management**: Create, edit, and manage investor accounts.
-   **Offerings**: Create and manage investment opportunities.
-   **Transactions**: Record deposits, withdrawals, and investments.
-   **Distributions**: Process profit distributions to investors.
-   **Documents**: Upload and share secure documents with investors.
-   **Announcements**: Publish news and updates.
-   **Settings**: Configure system-wide settings like currency and maintenance mode.
