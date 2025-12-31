<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Task Solution 
# 🛒 Task 06 – Enhanced Product Management System with Suppliers & Many-to-Many Relationships

## 📋 Project Overview
This task significantly enhances the **Product Management System** by implementing a *complete many-to-many relationship* between Products and Suppliers with pivot data, advanced form handling, and improved data visualization. The system now includes supplier management, cost tracking, lead time management, and enhanced CRUD operations while maintaining all *validation and relationships* from **Task 05**.

---

## ✨ Major Enhancements & New Features

### 🗄️ **Database & Backend Improvements**
- ✅ **Complete Supplier System** – New `suppliers` table with unique constraints
- ✅ **Pivot Table with Additional Data** – `product_supplier` table with `cost_price` and `lead_time_days`
- ✅ **Many-to-Many Relationships** – Products can have multiple suppliers, suppliers can supply multiple products
- ✅ **Eloquent Relationships with Pivot Data** – Proper `withPivot()` and `withTimestamps()` configuration
- ✅ **Composite Unique Constraint** – Prevents duplicate product-supplier combinations
- ✅ **Enhanced Seeding** – SupplierSeeder and ProductSupplierSeeder with realistic pivot data

### 🎨 **UI/UX Enhancements**
- ✅ **Dynamic Supplier Selection** – Checkbox interface in create/edit forms
- ✅ **Pivot Data Input Forms** – Cost price and lead time inputs for each supplier
- ✅ **Enhanced Product Display** – Supplier information in all product views
- ✅ **Supplier Statistics** – Count of suppliers per product in listings
- ✅ **Responsive Tables** – Better organization with supplier information

### 📊 **New Views & Components**
- ✅ **Updated Create/Edit Forms** – Supplier selection with pivot data inputs
- ✅ **Enhanced Product Tables** – Supplier column with pivot data display
- ✅ **Improved Show View** – Complete supplier information with pivot details
- ✅ **Supplier Management** – Comprehensive supplier data handling

### 🔧 **Technical Improvements**
- ✅ **Form Request Validation** – Enhanced validation for suppliers and pivot data
- ✅ **Controller Synchronization** – Efficient `sync()` method for many-to-many relationships
- ✅ **Eager Loading Optimization** – N+1 problem prevention with `with()` and `withCount()`
- ✅ **Database Integrity** – Proper foreign key constraints and cascade deletion

---

## 🛠️ Technologies Used

- **Laravel 12** – PHP framework with Eloquent ORM
- **MySQL** – Relational database with foreign keys and pivot tables
- **Bootstrap 5** (Local) – Frontend framework hosted locally
- **JavaScript (Vanilla)** – Dynamic form interactions
- **HTML5 & CSS3** – Modern markup and styling
- **FontAwesome** – Icon library for better visuals

---

## 🗂️ Project Structure :: *what i made changes on in this Task*

```
app/
├── Http/
│   ├── Controllers/
│   │   └── ProductController.php        # Enhanced with supplier sync logic
│   ├── Requests/
│   │   ├── StoreProductRequest.php      # Enhanced with supplier validation
│   │   └── UpdateProductRequest.php     # Enhanced with supplier validation
├── Models/
│   ├── Product.php                      # Added suppliers relationship
│   ├── Category.php                     # Unchanged from Task 05
│   └── Supplier.php                     # NEW: Supplier model with products relationship
database/
├── migrations/
│   ├── 2025_xx_xx_xxxxxx_create_suppliers_table.php          # NEW: Suppliers table
│   ├── 2025_xx_xx_xxxxxx_create_product_supplier_table.php   # NEW: Pivot table
├── seeders/
│   ├── DatabaseSeeder.php               # Updated to include supplier seeding
│   ├── ProductSeeder.php                # Enhanced product seeding
│   ├── CategorySeeder.php               # From Task 05
│   ├── SupplierSeeder.php               # NEW: Seeds 8 suppliers
│   └── ProductSupplierSeeder.php        # NEW: Attaches suppliers to products
└── factories/
    └── ProductFactory.php               # From Task 05

resources/views/
├── categories/
│   └── products.blade.php               # Enhanced with suppliers column
├── layout/
│   └── app.blade.php                    # Enhanced with new button for suppliers
└── products/
    ├── index.blade.php                  # Enhanced with suppliers column
    ├── create.blade.php                 # Enhanced with supplier selection
    ├── edit.blade.php                   # Enhanced with supplier editing
    └── show.blade.php                   # Enhanced with supplier details

public/
├── bootstrap/                               # Local Bootstrap assets
    ├── css/                                 # Bootstrap & Custom CSS files
    └── js/                                  # Bootstrap & Custom JavaScript files

```

---

## 🔗 Database Schema & Relationships

### **Suppliers Table (NEW)**
```sql
CREATE TABLE suppliers (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) UNIQUE NOT NULL,      -- Unique supplier names
    email VARCHAR(255) UNIQUE NOT NULL,     -- Unique supplier emails
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### **Product_Supplier Pivot Table (NEW)**
```sql
CREATE TABLE product_supplier (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    product_id BIGINT UNSIGNED NOT NULL,
    supplier_id BIGINT UNSIGNED NOT NULL,
    cost_price DECIMAL(10,2) NOT NULL CHECK (cost_price >= 0),
    lead_time_days INTEGER NOT NULL CHECK (lead_time_days >= 0),
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (supplier_id) REFERENCES suppliers(id) ON DELETE CASCADE,
    UNIQUE KEY unique_product_supplier (product_id, supplier_id)  -- Composite unique constraint
);
```

### **Eloquent Relationships**

**Product Model:**
```php
class Product extends Model
{
    // From Task 05
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    // NEW for Task 06: Many-to-Many with pivot data
    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class)
                    ->withPivot(['cost_price', 'lead_time_days'])
                    ->withTimestamps();
    }
}
```

**Supplier Model (NEW):**
```php
class Supplier extends Model
{
    // Many-to-Many with pivot data
    public function products()
    {
        return $this->belongsToMany(Product::class)
                    ->withPivot(['cost_price', 'lead_time_days'])
                    ->withTimestamps();
    }
}
```

---

## 🚀 Installation & Setup

```bash
# 1. Clone and navigate to project
git clone https://github.com/HasanSammour/IUG-Training-Task-06.git
cd IUG-Training-Task-06

# 2. Install dependencies
composer install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Configure database (update .env)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task06
DB_USERNAME=root
DB_PASSWORD=

# 5. Run migrations (in correct order)
php artisan migrate

# 6. Seed the database
php artisan db:seed

# 7. Start development server
php artisan serve
```

---

## 🌐 Application Routes

### **Enhanced Product Routes**
```php
Route::resource('products', ProductController::class);
```

### **Complete Route List**
| Method | URI | Action | Description |
|--------|-----|--------|-------------|
| GET | `/products` | `index()` | List all products with suppliers & pagination |
| GET | `/products/create` | `create()` | Show create form with supplier selection |
| POST | `/products` | `store()` | Store new product with suppliers & pivot data |
| GET | `/products/{product}` | `show()` | Show product with all supplier details |
| GET | `/products/{product}/edit` | `edit()` | Edit form with supplier pre-selection |
| PUT/PATCH | `/products/{product}` | `update()` | Update product and supplier relationships |
| DELETE | `/products/{product}` | `destroy()` | Delete product with cascade to pivot |

---

## 📊 Database Seeding Details

### **Default Suppliers Created:**
```php
// SupplierSeeder creates:
[
    ['name' => 'Tech Suppliers Inc.', 'email' => 'orders@techsuppliers.com'],
    ['name' => 'Global Fashion Distributors', 'email' => 'contact@globalfashion.com'],
    ['name' => 'Home Essentials Ltd.', 'email' => 'sales@homeessentials.com'],
    ['name' => 'Book World Publishers', 'email' => 'orders@bookworld.com'],
    ['name' => 'Sports Gear International', 'email' => 'info@sportsgear.com'],
    ['name' => 'Health & Beauty Co.', 'email' => 'supply@healthbeauty.com'],
    ['name' => 'Toy Masters Ltd.', 'email' => 'orders@toymasters.com'],
    ['name' => 'Auto Parts Express', 'email' => 'contact@autopartsexpress.com'],
]
```

### **ProductSupplierSeeder:**
```php

// Attaches 1-3 random suppliers to each product with realistic pivot data
// See file for details //

```

---

## 🔍 Testing Features

### **1. Supplier Management**
- Create product with multiple suppliers → ✅ All suppliers attached with pivot data
- Edit product to add/remove suppliers → ✅ Pivot data updated correctly
- Try duplicate product-supplier combination → ❌ Composite unique constraint prevents
- Delete product → ✅ Associated pivot records cascade deleted

### **2. Pivot Data Validation**
- Enter negative cost price → ❌ Validation prevents submission
- Enter non-integer lead time → ❌ Validation prevents submission
- Select supplier without entering pivot data → ❌ Required validation triggers
- Enter valid pivot data → ✅ Successfully saved

### **3. Performance Testing**
- List 100+ products → ✅ Eager loading prevents N+1 queries
- Display supplier count → ✅ Efficient query with `withCount()`
- Edit product with many suppliers → ✅ Efficient relationship loading

### **4. Database Integrity**
- Delete supplier with products → ✅ Cascade deletion from pivot table
- Try non-existent supplier ID → ❌ Foreign key constraint prevents
- Data consistency → ✅ All pivot data maintained across operations

---

## 🚀 Deployment Considerations

### **Performance Optimizations:**
```bash
# Cache configurations
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize autoloader
composer dump-autoload -o

```

### **Security Measures:**
- CSRF protection on all forms
- Mass assignment protection via `$fillable`
- Input validation for all user data
- SQL injection prevention via Eloquent
- XSS protection via Blade templating

---

## 🔗 Related Tasks

| Task | Description | Repository |
|------|-------------|------------|
| **Task 03 – Part 1** | Basic Database Operations | [![GitHub](https://img.shields.io/badge/GitHub-Task_03_Part_1-blue)](https://github.com/HasanSammour/IUG-Training-Task-03) |
| **Task 03 – Part 2** | Product CRUD Operations | [![GitHub](https://img.shields.io/badge/GitHub-Task_03_Part_2-blue)](https://github.com/HasanSammour/IUG-Training-Task-03_Part02) |
| **Task 04** | Form Validation & Database Integrity | [![GitHub](https://img.shields.io/badge/GitHub-Task_04-green)](https://github.com/HasanSammour/IUG-Training-Task-04) |
| **Task 05** | Category System & Enhanced UI | [![GitHub](https://img.shields.io/badge/GitHub-Task_05-orange)](https://github.com/HasanSammour/IUG-Training-Task-05) |
| **Task 06** | Many-to-Many Relationships (Current) | [![GitHub](https://img.shields.io/badge/GitHub-Task_06-purple)](https://github.com/HasanSammour/IUG-Training-Task-06) |

---

## 📄 License

**University Training Project** – Educational Use Only

---

## 👨‍💻 Author

**Hasan Younis Sammour**  
Back-end Development with Laravel  
🔗 GitHub: [https://github.com/HasanSammour](https://github.com/HasanSammour)  
📧 Email: hasansammour01@gmail.com  
🎓 University Training – Laravel Framework

---

## 🎯 Learning Outcomes

### **Technical Skills Developed:**
- ✅ Many-to-Many relationship implementation
- ✅ Pivot tables with additional data
- ✅ Form handling for complex relationships
- ✅ Database constraints and integrity
- ✅ Eager loading optimization
- ✅ Form request validation
- ✅ Controller synchronization methods

### **Best Practices Implemented:**
- ✅ N+1 query prevention
- ✅ Database normalization
- ✅ Composite unique constraints
- ✅ Cascade deletion strategies
- ✅ Form data persistence
- ✅ Client-server validation consistency

---

⭐ **If this project helped you understand Laravel many-to-many relationships and pivot tables, please give it a star!**

---

**Happy Coding with Laravel! 🚀**