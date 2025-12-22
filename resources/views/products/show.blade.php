@extends('layouts.app')

@section('title', $product->name)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('products.index') }}"><i class="fas fa-boxes"></i> Products</a></li>
    <li class="breadcrumb-item active"><i class="fas fa-eye"></i> View Product</li>
@endsection

@section('content')
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
                @elseif($product->category && $product->category->name == 'Test Empty Category') bg-test-empty
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
                            Task 05: Eloquent Relationships
                        </small>
                    </div>
                </div>
                <span class="badge bg-light text-dark fs-5 px-3 py-2">
                    ${{ number_format($product->price, 2) }}
                </span>
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
                                @elseif($product->category->name == 'Test Empty Category') bg-test-empty
                                @else bg-secondary @endif fs-6">
                                <i class="fas fa-tag me-1"></i>{{ $product->category->name }}
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
                        <a href="{{ route('products.index', ['category' => $product->category->id]) }}" 
                           class="btn btn-sm btn-outline-info">
                            <i class="fas fa-eye me-1"></i>View All in Category
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-3 text-center">
                                <div class="category-icon-large mb-3">
                                    @switch($product->category->name)
                                        @case('Electronics')
                                            <div class="bg-primary bg-opacity-10 p-4 rounded-circle d-inline-block">
                                                <i class="fas fa-laptop fa-3x text-primary"></i>
                                            </div>
                                            @break
                                        @case('Fashion')
                                            <div class="bg-danger bg-opacity-10 p-4 rounded-circle d-inline-block">
                                                <i class="fas fa-tshirt fa-3x text-danger"></i>
                                            </div>
                                            @break
                                        @case('Home & Garden')
                                            <div class="bg-success bg-opacity-10 p-4 rounded-circle d-inline-block">
                                                <i class="fas fa-home fa-3x text-success"></i>
                                            </div>
                                            @break
                                        @case('Books')
                                            <div class="bg-warning bg-opacity-10 p-4 rounded-circle d-inline-block">
                                                <i class="fas fa-book fa-3x text-warning"></i>
                                            </div>
                                            @break
                                        @case('Sports')
                                            <div class="bg-info bg-opacity-10 p-4 rounded-circle d-inline-block">
                                                <i class="fas fa-futbol fa-3x text-info"></i>
                                            </div>
                                            @break
                                        @case('Health & Beauty')
                                            <div class="bg-purple bg-opacity-10 p-4 rounded-circle d-inline-block">
                                                <i class="fas fa-spa fa-3x text-purple"></i>
                                            </div>
                                            @break
                                        @case('Toys')
                                            <div class="bg-teal bg-opacity-10 p-4 rounded-circle d-inline-block">
                                                <i class="fas fa-gamepad fa-3x text-teal"></i>
                                            </div>
                                            @break
                                        @case('Automotive')
                                            <div class="bg-orange bg-opacity-10 p-4 rounded-circle d-inline-block">
                                                <i class="fas fa-car fa-3x text-orange"></i>
                                            </div>
                                            @break
                                        @case('Test Empty Category')
                                            <div class="bg-test-empty bg-opacity-10 p-4 rounded-circle d-inline-block">
                                                <i class="fas fa-question fa-3x text-test-empty"></i>
                                            </div>
                                            @break
                                        @default
                                            <div class="bg-secondary bg-opacity-10 p-4 rounded-circle d-inline-block">
                                                <i class="fas fa-tag fa-3x text-secondary"></i>
                                            </div>
                                    @endswitch
                                </div>
                            </div>
                            <div class="col-md-9">
                                <h4 class="mb-2">{{ $product->category->name }}</h4>
                                <p class="text-muted mb-3">
                                    This product belongs to the <strong>{{ $product->category->name }}</strong> category.
                                    @if($product->category->products_count ?? $product->category->products()->count() > 1)
                                        There are {{ ($product->category->products_count ?? $product->category->products()->count()) - 1 }} 
                                        other products in this category.
                                    @endif
                                </p>
                                <div class="d-flex gap-2">
                                    <span class="badge bg-light text-dark">
                                        <i class="fas fa-database me-1"></i>
                                        Category ID: {{ $product->category->id }}
                                    </span>
                                    <span class="badge bg-info bg-opacity-10 text-info">
                                        <i class="fas fa-link me-1"></i>
                                        Foreign Key: {{ $product->category_id }}
                                    </span>
                                </div>
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
                    <i class="fas fa-project-diagram me-2"></i>Database Relationship
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-5">
                        <div class="p-4 rounded bg-primary bg-opacity-10">
                            <i class="fas fa-folder fa-3x text-primary mb-3"></i>
                            <h5>Category</h5>
                            <div class="mt-3">
                                <code>categories</code>
                                <div class="text-start mt-2 small">
                                    <div class="bg-light p-2 rounded">
                                        <code>id: {{ $product->category ? $product->category->id : 'NULL' }}</code><br>
                                        <code>name: "{{ $product->category ? $product->category->name : 'NULL' }}"</code>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-center justify-content-center">
                        <div class="bg-light p-3 rounded-circle">
                            <i class="fas fa-link fa-2x text-info"></i>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="p-4 rounded bg-success bg-opacity-10">
                            <i class="fas fa-box fa-3x text-success mb-3"></i>
                            <h5>Product</h5>
                            <div class="mt-3">
                                <code>products</code>
                                <div class="text-start mt-2 small">
                                    <div class="bg-light p-2 rounded">
                                        <code>id: {{ $product->id }}</code><br>
                                        <code>name: "{{ $product->name }}"</code><br>
                                        <code>category_id: {{ $product->category_id ?? 'NULL' }}</code>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <div class="alert alert-info mb-0">
                        <h6 class="mb-2">
                            <i class="fas fa-lightbulb me-2"></i>
                            One-to-Many Relationship
                        </h6>
                        <p class="mb-0 small">
                            <code>Category::hasMany(Product::class)</code> ←→ 
                            <code>Product::belongsTo(Category::class)</code>
                            @if($product->category_id)
                                <br><span class="text-success">✓ Foreign key constraint is active</span>
                            @endif
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
                                    <small class="text-muted">Current price</small>
                                </div>
                            </div>
                            <div class="flex-shrink-0 ms-2">
                                <span class="badge bg-success fs-6 px-3 py-2 text-nowrap" 
                                      style="max-width: 150px; overflow: hidden; text-overflow: ellipsis;"
                                      title="${{ number_format($product->price, 2) }}">
                                    ${{ number_format($product->price, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Description Length -->
                    <div class="list-group-item border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center" style="min-width: 0;">
                                <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3 flex-shrink-0">
                                    <i class="fas fa-file-alt text-warning"></i>
                                </div>
                                <div class="text-truncate">
                                    <h6 class="mb-1 text-truncate">Description</h6>
                                    <small class="text-muted">Character count</small>
                                </div>
                            </div>
                            <div class="flex-shrink-0 ms-2">
                                <span class="badge bg-warning text-dark fs-6 px-3 py-2 text-nowrap">
                                    {{ strlen($product->description ?? '0') }}
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
                        Category data loaded efficiently with:
                    </small>
                    <code class="d-block mt-2 p-2 bg-light rounded">
                        Product::with('category')->find({{ $product->id }})
                    </code>
                </div>
                <div class="alert alert-info">
                    <h6><i class="fas fa-database me-2"></i>Query Count</h6>
                    <small class="mb-0">
                        Without eager loading: 2 queries<br>
                        With eager loading: <strong>1 query</strong>
                    </small>
                </div>
            </div>
        </div>
        
        <!-- Category Products -->
        @if($product->category && ($product->category->products_count ?? 0) > 1)
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
                        @elseif($product->category->name == 'Test Empty Category') border-test-empty
                        @else border-secondary @endif
                        ps-3 py-2 mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">{{ $relatedProduct->name }}</h6>
                                <small class="text-muted">
                                    ${{ number_format($relatedProduct->price, 2) }}
                                </small>
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
                    <a href="{{ route('products.index', ['category' => $product->category->id]) }}" 
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
});
</script>
@endpush
@endsection