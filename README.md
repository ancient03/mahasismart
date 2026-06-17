# MahasiSmart 🎓🛒

MahasiSmart is a modern e-commerce and marketplace platform tailored for university students. It facilitates buying, selling, and managing products with seamless payment gateway integration.

## 👥 Project Team

*   [@toffann](https://github.com/toffann) ( Project Manager)
*   [@RestuArdiannsyah](https://github.com/RestuArdiannsyah) (Front End Developer)
*   [@ancient03](https://github.com/ancient03) (Backend Developer)
*   [@NandikaPrapanca](https://github.com/NandikaPrapanca) (UI/UX Designer)
*   [@fikrialif1](https://github.com/fikrialif1) (UI/UX Designer)

## 🌟 Key Features

*   **Student-Centric:** Registration and authentication tied to student emails.
*   **Shop Management (Toko):** Allows students to open and manage their own stores, including store logos and banners.
*   **Product Management:** Categories, product details, stock management, and product photos.
*   **Shopping Cart & Transactions:** Full checkout process including cart management, address selection, and transaction history.
*   **Payment Gateway Integration:** Secure payment processing via **Midtrans** (supports multiple payment methods).
*   **Reviews & Ratings:** Customers can leave reviews and upload photos for purchased products.
*   **Returns (Retur) & Reports:** Built-in system for product returns and reporting issues.
*   **Advertising (Iklan):** Feature for promoting products/stores.
*   **FAQ System:** Dynamic FAQ management categorized by topics.

## 🛠 Technology Stack

*   **Framework:** Laravel 12 (PHP 8.2+)
*   **Frontend:** Tailwind CSS, Vite, Blade Components
*   **Database:** MySQL / MariaDB
*   **Payment Gateway:** Midtrans PHP Client
*   **Icons:** Bootstrap Icons

## 📋 Prerequisites

Before you begin, ensure you have met the following requirements:
*   PHP ^8.2
*   Composer
*   Node.js & npm
*   MySQL/MariaDB

## 🚀 Installation & Setup

1.  **Clone the repository and pull the latest changes**
    ```bash
    git pull origin main
    ```

2.  **Install PHP dependencies**
    ```bash
    composer install
    ```

3.  **Install NPM packages**
    ```bash
    npm install
    ```

4.  **Environment Setup**
    Copy the environment file and set up your variables:
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
    *Make sure to configure your `DB_*` and `MIDTRANS_*` variables in the `.env` file.*

5.  **Run Database Migrations & Seeders**
    ```bash
    php artisan migrate --seed
    ```

6.  **Create Symbolic Link for Storage**
    ```bash
    php artisan storage:link
    ```

## 📜 Rules Coding (Important!)

Please adhere to the following rules when contributing to this project:

### 1. View Requirements
Every Blade view that uses Tailwind CSS **must** include the following in the `<head>` section:

```html
<!-- tailwindcss, font -->
@vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/font.css'])

<!-- bootstrap icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
```

### 2. Starting the Application
To run the application locally, you need two terminal tabs:

**Terminal 1 (Backend):**
```bash
php artisan serve
```

**Terminal 2 (Frontend/Vite):**
```bash
npm run dev
```

### 3. Database Management
*   To create/update the database structure:
    ```bash
    php artisan migrate
    ```
*   **Warning:** If there are major edits to the database structure during development, reset it using:
    ```bash
    php artisan migrate:fresh
    ```
    *(Note: This will erase all existing data)*

### 4. General Commands
*   **Clear Config Cache:**
    ```bash
    php artisan config:clear
    ```
*   **Create Blade Components:**
    ```bash
    php artisan make:component ComponentName
    ```
    *If making a component inside a specific folder:*
    ```bash
    php artisan make:component folder/ComponentName
    ```

## 💳 Midtrans Configuration

This project uses Midtrans for payments. Ensure you have the following in your `.env` file based on your Midtrans Dashboard (Sandbox/Production):

```env
MIDTRANS_MERCHANT_ID=your_merchant_id
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_IS_PRODUCTION=false
```




