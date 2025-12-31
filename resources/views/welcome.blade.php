@extends('layouts.app')

@section('title', 'Task 06 Solution')

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
                    <i class="fas fa-exchange-alt text-warning"></i> Task 06
                </h1>
                <p class="lead text-muted">Many-to-Many Relationships & Suppliers System</p>
                <div class="badge bg-warning text-dark p-2 mt-2">
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
                <i class="fas fa-truck text-warning"></i> 
                Many-to-Many Relationships with Suppliers
                <i class="fas fa-exchange-alt text-warning"></i>
            </h2>
            <p class="text-muted">Products ↔ Suppliers with Pivot Data (cost_price, lead_time_days)</p>
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

            <!-- Task 05 Card -->
            <div class="col-md-3 mb-4">
                <div class="card h-100 slide-in">
                    <div class="card-header bg-info text-white">
                        <h4 style="font-size: 1.2rem;"><i class="fas fa-sitemap me-2"></i> Task 05: 1-Many</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check-circle text-info me-2"></i> Category Model</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-info me-2"></i> One-to-Many</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-info me-2"></i> Foreign Keys</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Task 06 NEW CARD -->
            <div class="col-md-3 mb-4">
                <div class="card h-100 slide-in pulse-animation">
                    <div class="card-header bg-warning text-dark">
                        <h4 style="font-size: 1.2rem;"><i class="fas fa-exchange-alt me-2"></i> Task 06: M-M</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check-circle text-warning me-2"></i> Supplier Model</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-warning me-2"></i> Many-to-Many</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-warning me-2"></i> Pivot Data</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-warning me-2"></i> Supplier Forms</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-warning me-2"></i> Sync Relationships</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Many-to-Many Features Section -->
        <div class="card mb-5 fade-in">
            <div class="card-header bg-gradient-warning text-dark">
                <h4 class="mb-0">
                    <i class="fas fa-exchange-alt me-2"></i>Many-to-Many Relationships Implemented
                </h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-warning rounded-circle p-2 me-3">
                                <i class="fas fa-truck text-white"></i>
                            </div>
                            <div>
                                <h5>Supplier Model</h5>
                                <p class="text-muted mb-0">Suppliers with name and email</p>
                                <small><code>php artisan make:model Supplier -m</code></small>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-success rounded-circle p-2 me-3">
                                <i class="fas fa-table text-white"></i>
                            </div>
                            <div>
                                <h5>Pivot Table</h5>
                                <p class="text-muted mb-0">product_supplier with extra data</p>
                                <small><code>cost_price, lead_time_days, timestamps</code></small>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-info rounded-circle p-2 me-3">
                                <i class="fas fa-link text-white"></i>
                            </div>
                            <div>
                                <h5>Eloquent Relationships</h5>
                                <p class="text-muted mb-0">belongsToMany with pivot data</p>
                                <small><code>-&gt;withPivot(['cost_price', 'lead_time_days'])</code></small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-primary rounded-circle p-2 me-3">
                                <i class="fas fa-exchange-alt text-white"></i>
                            </div>
                            <div>
                                <h5>Many-to-Many</h5>
                                <p class="text-muted mb-0">Product ↔ Supplier bidirectional</p>
                                <small><code>Product::belongsToMany(Supplier::class)</code></small>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-danger rounded-circle p-2 me-3">
                                <i class="fas fa-sync-alt text-white"></i>
                            </div>
                            <div>
                                <h5>Sync Method</h5>
                                <p class="text-muted mb-0">Automatic relationship management</p>
                                <small><code>$product-&gt;suppliers()-&gt;sync($data)</code></small>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start">
                            <div class="bg-purple rounded-circle p-2 me-3">
                                <i class="fas fa-calculator text-white"></i>
                            </div>
                            <div>
                                <h5>Profit Calculations</h5>
                                <p class="text-muted mb-0">Dynamic margin calculations</p>
                                <small><code>Profit = Price - Cost Price</code></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Database Relationship Diagram -->
        <div class="card mb-5 fade-in">
            <div class="card-header bg-dark text-white">
                <h5><i class="fas fa-diagram-project me-2"></i> Database Relationship Diagram</h5>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <div class="mb-4">
                        <!-- Category -->
                        <div class="d-inline-block p-3 rounded bg-primary text-white mb-2">
                            <i class="fas fa-folder fa-2x"></i>
                            <div>categories</div>
                        </div>
                        <div class="d-inline-block mx-2">
                            <i class="fas fa-arrow-right fa-2x text-muted"></i>
                        </div>
                        
                        <!-- Product -->
                        <div class="d-inline-block p-3 rounded bg-success text-white">
                            <i class="fas fa-box fa-2x"></i>
                            <div>products</div>
                        </div>
                        
                        <!-- Many-to-Many Connection -->
                        <div class="d-inline-block mx-3">
                            <i class="fas fa-exchange-alt fa-2x text-warning"></i>
                        </div>
                        
                        <!-- Supplier -->
                        <div class="d-inline-block p-3 rounded bg-warning text-dark">
                            <i class="fas fa-truck fa-2x"></i>
                            <div>suppliers</div>
                        </div>
                    </div>
                    
                    <div class="bg-light p-4 rounded mb-3">
                        <h6>Relationships</h6>
                        <p class="mb-0">
                            <code>Category::hasMany(Product::class)</code> ←→ 
                            <code>Product::belongsTo(Category::class)</code><br>
                            <code>Product::belongsToMany(Supplier::class)</code> ↔ 
                            <code>Supplier::belongsToMany(Product::class)</code>
                        </p>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <h6>Category Table</h6>
                            <div class="bg-light p-3 rounded">
                                <code>id (PK)</code><br>
                                <code>name (UNIQUE)</code><br>
                                <code>timestamps</code>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h6>Product Table</h6>
                            <div class="bg-light p-3 rounded">
                                <code>id (PK)</code><br>
                                <code>name (UNIQUE)</code><br>
                                <code>price (DECIMAL)</code><br>
                                <code>Description (NULLABLE)</code><br>
                                <code>category_id (FK)</code><br>
                                <code>timestamps</code>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h6>Supplier Table</h6>
                            <div class="bg-light p-3 rounded">
                                <code>id (PK)</code><br>
                                <code>name (UNIQUE)</code><br>
                                <code>email (UNIQUE)</code><br>
                                <code>timestamps</code>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Pivot Table -->
                    <div class="mt-4">
                        <h6>Pivot Table: product_supplier</h6>
                        <div class="bg-light p-3 rounded">
                            <code>id (PK)</code><br>
                            <code>product_id (FK) → products.id</code><br>
                            <code>supplier_id (FK) → suppliers.id</code><br>
                            <code>cost_price (DECIMAL)</code><br>
                            <code>lead_time_days (INTEGER)</code><br>
                            <code>timestamps</code><br>
                            <code>UNIQUE(product_id, supplier_id)</code>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Supplier Examples -->
        <div class="card fade-in mt-4">
            <div class="card-header bg-gradient-warning text-dark">
                <h5><i class="fas fa-truck me-2"></i> Sample Suppliers & Relationships <strong>{This is only fake sample}</strong></h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @php
                        $sampleSuppliers = [
                            ['Tech Suppliers Inc.', 'orders@techsuppliers.com', 'Laptops, Phones', '3-7 days'],
                            ['Global Fashion Distributors', 'contact@globalfashion.com', 'Clothing, Shoes', '5-14 days'],
                            ['Home Essentials Ltd.', 'sales@homeessentials.com', 'Furniture, Decor', '7-21 days'],
                            ['Book World Publishers', 'orders@bookworld.com', 'Books, Magazines', '2-5 days'],
                            ['Sports Gear International', 'info@sportsgear.com', 'Equipment, Apparel', '3-10 days'],
                            ['Health & Beauty Co.', 'supply@healthbeauty.com', 'Cosmetics, Vitamins', '1-3 days'],
                            ['Toy Masters Ltd.', 'orders@toymasters.com', 'Toys, Games', '4-10 days'],
                            ['Auto Parts Express', 'contact@autopartsexpress.com', 'Parts, Accessories', '2-7 days']
                        ];
                    @endphp
                    
                    @foreach($sampleSuppliers as $supplier)
                    <div class="col-md-3 mb-3">
                        <div class="p-3 rounded border">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge bg-warning text-dark me-2">
                                    <i class="fas fa-truck"></i>
                                </span>
                                <strong>{{ $supplier[0] }}</strong>
                            </div>
                            <div class="mb-1 small">
                                <i class="fas fa-envelope text-muted me-1"></i>
                                {{ $supplier[1] }}
                            </div>
                            <div class="mb-1 small">
                                <i class="fas fa-box text-muted me-1"></i>
                                {{ $supplier[2] }}
                            </div>
                            <div class="text-info small">
                                <i class="fas fa-clock me-1"></i>
                                Lead: {{ $supplier[3] }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <br>
        <br>

        <!-- Action Buttons -->
        <div class="text-center mb-5 fade-in">
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg float-animation me-3">
                <i class="fas fa-boxes me-2"></i> View Products with Suppliers
            </a>
            <a href="{{ route('products.create') }}" class="btn btn-warning btn-lg rotate-on-hover">
                <i class="fas fa-plus-circle me-2"></i> Add Product with Suppliers
            </a>
        </div>

        <!-- Commands Used -->
        <div class="card fade-in">
            <div class="card-header bg-gradient-info text-white">
                <h5><i class="fas fa-terminal me-2"></i> Task 06 Commands Used</h5>
            </div>
            <div class="card-body">
                <div class="bg-light p-3 rounded mb-3">
                    <code>$ php artisan make:model Supplier -m</code><br>
                    <code>$ php artisan make:migration create_product_supplier_table</code><br>
                    <code>$ php artisan make:seeder SupplierSeeder</code><br>
                    <code>$ php artisan make:seeder ProductSupplierSeeder</code><br>
                    <code>$ php artisan migrate:fresh --seed</code><br><br>
                    
                    <code>// Test relationships in Tinker</code><br>
                    <code>>> $product = Product::first()</code><br>
                    <code>>> $product->suppliers</code><br>
                    <code>>> $supplier = Supplier::first()</code><br>
                    <code>>> $supplier->products</code><br>
                    <code>>> $product->suppliers()->attach($supplier, ['cost_price' => 100, 'lead_time_days' => 5])</code><br>
                    <code>>> $product->suppliers()->sync([1 => ['cost_price' => 100], 2 => ['cost_price' => 120]])</code>
                </div>
                <small class="text-muted">
                    <i class="fas fa-lightbulb me-1"></i>
                    Many-to-Many relationships allow products to have multiple suppliers with individual pricing!
                </small>
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