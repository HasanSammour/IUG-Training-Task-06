@extends('layouts.app')

@section('title', $product->name)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('products.index') }}"><i class="fas fa-boxes"></i> Products</a></li>
    <li class="breadcrumb-item active"><i class="fas fa-eye"></i> View Product</li>
@endsection

@section('content')
@php
    // Get suppliers count safely
    $suppliers = $product->suppliers ?? collect();
    $suppliersCount = $suppliers->count();
    
    // Calculate statistics
    if($suppliersCount > 0) {
        $costPrices = $suppliers->map(function($supplier) {
            $pivotData = $supplier->getOriginal();
            return $pivotData['pivot_cost_price'] ?? ($supplier->pivot->cost_price ?? 0);
        });
        
        $leadTimes = $suppliers->map(function($supplier) {
            $pivotData = $supplier->getOriginal();
            return $pivotData['pivot_lead_time_days'] ?? ($supplier->pivot->lead_time_days ?? 0);
        });
        
        // Calculate min cost suppliers
        $minCostSuppliers = $suppliers->filter(function($supplier) use ($costPrices) {
            $pivotData = $supplier->getOriginal();
            $cost = $pivotData['pivot_cost_price'] ?? ($supplier->pivot->cost_price ?? 0);
            return $cost == $costPrices->min();
        });
        
        // Calculate max cost suppliers
        $maxCostSuppliers = $suppliers->filter(function($supplier) use ($costPrices) {
            $pivotData = $supplier->getOriginal();
            $cost = $pivotData['pivot_cost_price'] ?? ($supplier->pivot->cost_price ?? 0);
            return $cost == $costPrices->max();
        });
        
        // Calculate best efficiency
        $bestEfficiency = 0;
        $bestSuppliers = collect();
        foreach($suppliers as $supplier) {
            $pivotData = $supplier->getOriginal();
            $cost = $pivotData['pivot_cost_price'] ?? ($supplier->pivot->cost_price ?? 0);
            $lead = $pivotData['pivot_lead_time_days'] ?? ($supplier->pivot->lead_time_days ?? 0);
            $maxCost = $costPrices->max() ?: 1;
            $maxLead = $leadTimes->max() ?: 1;
            $efficiency = 100 - (($cost/$maxCost * 50) + ($lead/$maxLead * 50));
            if ($efficiency > $bestEfficiency) {
                $bestEfficiency = $efficiency;
                $bestSuppliers = collect([$supplier]);
            } elseif ($efficiency == $bestEfficiency && $bestEfficiency > 0) {
                $bestSuppliers->push($supplier);
            }
        }
    }
@endphp

<div class="row fade-in">
    <div class="col-lg-8">
        <!-- Main Product Details Card -->
        <div class="card shadow-lg mb-4 slide-in">
            <div class="card-header d-flex justify-content-between align-items-center 
                @if($product->category && $product->category->name == 'Electronics') bg-primary
                @elseif($product->category && $product->category->name == 'Fashion') bg-danger
                @elseif($product->category && $product->category->name == 'Home & Garden') bg-success
                @elseif($product->category && $product->category->name == 'Books') bg-warning text-dark
                @elseif($product->category && $product->category->name == 'Sports') bg-info
                @elseif($product->category && $product->category->name == 'Health & Beauty') bg-purple
                @elseif($product->category && $product->category->name == 'Toys') bg-teal
                @elseif($product->category && $product->category->name == 'Automotive') bg-orange
                @elseif($product->category && $product->category->name == 'Test Empty Category') bg-secondary
                @else bg-info @endif text-white">
                <div class="d-flex align-items-center">
                    @if($product->category)
                        @switch($product->category->name)
                            @case('Electronics')<i class="fas fa-laptop fa-2x me-3"></i>@break
                            @case('Fashion')<i class="fas fa-tshirt fa-2x me-3"></i>@break
                            @case('Home & Garden')<i class="fas fa-home fa-2x me-3"></i>@break
                            @case('Books')<i class="fas fa-book fa-2x me-3"></i>@break
                            @case('Sports')<i class="fas fa-futbol fa-2x me-3"></i>@break
                            @case('Health & Beauty')<i class="fas fa-spa fa-2x me-3"></i>@break
                            @case('Toys')<i class="fas fa-gamepad fa-2x me-3"></i>@break
                            @case('Automotive')<i class="fas fa-car fa-2x me-3"></i>@break
                            @case('Test Empty Category')<i class="fas fa-question fa-2x me-3"></i>@break
                            @default<i class="fas fa-box fa-2x me-3"></i>
                        @endswitch
                    @else
                        <i class="fas fa-box fa-2x me-3"></i>
                    @endif
                    <div>
                        <h4 class="mb-0">Product Details</h4>
                        <small>
                            <i class="fas fa-project-diagram me-1"></i>
                            Task 06: Many-to-Many Relationships
                        </small>
                    </div>
                </div>
                <div class="text-end">
                    <span class="badge bg-light text-dark fs-5 px-3 py-2">
                        ${{ number_format($product->price, 2) }}
                    </span>
                    <span class="badge bg-warning ms-2 fs-5 px-3 py-2">
                        <i class="fas fa-truck me-1"></i>{{ $suppliersCount }} suppliers
                    </span>
                </div>
            </div>
            
            <div class="card-body">
                <!-- Product Name -->
                <div class="text-center mb-4">
                    <h1 class="display-5 mb-2">{{ $product->name }}</h1>
                    <div class="d-flex justify-content-center align-items-center gap-3">
                        <span class="badge bg-dark fs-6">
                            <i class="fas fa-hashtag me-1"></i>ID: {{ $product->id }}
                        </span>
                        @if($product->category)
                            <span class="badge 
                                @if($product->category->name == 'Electronics') bg-primary
                                @elseif($product->category->name == 'Fashion') bg-danger
                                @elseif($product->category->name == 'Home & Garden') bg-success
                                @elseif($product->category->name == 'Books') bg-warning text-dark
                                @elseif($product->category->name == 'Sports') bg-info
                                @elseif($product->category->name == 'Health & Beauty') bg-purple
                                @elseif($product->category->name == 'Toys') bg-teal
                                @elseif($product->category->name == 'Automotive') bg-orange
                                @elseif($product->category->name == 'Test Empty Category') bg-secondary
                                @else bg-secondary @endif fs-6">
                                <i class="fas fa-tag me-1"></i>{{ $product->category->name }}
                            </span>
                        @else
                            <span class="badge bg-secondary fs-6">
                                <i class="fas fa-tag me-1"></i>No Category
                            </span>
                        @endif
                    </div>
                </div>
                
                <!-- Description Section -->
                <div class="mb-5">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-light rounded-circle p-2 me-3">
                            <i class="fas fa-align-left fa-lg text-warning"></i>
                        </div>
                        <h4 class="mb-0">Product Description</h4>
                    </div>
                    
                    @if($product->description)
                        <div class="card bg-light border-0">
                            <div class="card-body">
                                <p class="lead mb-0">{{ $product->description }}</p>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-light border">
                            <div class="text-center py-3">
                                <i class="fas fa-comment-slash fa-2x text-muted mb-3"></i>
                                <h5 class="text-muted">No Description Available</h5>
                                <p class="text-muted mb-0">This product doesn't have a description yet.</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- ========== SUPPLIERS SECTION ========== -->
                <div class="mb-5">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-warning rounded-circle p-2 me-3">
                            <i class="fas fa-truck text-white"></i>
                        </div>
                        <div>
                            <h4 class="mb-0">
                                <i class="fas fa-truck me-2 text-warning"></i>Product Suppliers
                            </h4>
                            <small class="text-muted">Suppliers providing this product with cost and lead time details</small>
                        </div>
                    </div>

                    @if($suppliersCount > 0)
                        <div class="row g-3">
                            @foreach($suppliers as $supplier)
                            @php
                                // Access pivot data safely
                                $pivotData = $supplier->getOriginal();
                                $costPrice = $pivotData['pivot_cost_price'] ?? ($supplier->pivot->cost_price ?? 0);
                                $leadTime = $pivotData['pivot_lead_time_days'] ?? ($supplier->pivot->lead_time_days ?? 0);
                            @endphp
                            <div class="col-md-6">
                                <div class="card border h-100 supplier-card-show">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="supplier-name">
                                                <i class="fas fa-truck me-2 text-warning"></i>{{ $supplier->name }}
                                            </div>
                                            <div class="supplier-email">
                                                <i class="fas fa-envelope me-1"></i>{{ $supplier->email }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <!-- Cost Price Only -->
                                        <div class="mb-4">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="fw-bold">
                                                    <i class="fas fa-money-bill-wave me-1 text-success"></i>Cost Price
                                                </span>
                                                <span class="badge bg-success fs-6">
                                                    ${{ number_format($costPrice, 2) }}
                                                </span>
                                            </div>
                                            <small class="supplier-helper-text d-block">
                                                Price you pay to this supplier
                                            </small>
                                        </div>

                                        <!-- Lead Time Only -->
                                        <div class="mb-2">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="fw-bold">
                                                    <i class="fas fa-clock me-1 text-info"></i>Lead Time
                                                </span>
                                                <span class="badge bg-info fs-6">
                                                    {{ $leadTime }} days
                                                </span>
                                            </div>
                                            <small class="supplier-helper-text d-block">
                                                Delivery time from this supplier
                                            </small>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-light text-center">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            @if(isset($supplier->pivot) && $supplier->pivot->created_at)
                                                Added: {{ $supplier->pivot->created_at->format('M d, Y') }}
                                            @else
                                                Added: Unknown date
                                            @endif
                                        </small>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Supplier Statistics -->
                        <div class="card mt-4 border-0 bg-light">
                            <div class="card-body p-3">
                                <h6 class="mb-3 d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-2">
                                        <i class="fas fa-chart-bar text-primary"></i>
                                    </div>
                                    <span>Supplier Statistics</span>
                                </h6>
                                
                                <div class="row text-center g-2">
                                    <!-- Suppliers Card -->
                                    <div class="col-md-3 col-6">
                                        <div class="bg-white p-2 rounded border">
                                            <div class="text-warning fs-5 mb-1">
                                                <i class="fas fa-truck"></i>
                                            </div>
                                            <div class="h5 mb-1">{{ $suppliersCount }}</div>
                                            <small class="supplier-helper-text">Suppliers</small>
                                            @if($suppliersCount > 0)
                                            <div class="mt-1">
                                                <button type="button" 
                                                        class="btn btn-sm p-0 border-0 bg-transparent" 
                                                        data-bs-toggle="popover" 
                                                        data-bs-html="true"
                                                        data-bs-title="All Suppliers"
                                                        data-bs-content="@foreach($suppliers as $supplier)&bull; {{ $supplier->name }}<br>@endforeach">
                                                    <i class="fas fa-info-circle text-primary" style="font-size: 0.8rem;"></i>
                                                </button>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Min Cost Card -->
                                    <div class="col-md-3 col-6">
                                        <div class="bg-white p-2 rounded border">
                                            <div class="text-success fs-5 mb-1">
                                                <i class="fas fa-dollar-sign"></i>
                                            </div>
                                            <div class="h5 mb-1">
                                                ${{ number_format($costPrices->min(), 2) }}
                                            </div>
                                            <small class="supplier-helper-text">Min Cost</small>
                                            @if($minCostSuppliers->count() > 0)
                                            <div class="mt-1">
                                                <button type="button" 
                                                        class="btn btn-sm p-0 border-0 bg-transparent" 
                                                        data-bs-toggle="popover" 
                                                        data-bs-html="true"
                                                        data-bs-title="Lowest Cost Suppliers"
                                                        data-bs-content="@foreach($minCostSuppliers as $supplier)&bull; {{ $supplier->name }}<br>@endforeach">
                                                    <i class="fas fa-info-circle text-success" style="font-size: 0.8rem;"></i>
                                                </button>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Max Cost Card -->
                                    <div class="col-md-3 col-6">
                                        <div class="bg-white p-2 rounded border">
                                            <div class="text-danger fs-5 mb-1">
                                                <i class="fas fa-dollar-sign"></i>
                                            </div>
                                            <div class="h5 mb-1">
                                                ${{ number_format($costPrices->max(), 2) }}
                                            </div>
                                            <small class="supplier-helper-text">Max Cost</small>
                                            @if($maxCostSuppliers->count() > 0)
                                            <div class="mt-1">
                                                <button type="button" 
                                                        class="btn btn-sm p-0 border-0 bg-transparent" 
                                                        data-bs-toggle="popover" 
                                                        data-bs-html="true"
                                                        data-bs-title="Highest Cost Suppliers"
                                                        data-bs-content="@foreach($maxCostSuppliers as $supplier)&bull; {{ $supplier->name }}<br>@endforeach">
                                                    <i class="fas fa-info-circle text-danger" style="font-size: 0.8rem;"></i>
                                                </button>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Best Efficiency Card -->
                                    <div class="col-md-3 col-6">
                                        <div class="bg-white p-2 rounded border">
                                            <div class="text-indigo fs-5 mb-1">
                                                <i class="fas fa-trophy"></i>
                                            </div>
                                            <div class="h5 mb-1">
                                                {{ number_format($bestEfficiency, 0) }}%
                                            </div>
                                            <small class="supplier-helper-text">Best Efficiency</small>
                                            @if($bestSuppliers->count() > 0)
                                            <div class="mt-1">
                                                <button type="button" 
                                                        class="btn btn-sm p-0 border-0 bg-transparent" 
                                                        data-bs-toggle="popover" 
                                                        data-bs-html="true"
                                                        data-bs-title="Most Efficient Suppliers"
                                                        data-bs-content="@foreach($bestSuppliers as $supplier)&bull; {{ $supplier->name }}<br>@endforeach">
                                                    <i class="fas fa-info-circle text-indigo" style="font-size: 0.8rem;"></i>
                                                </button>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <div class="text-center py-4">
                                <i class="fas fa-truck fa-3x text-warning mb-3"></i>
                                <h4>No Suppliers Assigned</h4>
                                <p class="text-muted mb-3">This product doesn't have any suppliers yet.</p>
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">
                                    <i class="fas fa-plus me-2"></i>Add Suppliers
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
                <!-- ========== END SUPPLIERS SECTION ========== -->

                <!-- Details Grid -->
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">
                                    <i class="fas fa-calendar-plus text-primary me-2"></i>Creation Details
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="text-center py-3">
                                    <div class="display-6 text-primary mb-2">
                                        {{ $product->created_at->format('M d, Y') }}
                                    </div>
                                    <div class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $product->created_at->format('h:i A') }}
                                    </div>
                                    <div class="mt-3">
                                        <span class="badge bg-primary bg-opacity-10 text-primary">
                                            {{ $product->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">
                                    <i class="fas fa-calendar-check text-success me-2"></i>Update Details
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="text-center py-3">
                                    <div class="display-6 text-success mb-2">
                                        {{ $product->updated_at->format('M d, Y') }}
                                    </div>
                                    <div class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $product->updated_at->format('h:i A') }}
                                    </div>
                                    <div class="mt-3">
                                        <span class="badge bg-success bg-opacity-10 text-success">
                                            {{ $product->updated_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Category Information -->
                @if($product->category)
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-sitemap text-info me-2"></i>Category Information
                        </h5>
                        <a href="{{ route('categories.products.show', ['category' => $product->category->id]) }}" 
                           class="btn btn-sm btn-outline-info">
                            <i class="fas fa-eye me-1"></i>View All in Category
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="mb-2">{{ $product->category->name }}</h4>
                                @if(isset($product->category->products_count))
                                <p class="text-muted mb-3">
                                    This category contains {{ $product->category->products_count }} products
                                </p>
                                @endif
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-edit me-1"></i>Change Category
                                </a>
                            </div>
                            <div class="col-md-4 text-center">
                                @switch($product->category->name)
                                    @case('Electronics')<i class="fas fa-laptop fa-4x text-primary"></i>@break
                                    @case('Fashion')<i class="fas fa-tshirt fa-4x text-danger"></i>@break
                                    @case('Home & Garden')<i class="fas fa-home fa-4x text-success"></i>@break
                                    @case('Books')<i class="fas fa-book fa-4x text-warning"></i>@break
                                    @case('Sports')<i class="fas fa-futbol fa-4x text-info"></i>@break
                                    @case('Health & Beauty')<i class="fas fa-spa fa-4x text-purple"></i>@break
                                    @case('Toys')<i class="fas fa-gamepad fa-4x text-teal"></i>@break
                                    @case('Automotive')<i class="fas fa-car fa-4x text-orange"></i>@break
                                    @case('Test Empty Category')<i class="fas fa-question fa-4x text-secondary"></i>@break
                                    @default<i class="fas fa-tag fa-4x text-info"></i>
                                @endswitch
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Database Relationship Info -->
        <div class="card border-0 shadow-sm slide-in" style="animation-delay: 0.2s">
            <div class="card-header bg-gradient-dark text-white">
                <h5 class="mb-0">
                    <i class="fas fa-project-diagram me-2"></i>Database Relationships
                </h5>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <div class="mb-4">
                        <!-- Product -->
                        <div class="d-inline-block p-3 rounded bg-success text-white mb-2">
                            <i class="fas fa-box fa-2x"></i>
                            <div>products</div>
                        </div>
                        
                        <!-- Many-to-Many Connection -->
                        <div class="d-inline-block mx-3">
                            <i class="fas fa-exchange-alt fa-2x text-warning"></i>
                        </div>
                        
                        <!-- Pivot Table -->
                        <div class="d-inline-block p-3 rounded bg-warning text-dark mb-2">
                            <i class="fas fa-table fa-2x"></i>
                            <div>product_supplier</div>
                        </div>
                        
                        <!-- Many-to-Many Connection -->
                        <div class="d-inline-block mx-3">
                            <i class="fas fa-exchange-alt fa-2x text-warning"></i>
                        </div>
                        
                        <!-- Supplier -->
                        <div class="d-inline-block p-3 rounded bg-info text-white">
                            <i class="fas fa-truck fa-2x"></i>
                            <div>suppliers</div>
                        </div>
                    </div>
                    
                    <div class="bg-light p-4 rounded mb-3">
                        <h6>Many-to-Many Relationship with Pivot Data</h6>
                        <p class="mb-0">
                            <code>Product::belongsToMany(Supplier::class)</code> ←→ 
                            <code>Supplier::belongsToMany(Product::class)</code><br>
                            <small class="text-success">
                                ✓ Pivot data: <code>cost_price</code>, <code>lead_time_days</code>
                            </small>
                        </p>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <h6>Product Table</h6>
                            <div class="bg-light p-3 rounded">
                                <code>id (PK)</code><br>
                                <code>name (UNIQUE)</code><br>
                                <code>price (DECIMAL)</code><br>
                                <code>description (NULLABLE)</code><br>
                                <code>category_id (FK)</code><br>
                                <code>timestamps</code>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h6>Pivot Table</h6>
                            <div class="bg-light p-3 rounded">
                                <code>id (PK)</code><br>
                                <code>product_id (FK)</code><br>
                                <code>supplier_id (FK)</code><br>
                                <code>cost_price (DECIMAL)</code><br>
                                <code>lead_time_days (INT)</code><br>
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
                </div>
                <div class="text-center mt-4">
                    <div class="alert alert-success mb-0">
                        <h6 class="mb-2">
                            <i class="fas fa-lightbulb me-2"></i>
                            Many-to-Many Relationship Active
                        </h6>
                        <p class="mb-0 small">
                            Product <strong>"{{ $product->name }}"</strong> is supplied by 
                            <strong>{{ $suppliersCount }}</strong> suppliers with individual cost and lead time.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Actions Card -->
        <div class="card shadow-lg mb-4 slide-in" style="animation-delay: 0.1s">
            <div class="card-header bg-dark text-white">
                <div class="d-flex align-items-center">
                    <i class="fas fa-cogs fa-lg me-3"></i>
                    <h4 class="mb-0">Product Actions</h4>
                </div>
            </div>
            <div class="card-body">
                <div class="d-grid gap-3">
                    <!-- Edit Button -->
                    <a href="{{ route('products.edit', $product) }}" 
                       class="btn btn-warning btn-lg py-3">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="fas fa-edit fa-2x me-3"></i>
                            <div class="text-start">
                                <h5 class="mb-1">Edit Product</h5>
                                <small class="opacity-75">Update product details</small>
                            </div>
                        </div>
                    </a>
                    
                    <!-- Delete Button -->
                    <form action="{{ route('products.destroy', $product) }}" 
                          method="POST" 
                          class="delete-form"
                          data-product-name="{{ $product->name }}"
                          data-product-id="{{ $product->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-lg py-3 w-100">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fas fa-trash fa-2x me-3"></i>
                                <div class="text-start">
                                    <h5 class="mb-1">Delete Product</h5>
                                    <small class="opacity-75">Permanently remove</small>
                                </div>
                            </div>
                        </button>
                    </form>
                    
                    <!-- Back Button -->
                    <a href="{{ route('products.index') }}" 
                       class="btn btn-secondary btn-lg py-3">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="fas fa-arrow-left fa-2x me-3"></i>
                            <div class="text-start">
                                <h5 class="mb-1">Back to List</h5>
                                <small class="opacity-75">View all products</small>
                            </div>
                        </div>
                    </a>
                    
                    <!-- Add New Button -->
                    <a href="{{ route('products.create') }}" 
                       class="btn btn-primary btn-lg py-3">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="fas fa-plus-circle fa-2x me-3"></i>
                            <div class="text-start">
                                <h5 class="mb-1">Add New Product</h5>
                                <small class="opacity-75">Create another product</small>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Quick Stats -->
        <div class="card shadow-sm mb-4 slide-in" style="animation-delay: 0.3s">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar me-2 text-primary"></i>Product Statistics
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <!-- Product ID -->
                    <div class="list-group-item border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center" style="min-width: 0;">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3 flex-shrink-0">
                                    <i class="fas fa-hashtag text-primary"></i>
                                </div>
                                <div class="text-truncate">
                                    <h6 class="mb-1 text-truncate">Product ID</h6>
                                    <small class="text-muted">Unique identifier</small>
                                </div>
                            </div>
                            <div class="flex-shrink-0 ms-2">
                                <span class="badge bg-primary fs-6 px-3 py-2 text-nowrap">
                                    #{{ $product->id }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Price -->
                    <div class="list-group-item border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center" style="min-width: 0;">
                                <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3 flex-shrink-0">
                                    <i class="fas fa-dollar-sign text-success"></i>
                                </div>
                                <div class="text-truncate">
                                    <h6 class="mb-1 text-truncate">Price</h6>
                                    <small class="text-muted">Retail price</small>
                                </div>
                            </div>
                            <div class="flex-shrink-0 ms-2">
                                <span class="badge bg-success fs-6 px-3 py-2 text-nowrap">
                                    ${{ number_format($product->price, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Suppliers Count -->
                    <div class="list-group-item border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center" style="min-width: 0;">
                                <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3 flex-shrink-0">
                                    <i class="fas fa-truck text-warning"></i>
                                </div>
                                <div class="text-truncate">
                                    <h6 class="mb-1 text-truncate">Suppliers</h6>
                                    <small class="text-muted">Total suppliers</small>
                                </div>
                            </div>
                            <div class="flex-shrink-0 ms-2">
                                <span class="badge bg-warning text-dark fs-6 px-3 py-2 text-nowrap">
                                    {{ $suppliersCount }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Days Since Creation -->
                    @php
                        $daysSinceCreation = abs(round(now()->diffInDays($product->created_at)));
                        $ageText = $daysSinceCreation == 0 ? 'Today' : $daysSinceCreation . ' days';
                    @endphp
                    <div class="list-group-item border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center" style="min-width: 0;">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3 flex-shrink-0">
                                    <i class="fas fa-calendar-day text-primary"></i>
                                </div>
                                <div class="text-truncate">
                                    <h6 class="mb-1 text-truncate">Age</h6>
                                    <small class="text-muted">Days in system</small>
                                </div>
                            </div>
                            <div class="flex-shrink-0 ms-2">
                                <span class="badge bg-primary fs-6 px-3 py-2 text-nowrap">
                                    {{ $ageText }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Last Updated -->
                    <div class="list-group-item border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center" style="min-width: 0;">
                                <div class="bg-orange bg-opacity-10 rounded-circle p-2 me-3 flex-shrink-0">
                                    <i class="fas fa-history text-orange"></i>
                                </div>
                                <div class="text-truncate">
                                    <h6 class="mb-1 text-truncate">Last Updated</h6>
                                    <small class="text-muted">Days ago</small>
                                </div>
                            </div>
                            <div class="flex-shrink-0 ms-2">
                                @php
                                    $daysSinceUpdate = abs(round(now()->diffInDays($product->updated_at)));
                                    $updateText = $daysSinceUpdate == 0 ? 'Today' : $daysSinceUpdate . ' days';
                                @endphp
                                <span class="badge bg-orange fs-6 px-3 py-2 text-nowrap">
                                    {{ $updateText }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Eager Loading Demo -->
        <div class="card shadow-sm slide-in" style="animation-delay: 0.4s">
            <div class="card-header bg-gradient-info text-white">
                <h5 class="mb-0">
                    <i class="fas fa-tachometer-alt me-2"></i>Performance Optimized
                </h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <i class="fas fa-bolt fa-3x text-warning mb-3"></i>
                    <h5>Eager Loading Active</h5>
                </div>
                <div class="alert alert-success">
                    <h6><i class="fas fa-check-circle me-2"></i>N+1 Problem Solved</h6>
                    <small class="mb-0 d-block">
                        Category and supplier data loaded efficiently:
                    </small>
                    <code class="d-block mt-2 p-2 bg-light rounded">
                        Product::with(['category', 'suppliers'])-&gt;find({{ $product->id }})
                    </code>
                </div>
                <div class="alert alert-info">
                    <h6><i class="fas fa-database me-2"></i>Query Count</h6>
                    <small class="mb-0">
                        Without eager loading: <strong>{{ $suppliersCount + 2 }} queries</strong><br>
                        With eager loading: <strong>1 query</strong>
                    </small>
                </div>
            </div>
        </div>
        
        <!-- Category Products -->
        @if($product->category && $product->category->products_count > 1)
        <div class="card shadow-sm mt-4 slide-in" style="animation-delay: 0.5s">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="fas fa-th-list me-2 text-info"></i>Other Products in Category
                </h5>
            </div>
            <div class="card-body">
                <small class="text-muted mb-3 d-block">
                    <i class="fas fa-info-circle me-1"></i>
                    Showing 3 random products from {{ $product->category->name }}
                </small>
                @php
                    $categoryProducts = $product->category->products()
                        ->where('id', '!=', $product->id)
                        ->inRandomOrder()
                        ->take(3)
                        ->get();
                @endphp
                @if($categoryProducts->count() > 0)
                    @foreach($categoryProducts as $relatedProduct)
                    <div class="border-start border-3 
                        @if($product->category->name == 'Electronics') border-primary
                        @elseif($product->category->name == 'Fashion') border-danger
                        @elseif($product->category->name == 'Home & Garden') border-success
                        @elseif($product->category->name == 'Books') border-warning
                        @elseif($product->category->name == 'Sports') border-info
                        @elseif($product->category->name == 'Health & Beauty') border-purple
                        @elseif($product->category->name == 'Toys') border-teal
                        @elseif($product->category->name == 'Automotive') border-orange
                        @elseif($product->category->name == 'Test Empty Category') border-secondary
                        @else border-secondary @endif
                        ps-3 py-2 mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">{{ $relatedProduct->name }}</h6>
                                <small class="text-muted">
                                    ${{ number_format($relatedProduct->price, 2) }}
                                </small>
                                <div>
                                    <small class="text-warning">
                                        <i class="fas fa-truck me-1"></i>
                                        {{ $relatedProduct->suppliers_count ?? 0 }} suppliers
                                    </small>
                                </div>
                            </div>
                            <a href="{{ route('products.show', $relatedProduct) }}" 
                               class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-info-circle fa-2x text-muted mb-3"></i>
                        <p class="text-muted mb-0">No other products in this category</p>
                    </div>
                @endif
                <div class="text-center mt-3">
                    <a href="{{ route('categories.products.show', ['category' => $product->category->id]) }}" 
                       class="btn btn-sm btn-outline-info">
                        <i class="fas fa-external-link-alt me-1"></i>View All
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add animation to all slide-in elements
        const slideInElements = document.querySelectorAll('.slide-in');
        slideInElements.forEach((el, index) => {
            el.style.animationDelay = `${index * 0.1}s`;
        });
        
        // Highlight current product in stats
        const statsCards = document.querySelectorAll('.card .card-body .row .col-6');
        statsCards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
        });
        
        // Category icon animation
        const categoryIcon = document.querySelector('.category-icon-large');
        if (categoryIcon) {
            categoryIcon.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.1) rotate(5deg)';
            });
            categoryIcon.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1) rotate(0deg)';
            });
        }
        
        // Performance optimization info
        console.log('Product Show Page - Eager Loading Active');
        console.log('Category loaded with product: ', {!! json_encode($product->category ? $product->category->name : null) !!});
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Check if we're on the product show page
        if (window.location.pathname.match(/\/products\/\d+$/)) {
            console.log('Fixing dropdown z-index on product show page...');

            // 1. Push main product card to back
            const mainProductCard = document.querySelector('.card.shadow-lg.mb-4.slide-in');
            if (mainProductCard) {
                mainProductCard.style.zIndex = '5';
                mainProductCard.style.position = 'relative';
            }

            // 2. Push stats card to back
            const statsCard = document.querySelector('.card.shadow-sm.mb-4:nth-child(2)');
            if (statsCard) {
                statsCard.style.zIndex = '5';
                statsCard.style.position = 'relative';
            }

            // 3. Push eager loading card to back
            const eagerLoadingCard = document.querySelector('.card.shadow-sm.slide-in');
            if (eagerLoadingCard) {
                eagerLoadingCard.style.zIndex = '5';
                eagerLoadingCard.style.position = 'relative';
            }

            // 4. Push category products card to back
            const categoryProductsCard = document.querySelector('.card.shadow-sm.mt-4.slide-in');
            if (categoryProductsCard) {
                categoryProductsCard.style.zIndex = '5';
                categoryProductsCard.style.position = 'relative';
            }

            // 5. Push database relationship card to back
            const relationshipCard = document.querySelector('.card.border-0.shadow-sm.slide-in');
            if (relationshipCard) {
                relationshipCard.style.zIndex = '5';
                relationshipCard.style.position = 'relative';
            }

            // 6. Bring the actions card to back (so dropdown appears over it)
            const actionsCard = document.querySelector('.card.shadow-lg.mb-4.slide-in[style*="animation-delay: 0.1s"]');
            if (actionsCard) {
                actionsCard.style.zIndex = '10'; // Keep it clickable but below dropdown
                actionsCard.style.position = 'relative';
            }

            // 7. Bring dropdown to front (MOST IMPORTANT)
            const dropdownMenu = document.querySelector('.dropdown-menu');
            if (dropdownMenu) {
                dropdownMenu.style.zIndex = '9999';
                dropdownMenu.style.position = 'absolute';
                dropdownMenu.style.boxShadow = '0 10px 30px rgba(0,0,0,0.3)';

                // Ensure dropdown stays above everything
                dropdownMenu.parentElement.style.position = 'relative';
                dropdownMenu.parentElement.style.zIndex = '10000';
            }

            // 8. Ensure navbar is properly positioned
            const navbar = document.querySelector('.navbar');
            if (navbar) {
                navbar.style.zIndex = '1000';
                navbar.style.position = 'relative';
            }

            // 9. Fix breadcrumb z-index
            const breadcrumb = document.querySelector('nav[aria-label="breadcrumb"]');
            if (breadcrumb) {
                breadcrumb.style.zIndex = '5';
                breadcrumb.style.position = 'relative';
            }

            // 10. Fix page title area
            const pageTitle = document.querySelector('.page-title');
            if (pageTitle) {
                pageTitle.parentElement.style.zIndex = '5';
                pageTitle.parentElement.style.position = 'relative';
            }

            console.log('Product show page dropdown fix applied successfully');
        }
        
        // Initialize popovers with HTML enabled
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl, {
                html: true,
                trigger: 'click',
                placement: 'top',
                container: 'body',
                sanitize: false  // Allow HTML content
            });
        });
        
        // Close popovers when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('[data-bs-toggle="popover"]') && 
                !e.target.closest('.popover')) {
                popoverList.forEach(function(popover) {
                    popover.hide();
                });
            }
        });
    });
</script>
@endpush
@endsection