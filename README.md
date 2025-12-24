<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Task Solution 
# 🛒 Task 05 – Enhanced Product Management System with Categories & UI Improvements

## 📋 Project Overview
This task significantly enhances the **Product Management System** by implementing a *complete category system* with proper database relationships, improved UI/UX, and advanced features. The system now includes a fully functional category-product relationship, dynamic views, and enhanced user experience while maintaining all *validation and CRUD functionality* from **Task 04 and Task 03**.

---

## ✨ Major Enhancements & New Features

### 🗄️ **Database & Backend Improvements**
- ✅ **Complete Category System** – New `categories` table with proper migrations
- ✅ **Foreign Key Relationships** – `category_id` in products table with `onDelete('set null')` strategy
- ✅ **Eloquent Relationships** – One-to-Many relationship between Category and Product
- ✅ **Global View Sharing** – All categories available site-wide via `AppServiceProvider`
- ✅ **Enhanced Controllers** – Eager loading, pagination, and category statistics

### 🎨 **UI/UX Enhancements**
- ✅ **Dynamic Category Dropdowns** – Populated in create/edit forms
- ✅ **Category Products Page** – Dedicated view showing all products in a category
- ✅ **Pagination System** – Implemented across all listings
- ✅ **Enhanced Product Display** – Better organization with category information
- ✅ **Local Bootstrap Assets** – Self-hosted Bootstrap for better control

### 📊 **New Views & Pages**
- ✅ **Category Products View** (`categories/products.blade.php`) – New dedicated page
- ✅ **Enhanced Product Views** – All product views updated with category integration
- ✅ **Better Layout Structure** – Organized Blade templates with consistent design

### 🔧 **Technical Improvements**
- ✅ **Database Seeding** – 8 default categories + test empty category *This one created using tinker*
- ✅ **Factory Updates** – Products now associated with random categories and more
- ✅ **Custom JavaScript** – Delete confirmation modals with proper UX
- ✅ **Custom CSS** – Local styling for better performance

---

## 🛠️ Technologies Used

- **Laravel 12** – PHP framework with Eloquent ORM
- **MySQL** – Relational database with foreign keys
- **Bootstrap 5** (Local) – Frontend framework hosted locally
- **JavaScript (Vanilla)** – Custom interactive features
- **HTML5 & CSS3** – Modern markup and styling
- **FontAwesome** – Icon library for better visuals

---

## 🗂️ Project Structure :: *what i made changes on in this Task*

```
app/
├── Http/
│   ├── Controllers/
│   │   └── ProductController.php        # Enhanced with category features
│   ├── Requests/
│   │   ├── StoreProductRequest.php      # Enhanced with Category Validation Rules
│   │   └── UpdateProductRequest.php     # Enhanced with Category Validation Rules
│   └── Providers/
│       └── AppServiceProvider.php       # Global category sharing
├── Models/
│   ├── Product.php                      # Added category relationship
│   └── Category.php                     # New model with product relationship
database/
├── migrations/
│   ├── 2024_xx_xx_xxxxxx_create_categories_table.php
│   └── 2024_xx_xx_xxxxxx_create_products_table.php      # Updated with foreign key
├── seeders/
│   ├── DatabaseSeeder.php               # Updated to seed categories first
│   ├── ProductSeeder.php               # Updated to seed With Random Categories and more
│   └── CategorySeeder.php               # New: Seeds 8 default categories
└── factories/
    └── ProductFactory.php               # Updated to use categories

resources/views/
├── categories/
│   └── products.blade.php               # NEW: Category products listing
└── products/
    ├── index.blade.php                  # Enhanced with pagination & categories
    ├── create.blade.php                 # Enhanced with category dropdown And show available categories Table
    ├── edit.blade.php                   # Enhanced with category selection
    └── show.blade.php                   # Enhanced with category info

public/
├── bootstrap/                           # Local Bootstrap assets
├── css/                                 # Custom CSS files
└── js/                                  # Custom JavaScript files
```

---

## 🔗 Database Schema & Relationships

### **Categories Table**
```sql
CREATE TABLE categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) UNIQUE NOT NULL,  -- Unique category names
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### **Products Table (Updated)**
```sql
CREATE TABLE products (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) UNIQUE NOT NULL,  -- From Task 04
    price DECIMAL(10,2) NOT NULL CHECK (price > 0),  -- From Task 04
    description TEXT NULL,
    category_id BIGINT UNSIGNED NULL,  -- NEW: Foreign key to categories
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);
```

### **Eloquent Relationships**

**Category Model:**
```php
class Category extends Model
{
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
```

**Product Model:**
```php
class Product extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
```

---

## 🎯 Key Implementation Details

### 1. **Global Category Sharing (AppServiceProvider)**
```php
public function boot(): void
{
    // Share categories with all views
    view()->composer('*', function ($view) {
        $allCategories = Category::withCount('products')
            ->orderBy('name')
            ->get();
        
        $view->with('allCategories', $allCategories);
    });
}
```
**Why this matters:** Ensures categories are available in every view, including dropdowns in create/edit forms, even when using pagination in controllers *{I add this because i create table shows categories in Create Product View}*.

### 2. **Enhanced ProductController Methods**
1. Create Method with Pagination 
2. Category Products View


### 3. **Database Migration Strategy**
1. **Categories Migration** created first (earlier timestamp)
2. **Products Migration** updated with foreign key constraint
3. **Proper `onDelete('set null')`** strategy maintains data integrity

### 4. **Seeding Strategy**
1. **CategorySeeder** creates 8 default categories:
   - Electronics, Fashion, Home & Garden, Books, Sports, Health & Beauty, Toys, Automotive
2. **ProductSeeder** uses factories to create products with random categories
3. **Test Empty Category** created via Tinker for demonstration

---

## 🚀 Installation & Setup

```bash
# 1. Clone and navigate to project
git clone https://github.com/HasanSammour/IUG-Training-Task-05.git
cd IUG-Training-Task-05

# 2. Install dependencies
composer install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Configure database (update .env)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task05
DB_USERNAME=root
DB_PASSWORD=

# 5. Run migrations (in correct order)
php artisan migrate

# 6. Seed the database
php artisan db:seed

# 7. (Optional) Create test empty category via Tinker
php artisan tinker
>>> Category::create(['name' => 'Test Empty Category']);

# 8. Start development server
php artisan serve
```

---

## 🌐 Application Routes

### **Product Routes (From Task 04, Enhanced)**
```php
Route::resource('products', ProductController::class);
```

### **New Category Routes (Task 05)**
```php
// Show all products in a specific category
Route::get('/categories/{category}/products', 
            [ProductController::class, 'showCategoryProducts'])
      ->name('categories.products.show');
```

### **Complete Route List**
| Method | URI | Action | Description |
|--------|-----|--------|-------------|
| GET | `/products` | `index()` | List all products with pagination |
| GET | `/products/create` | `create()` | Show create form with category dropdown |
| POST | `/products` | `store()` | Store new product with validation |
| GET | `/products/{product}` | `show()` | Show single product with category |
| GET | `/products/{product}/edit` | `edit()` | Edit form with category selection |
| PUT/PATCH | `/products/{product}` | `update()` | Update product with validation |
| DELETE | `/products/{product}` | `destroy()` | Delete product with confirmation |
| GET | `/categories/{category}/products` | `showCategoryProducts()` | **NEW**: Show category products |

---

## 🎨 Frontend Features

### **1. Local Asset Management**
- Bootstrap CSS/JS hosted locally in `public/bootstrap/`
- Custom CSS in `public/bootstrap/css/`
- Custom JavaScript in `public/bootstrap/js/`
- FontAwesome hosted locally in `public/font-awesome/` for icons
- images used are hosted in `public/images/`

### **2. Interactive Components**
- **Delete Confirmation Modals** – Custom JavaScript for safe deletions
- **Pagination Components** – Bootstrap-styled pagination links
- **Dynamic Dropdowns** – Category selection in forms

### **3. Layout Improvements**
- **Consistent Header/Footer** – Using `layouts/app.blade.php`
- **Breadcrumb Navigation** – Shows user location
- **Alert Messages** – Success/error notifications
- **Loading States** – Better user feedback

---

## 🔍 Testing Features

### **1. Category Functionality**
- Visit `/categories/{id}/products` → ✅ See all products in that category
- Create product without category → ✅ Works (nullable foreign key)
- Delete category with products → ✅ Products remain (category_id set to null)
- Try duplicate category name {Using tinker} → ❌ Database unique constraint prevents

### **2. Product Management**
- Create product with category → ✅ Successfully associated
- Edit product category → ✅ Can change category association
- View product details → ✅ Shows category information
- List all products → ✅ Shows category in table

### **3. Pagination Testing**
- Add more than 10 products → ✅ Pagination appears
- Navigate between pages → ✅ URL updates correctly
- Combined with category filter → ✅ Works seamlessly

### **4. Database Integrity**
- Delete category → ✅ Products remain (category_id = null)
- Try invalid category_id → ❌ Foreign key constraint prevents
- Duplicate product names → ❌ Unique constraint prevents (from Task 04)

---

## 🔧 Custom Code Highlights

### **Migration Foreign Key**
```php
// database/migrations/xxxx_create_products_table.php
$table->foreignId('category_id')
      ->nullable()
      ->constrained('categories')
      ->onDelete('set null');
```

### **Controller Eager Loading**
```php
// Efficient data loading
$products = Product::with('category')->latest()->paginate(10);
```

---

## 📊 Database Seeding Details

### **Default Categories Created:**
1. Electronics (🖥️)
2. Fashion (👕)
3. Home & Garden (🏠)
4. Books (📚)
5. Sports (⚽)
6. Health & Beauty (💆)
7. Toys (🎮)
8. Automotive (🚗)

### **Product Factory:**
```php
public function definition()
{
  $categoryName = $this->faker->randomElement(array_keys($this->productCategories));
  $category = Category::where('name', $categoryName)->first();
        
  return [
    'name' => $this->faker->unique()->words(rand(2, 4), true),
    'price' => $this->faker->randomFloat(2, 5, 2000),
    'description' => $this->faker->paragraph(rand(1, 3)),
    'category_id' => $category ? $category->id : null
  ];
}
```

---

## 🚀 Deployment Considerations

### **Production Optimizations:**
```bash
# Cache configurations
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize autoloader
composer dump-autoload -o
```

### **Security Measures:**
- CSRF protection enabled on all forms
- SQL injection prevention via Eloquent
- XSS protection via Blade templating
- Input validation via Form Requests (from Task 04)

### **Performance Tips:**
- Eager loading prevents N+1 queries
- Database indexes on foreign keys
- Pagination for large datasets
- Local assets for faster loading

---

## 🔗 Related Tasks

| Task | Description | Repository |
|------|-------------|------------|
| **Task 03 – Part 1** |  Basic Database Operations: Model, Migration, and Seeder | [![GitHub](https://img.shields.io/badge/GitHub-Task_03_Part_1-blue)](https://github.com/HasanSammour/IUG-Training-Task-03) |
| **Task 03 – Part 2** | Product CRUD Operations in Laravel | [![GitHub](https://img.shields.io/badge/GitHub-Task_03_Part_2-blue)](https://github.com/HasanSammour/IUG-Training-Task-03_Part02) |
| **Task 04** | Form Validation & Database Integrity | [![GitHub](https://img.shields.io/badge/GitHub-Task_04-green)](https://github.com/HasanSammour/IUG-Training-Task-04) |
| **Task 05** | Category System & Enhanced UI (Current) | [![GitHub](https://img.shields.io/badge/GitHub-Task_05-orange)](https://github.com/HasanSammour/IUG-Training-Task-05) |

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

⭐ **If this project helped you understand Laravel relationships and MVC architecture, please give it a star!**

---

**Happy Coding with Laravel! 🚀**