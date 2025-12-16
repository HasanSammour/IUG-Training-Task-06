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
