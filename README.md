<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Task Solution 
# 🛒 Laravel Product CRUD System

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-10.x-red" />
  <img src="https://img.shields.io/badge/PHP-8.0%2B-blue" />
  <img src="https://img.shields.io/badge/Bootstrap-5-purple" />
  <img src="https://img.shields.io/badge/Status-Completed-success" />
</p>

---

## 📋 Project Overview

A complete **Laravel web application** demonstrating **Database Operations** and **CRUD functionality** for product management.

This project was developed as a **university training task** to showcase:

* Laravel **MVC architecture**
* **Eloquent ORM**
* **Migrations, Seeders, and Factories**
* Full **CRUD operations** with a modern UI

---

## 🎯 Features Implemented

### 🧩 Part 1: Database Operations

* ✅ Product model with mass assignment protection
* ✅ Database migration for products table
* ✅ Seeder & factory using Faker
* ✅ Tinker testing for database operations

### 🔁 Part 2: CRUD Operations

* ✅ Create new products
* ✅ Read & list products with statistics
* ✅ Update product information
* ✅ Delete products with confirmation
* ✅ Form validation with error handling
* ✅ Fully responsive design

### ⚙️ Technical Highlights

* 🎨 Bootstrap 5 modern UI
* ⚡ Smooth CSS animations
* 📱 Mobile-first responsive layout
* 🔒 CSRF protection & validation
* 📊 Real-time product statistics

---

## 🏗️ Project Structure

```text
app/
├── Models/
│   └── Product.php
├── Http/Controllers/
│   ├── ProductController.php
│   └── HomeController.php

database/
├── migrations/
├── seeders/ProductSeeder.php
└── factories/ProductFactory.php

resources/views/
├── layouts/app.blade.php
├── welcome.blade.php
└── products/
    ├── index.blade.php
    ├── create.blade.php
    ├── edit.blade.php
    └── show.blade.php

routes/
└── web.php
```

---

## 🚀 Quick Installation Guide

### 🔧 Prerequisites

* PHP 8.0 or higher
* Composer
* MySQL / MariaDB (XAMPP recommended)
* Git

### 📥 Step 1: Clone & Setup

```bash
git clone https://github.com/yourusername/product-crud-system.git
cd product-crud-system
composer install
cp .env.example .env
```

### 🗄️ Step 2: Database Configuration (XAMPP)

Edit `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=product_crud
DB_USERNAME=root
DB_PASSWORD=
```

### ⚙️ Step 3: Initialize Application

```bash
php artisan key:generate
php artisan migrate
php artisan db:seed --class=ProductSeeder
# or
php artisan db:seed
```

### ▶️ Step 4: Run Server

```bash
php artisan serve
```

---

## 🌐 Application Access

* **Home Page**

  * `http://localhost:8000/`
  * Project overview & documentation

* **Products Dashboard**

  * `http://localhost:8000/products`
  * Manage products (CRUD)

### 🔀 Navigation Flow

```text
Home Page
   ↓
Launch Product Manager
   ↓
Products List
   ↓
Create | Edit | View | Delete
```

---

## 🔧 Useful Artisan Commands

### 🗄️ Database

```bash
php artisan make:model Product -m
php artisan migrate
php artisan migrate:rollback
php artisan migrate:fresh --seed
```

### 🌱 Seeding & Factories

```bash
php artisan db:seed --class=ProductSeeder
php artisan db:seed
php artisan tinker
>>> Product::factory()->count(10)->create()
```

### 🛠️ Development

```bash
php artisan serve
php artisan route:list
php artisan optimize:clear
```

---

## 🧪 Testing with Tinker

```bash
php artisan tinker
>>> Product::all()
>>> Product::count()
>>> Product::find(1)
>>> Product::create(['name' => 'Test', 'price' => 99.99])
>>> $p = Product::find(1); $p->price = 49.99; $p->save();
>>> Product::find(1)->delete();
```

---

## 📁 Key Files Explained

| File                      | Description    |
| ------------------------- | -------------- |
| Product.php               | Eloquent model |
| ProductController.php     | CRUD logic     |
| create_products_table.php | Migration      |
| ProductSeeder.php         | Sample data    |
| ProductFactory.php        | Faker data     |
| web.php                   | Routes         |

---

## 🎨 UI / UX Design

* Professional blue gradient theme
* Font Awesome icons
* Smooth animations:

  * Fade-in
  * Slide-in
  * Hover & pulse effects
* Responsive Bootstrap grid
* Alert notifications & confirmations

---

## 🛠️ Troubleshooting

### ❌ Database Error

```bash
php artisan config:clear
```

### ❌ Migration Issues

```bash
php artisan migrate:fresh
php artisan db:seed
```

### ❌ Permissions (Linux/Mac)

```bash
chmod -R 755 storage bootstrap/cache
```

---

## 📚 Learning Objectives

* MVC Architecture
* Laravel Eloquent ORM
* Migrations & Versioning
* Seeders & Factories
* CRUD Operations
* Blade Templates
* Validation & Security
* RESTful Routing

---

## 🤝 Contributing

1. Fork the repository
2. Create a new branch
3. Make improvements
4. Test thoroughly
5. Submit a pull request

### 💡 Suggested Enhancements

* Search & pagination
* Product categories
* Image uploads
* User authentication
* CSV / Excel export

---

## 📄 License

University Training Project – Educational Use Only

---

## 👨‍💻 Author

**Student Name**
University Training Task – Laravel Development
🔗 GitHub: [https://github.com/yourusername](https://github.com/yourusername)

---

⭐ If this project helped you learn Laravel, don’t forget to give it a star!

**Happy Coding! 🚀**
