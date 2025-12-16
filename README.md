<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Task Solution 
# 🧩 Task 04 – Product Validation & Data Integrity

## 📋 Project Overview
This task enhances the **Product CRUD System** developed in **Task 03 – Part 2** by adding **server-side validation** and enforcing **database integrity rules**.  
The goal is to ensure clean data, prevent invalid inputs, and improve user experience through clear validation feedback.

---

## 🔧 New Features Added

- ✅ **Form Request Validation**
  - `StoreProductRequest`
  - `UpdateProductRequest`

- ✅ **Database Integrity**
  - Unique constraint on product name
  - Decimal validation for product price

- ✅ **Improved Error Handling**
  - Clear, user-friendly validation messages

- ✅ **Old Input Preservation**
  - Form values remain after validation errors

---

## 🛠️ Commands Used

```bash
# Create Form Request classes
php artisan make:request StoreProductRequest
php artisan make:request UpdateProductRequest

# Create migration to add unique constraint
# !! This is Optional Since i did not do it
php artisan make:migration add_unique_to_products_name --table=products

# Run migrations
php artisan migrate

# Refresh database (optional)
php artisan migrate:fresh --seed

---

📁 New Files Structure
app/Http/Requests/
                ├── StoreProductRequest.php    # Create validation rules
                └── UpdateProductRequest.php   # Update validation rules

database/migrations/
                └── xxxx_add_unique_to_products_name.php  # Unique constraint

---

🎯 Key Improvements

Unique Product Names
Prevents adding duplicate product names.

Price Validation
Price must be greater than 0 and follow decimal format.

Smart Update Validation
Ignores the current product ID when checking for name uniqueness.

Better UX
Clear validation error messages displayed under each form field.

Clean Code
Validation logic moved from controllers to Form Request classes.

---

🌐 How to Test

Try adding a product with an existing name → ❌ Error shown
Try entering price = 0 or a negative value → ❌ Error shown
Submit the form with an empty name         → ❌ Error shown
Update a product without changing its name → ✅ Works correctly
Update a product using a duplicate name    → ❌ Error shown

---

🔍 Database Changes
-- Added to products table:
ALTER TABLE products ADD UNIQUE (name);

-- Price column remains:
-- DECIMAL(10,2)

---

🚀 Quick Start
# If starting fresh:
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve

---

Visit the application at: 
http://localhost:8000/products

---

📝 Note
This task extends Task 03 – Part 2 by adding validation and database integrity features,
while maintaining all existing CRUD functionality.

---

## 📄 License

University Training Project – Educational Use Only

---

## 👨‍💻 Author

**Hasan Younis Sammour**
University Training Task – Back-end Development {Laravel framework}
🔗 GitHub: [https://github.com/HasanSammour](https://github.com/HasanSammour)

---

⭐ If this project helped you learn Laravel, don’t forget to give it a star!

**Happy Coding! 🚀**