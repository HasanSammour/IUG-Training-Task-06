@extends('layouts.app')

@section('title', 'Task 05 Solution')

@section('content')
<div class="row fade-in">
    <div class="col-12">
        <!-- Logo Header Section -->
        <div class="row align-items-center mb-5">
           <!-- University Logo -->
            <div class="col-md-4 slide-left">
                <div class="logo-container text-center">
                    <div class="logo-card p-3 rounded shadow-sm">
                        <div class="logo-image-container mb-3" style="height: 100px; display: flex; align-items: center; justify-content: center;">
                            <img src="{{ asset('images/university-logo.png') }}" 
                                 alt="University Logo" 
                                 class="img-fluid h-100" 
                                 style="object-fit: contain; width: auto; max-width: 100%;"
                                 onerror="this.onerror=null; this.src='https://via.placeholder.com/300x100/007bff/ffffff?text=IUG+Logo'">
                        </div>
                        <h5 class="fw-bold">Islamic University Of Gaza IUG</h5>
                        <p class="text-muted mb-2">Computer Engineering Department</p>
                        <small class="text-primary">
                            <i class="fas fa-map-marker-alt me-1"></i> Gaza, Palestine
                        </small>
                    </div>
                </div>
            </div>
            
            <!-- Center Title -->
            <div class="col-md-4 text-center fade-in">
                <h1 class="display-5 mb-2">
                    <i class="fas fa-sitemap text-primary"></i> Task 05
                </h1>
                <p class="lead text-muted">Eloquent Relationships & Category Association</p>
                <div class="badge bg-primary text-white p-2 mt-2">
                    <i class="fas fa-calendar-alt me-1"></i> December 2025 <i class="fas fa-calendar-alt me-1"></i>
                </div>
            </div>
            
            <!-- Training Company Logo -->
            <div class="col-md-4 slide-right">
                <div class="logo-container text-center">
                    <div class="logo-card p-3 rounded shadow-sm">
                        <div class="logo-image-container mb-3" style="height: 100px; display: flex; align-items: center; justify-content: center;">
                            <img src="{{ asset('images/Shefra-Logo.png') }}" 
                                 alt="Company Logo" 
                                 class="img-fluid h-100" 
                                 style="object-fit: contain; width: auto; max-width: 100%;"
                                 onerror="this.onerror=null; this.src='https://via.placeholder.com/300x100/28a745/ffffff?text=Shifra+Training'">
                        </div>
                        <h5 class="fw-bold">Shifra Training Center</h5>
                        <p class="text-muted mb-2">Back-End {Laravel} Workshop</p>
                        <small class="text-success">
                            <i class="fas fa-certificate me-1"></i> Professional Training
                        </small>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Header -->
        <div class="text-center mb-5 fade-in">
            <h2 class="display-6 mb-3">
                <i class="fas fa-project-diagram text-info"></i> 
                Eloquent Relationships & Database Modeling
                <i class="fas fa-project-diagram text-info"></i>
            </h2>
            <p class="text-muted">One-to-Many Relationships with Categories & Products</p>
        </div>
        
        <!-- Task Cards -->
        <div class="row mb-5">
            <!-- Part 1 Card -->
            <div class="col-md-3 mb-4">
                <div class="card h-100 slide-in">
                    <div class="card-header bg-primary text-white">
                        <h4 style="font-size: 1.2rem;"><i class="fas fa-database me-2"></i> Task 03: CRUD</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Product CRUD</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Basic Validation</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Views & Routing</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Part 2 Card -->
            <div class="col-md-3 mb-4">
                <div class="card h-100 slide-in">
                    <div class="card-header bg-success text-white">
                        <h4 style="font-size: 1.2rem;"><i class="fas fa-shield-alt me-2"></i> Task 04: Validation</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-info me-2"></i> Form Requests</li>
                            <li class="mb-2"><i class="fas fa-check text-info me-2"></i> Unique Constraints</li>
                            <li class="mb-2"><i class="fas fa-check text-info me-2"></i> Error Handling</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Task 05 NEW CARD -->
            <div class="col-md-3 mb-4">
                <div class="card h-100 slide-in pulse-animation">
                    <div class="card-header bg-info text-white">
                        <h4 style="font-size: 1.2rem;"><i class="fas fa-sitemap me-2"></i> Task 05: Relationships</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check-circle text-info me-2"></i> Category Model</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-info me-2"></i> One-to-Many</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-info me-2"></i> Foreign Keys</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-info me-2"></i> Eager Loading</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-info me-2"></i> Category Dropdown</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Features Card -->
            <div class="col-md-3 mb-4">
                <div class="card h-100 slide-in">
                    <div class="card-header bg-warning text-dark">
                        <h4 style="font-size: 1.2rem;"><i class="fas fa-bolt me-2"></i> Features</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-rocket text-warning me-2"></i> Eager Loading</li>
                            <li class="mb-2"><i class="fas fa-tachometer-alt text-warning me-2"></i> Performance</li>
                            <li class="mb-2"><i class="fas fa-code-branch text-warning me-2"></i> Relational DB</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Relationships Features Section -->
        <div class="card mb-5 fade-in">
            <div class="card-header bg-gradient-info text-white">
                <h4 class="mb-0">
                    <i class="fas fa-project-diagram me-2"></i>Eloquent Relationships Implemented
                </h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-info rounded-circle p-2 me-3">
                                <i class="fas fa-sitemap text-white"></i>
                            </div>
                            <div>
                                <h5>One-to-Many Relationship</h5>
                                <p class="text-muted mb-0">One Category has Many Products</p>
                                <small><code>Category::hasMany(Product::class)</code></small>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-success rounded-circle p-2 me-3">
                                <i class="fas fa-database text-white"></i>
                            </div>
                            <div>
                                <h5>Database Migration</h5>
                                <p class="text-muted mb-0">Foreign key constraint with cascade</p>
                                <small><code>$table->foreignId('category_id')->constrained()->onDelete('cascade')</code></small>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-warning rounded-circle p-2 me-3">
                                <i class="fas fa-tachometer-alt text-white"></i>
                            </div>
                            <div>
                                <h5>Eager Loading</h5>
                                <p class="text-muted mb-0">Prevents N+1 query problem</p>
                                <small><code>Product::with('category')->get()</code></small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-primary rounded-circle p-2 me-3">
                                <i class="fas fa-folder text-white"></i>
                            </div>
                            <div>
                                <h5>Category Model</h5>
                                <p class="text-muted mb-0">Complete CRUD for categories</p>
                                <small><code>php artisan make:model Category -m</code></small>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-danger rounded-circle p-2 me-3">
                                <i class="fas fa-list-alt text-white"></i>
                            </div>
                            <div>
                                <h5>Dynamic Dropdowns</h5>
                                <p class="text-muted mb-0">Category selection in all forms</p>
                                <small><code>&lt;select name="category_id"&gt;</code></small>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start">
                            <div class="bg-dark rounded-circle p-2 me-3">
                                <i class="fas fa-seedling text-white"></i>
                            </div>
                            <div>
                                <h5>Advanced Seeding</h5>
                                <p class="text-muted mb-0">Products assigned to categories</p>
                                <small><code>Product::factory()-&gt;count(5)-&gt;create()</code></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="text-center mb-5 fade-in">
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg float-animation me-3">
                <i class="fas fa-boxes me-2"></i> View Products with Categories
            </a>
            <a href="{{ route('products.create') }}" class="btn btn-info btn-lg rotate-on-hover">
                <i class="fas fa-plus-circle me-2"></i> Add Product with Category
            </a>
        </div>
    
        <!-- Category Statistics -->
        <div class="row mb-5">
            @php
                $categories = \App\Models\Category::withCount('products')->orderBy('products_count', 'desc')->get();
            @endphp
            
            @foreach($categories as $category)
            <div class="col-md-3 col-6 mb-3">
                <div class="category-stats slide-in" 
                     style="animation-delay: {{ $loop->index * 0.1 }}s;
                            background: @if($category->name == 'Electronics') linear-gradient(135deg, #e3f2fd, #bbdefb)
                            @elseif($category->name == 'Fashion') linear-gradient(135deg, #fce4ec, #f8bbd9)
                            @elseif($category->name == 'Home & Garden') linear-gradient(135deg, #e8f5e8, #c8e6c9)
                            @elseif($category->name == 'Books') linear-gradient(135deg, #fff8e1, #ffecb3)
                            @elseif($category->name == 'Sports') linear-gradient(135deg, #e8eaf6, #c5cae9)
                            @elseif($category->name == 'Health & Beauty') linear-gradient(135deg, #f3e5f5, #e1bee7)
                            @elseif($category->name == 'Toys') linear-gradient(135deg, #e0f2f1, #b2dfdb)
                            @elseif($category->name == 'Automotive') linear-gradient(135deg, #ffe5cc, #ffd8b1)
                            @else linear-gradient(135deg, #f5f5f5, #e0e0e0) @endif">
                    <div class="icon-container mb-3">
                        @if($category->name == 'Electronics') <i class="fas fa-laptop fa-2x text-primary"></i>
                        @elseif($category->name == 'Fashion') <i class="fas fa-tshirt fa-2x text-danger"></i>
                        @elseif($category->name == 'Home & Garden') <i class="fas fa-home fa-2x text-success"></i>
                        @elseif($category->name == 'Books') <i class="fas fa-book fa-2x text-warning"></i>
                        @elseif($category->name == 'Sports') <i class="fas fa-futbol fa-2x text-info"></i>
                        @elseif($category->name == 'Health & Beauty') <i class="fas fa-spa fa-2x text-purple"></i>
                        @elseif($category->name == 'Toys') <i class="fas fa-gamepad fa-2x text-teal"></i>
                        @elseif($category->name == 'Automotive') <i class="fas fa-car fa-2x text-orange"></i>
                        @else <i class="fas fa-tag fa-2x text-secondary"></i>
                        @endif
                    </div>
                    <h5 class="fw-bold">{{ $category->name }}</h5>
                    <h2 class="mb-0">{{ $category->products_count }}</h2>
                    @if($category->products_count == 1)
                        <small>Product</small>
                    @else
                        <small>Products</small>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Database Relationship Diagram -->
        <div class="card fade-in mb-4">
            <div class="card-header bg-dark text-white">
                <h5><i class="fas fa-diagram-project me-2"></i> Database Relationship Diagram</h5>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <div class="mb-4">
                        <div class="d-inline-block p-3 rounded bg-primary text-white mb-2">
                            <i class="fas fa-folder fa-2x"></i>
                            <div>categories</div>
                        </div>
                        <div class="d-inline-block mx-4">
                            <i class="fas fa-arrow-right fa-2x text-muted"></i>
                        </div>
                        <div class="d-inline-block p-3 rounded bg-success text-white">
                            <i class="fas fa-box fa-2x"></i>
                            <div>products</div>
                        </div>
                    </div>
                    
                    <div class="bg-light p-4 rounded mb-3">
                        <h6>One-to-Many Relationship</h6>
                        <p class="mb-0">
                            <code>Category::hasMany(Product::class)</code> ←→ 
                            <code>Product::belongsTo(Category::class)</code>
                        </p>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Category Table</h6>
                            <div class="bg-light p-3 rounded">
                                <code>id (PK)</code><br>
                                <code>name (UNIQUE)</code><br>
                                <code>timestamps</code>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6>Product Table</h6>
                            <div class="bg-light p-3 rounded">
                                <code>id (PK)</code><br>
                                <code>name (UNIQUE)</code><br>
                                <code>price (DECIMAL)</code><br>
                                <code>description (TEXT, nullable)</code><br>
                                <code>category_id (FK)</code><br>
                                <code>timestamps</code>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Commands Used -->
        <div class="card fade-in">
            <div class="card-header bg-gradient-warning text-dark">
                <h5><i class="fas fa-terminal me-2"></i> Task 05 Commands Used</h5>
            </div>
            <div class="card-body">
                <div class="bg-light p-3 rounded mb-3">
                    <code>$ php artisan make:model Category -m</code><br>
                    <code>$ php artisan make:seeder CategorySeeder</code><br>
                    <code>$ php artisan make:migration add_category_id_to_products_table  <strong>// This is optional</strong> </code><br>
                    <code>$ php artisan migrate:fresh --seed</code><br><br>
                    
                    <code>// Test relationships in Tinker</code><br>
                    <code>>> $category = Category::first()</code><br>
                    <code>>> $category->products</code><br>
                    <code>>> $product = Product::first()</code><br>
                    <code>>> $product->category</code><br>
                    <code>>> Product::with('category')->get()  <strong>// Eager Loading</strong></code>
                </div>
                <small class="text-muted">
                    <i class="fas fa-lightbulb me-1"></i>
                    Eager loading prevents the N+1 query problem and significantly improves performance!
                </small>
            </div>
        </div>
        
        <!-- Category Examples -->
        <div class="card fade-in mt-4">
            <div class="card-header bg-gradient-success text-white">
                <h5><i class="fas fa-list me-2"></i> Sample Categories & Products</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @php
                        $sampleData = [
                            ['Electronics', 'Laptop Pro', '$1299.99', 'laptop'],
                            ['Fashion', 'Designer Jeans', '$89.99', 'tshirt'],
                            ['Home & Garden', 'Modern Sofa', '$899.99', 'couch'],
                            ['Books', 'Programming Guide', '$39.99', 'book'],
                            ['Sports', 'Football', '$34.99', 'futbol'],
                            ['Health & Beauty', 'Vitamin Serum', '$24.99', 'spa'],
                            ['Toys', 'LEGO Set', '$149.99', 'gamepad'],
                            ['Automotive', 'Car GPS', '$129.99', 'car']
                        ];
                    @endphp
                    
                    @foreach($sampleData as $data)
                    <div class="col-md-3 mb-3">
                        <div class="p-3 rounded border">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge 
                                    @if($data[0] == 'Electronics') bg-primary
                                    @elseif($data[0] == 'Fashion') bg-danger
                                    @elseif($data[0] == 'Home & Garden') bg-success
                                    @elseif($data[0] == 'Books') bg-warning text-dark
                                    @elseif($data[0] == 'Sports') bg-info
                                    @elseif($data[0] == 'Health & Beauty') bg-purple
                                    @elseif($data[0] == 'Toys') bg-teal
                                    @elseif($data[0] == 'Automotive') bg-orange
                                    @else bg-secondary @endif
                                    me-2">
                                    <i class="fas fa-{{ $data[3] }}"></i>
                                </span>
                                <strong>{{ $data[0] }}</strong>
                            </div>
                            <div class="mb-1">
                                <i class="fas fa-box text-muted me-1"></i>
                                {{ $data[1] }}
                            </div>
                            <div class="text-success fw-bold">
                                <i class="fas fa-dollar-sign"></i> {{ $data[2] }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Update category dropdown with live data
    document.addEventListener('DOMContentLoaded', function() {        
        // Add animation to category stats
        const stats = document.querySelectorAll('.category-stats');
        stats.forEach((stat, index) => {
            stat.style.animationDelay = `${index * 0.1}s`;
        });
    });
    
    // Fix dropdown z-index issue on home page
    document.addEventListener('DOMContentLoaded', function() {
        // Only on home page
        if (window.location.pathname === '/') {
            console.log('Fixing dropdown z-index on home page...');
            
            // 1. Push logos to back
            const logoCards = document.querySelectorAll('.logo-card');
            logoCards.forEach(card => {
                card.style.zIndex = '5';
                card.style.position = 'relative';
            });
            
            // 2. Bring dropdown to front
            const dropdownMenu = document.querySelector('.dropdown-menu');
            if (dropdownMenu) {
                dropdownMenu.style.zIndex = '9999';
                dropdownMenu.style.position = 'absolute';
                dropdownMenu.style.boxShadow = '0 10px 30px rgba(0,0,0,0.3)';
            }
            
            // 3. Ensure navbar is properly positioned
            const navbar = document.querySelector('.navbar');
            if (navbar) {
                navbar.style.zIndex = '1000';
                navbar.style.position = 'relative';
            }
            
            // 4. Lower z-index for the logo row
            const logoRow = document.querySelector('.row.align-items-center.mb-5');
            if (logoRow) {
                logoRow.style.zIndex = '5';
                logoRow.style.position = 'relative';
            }
        }
    });
</script>
@endpush
@endsection