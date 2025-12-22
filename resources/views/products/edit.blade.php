@extends('layouts.app')

@section('title', 'Edit Product')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('products.index') }}"><i class="fas fa-boxes"></i> Products</a></li>
    <li class="breadcrumb-item active"><i class="fas fa-edit"></i> Edit {{ $product->name }}</li>
@endsection

@section('content')
<div class="row justify-content-center fade-in">
    <div class="col-md-8">
        <!-- Main Form Card -->
        <div class="card shadow-lg">
            <div class="card-header bg-warning text-dark">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-edit me-2"></i>Edit Product
                    </h4>
                    <div>
                        <span class="badge bg-light text-dark me-2">
                            ID: #{{ $product->id }}
                        </span>
                        @if($product->category)
                            <span class="badge bg-info">
                                <i class="fas fa-tag me-1"></i>{{ $product->category->name }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            
            {{-- Validation summary --}}
            @if($errors->any()) 
                <div class="alert alert-danger m-3 slide-in">
                    <h5><i class="fas fa-exclamation-triangle me-2"></i>Please fix the following errors:</h5>
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card-body">
                <form action="{{ route('products.update', $product) }}" method="POST" id="editProductForm">
                    @csrf
                    @method('PUT')
                    
                    <!-- Product Name -->
                    <div class="mb-4">
                        <label for="name" class="form-label fw-bold">
                            <i class="fas fa-tag me-1 text-primary"></i>Product Name
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-box text-primary"></i>
                            </span>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $product->name) }}"
                                   placeholder="Enter product name"
                                   required
                                   autofocus>
                        </div>
                        @error('name')
                            <div class="invalid-feedback d-block mt-2">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                        <small class="text-muted mt-1 d-block">
                            <i class="fas fa-info-circle me-1"></i>Current name: "<strong>{{ $product->name }}</strong>"
                        </small>
                    </div>
                    
                    <!-- Price -->
                    <div class="mb-4">
                        <label for="price" class="form-label fw-bold">
                            <i class="fas fa-dollar-sign me-1 text-success"></i>Price
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">$</span>
                            <input type="number" 
                                   step="0.01" 
                                   min="0.01"
                                   max="999999.99"
                                   class="form-control @error('price') is-invalid @enderror" 
                                   id="price" 
                                   name="price" 
                                   value="{{ old('price', $product->price) }}"
                                   placeholder="0.00"
                                   required>
                            <span class="input-group-text bg-light">USD</span>
                        </div>
                        @error('price')
                            <div class="invalid-feedback d-block mt-2">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                        <small class="text-muted mt-1 d-block">
                            <i class="fas fa-info-circle me-1"></i>Current price: <strong>${{ number_format($product->price, 2) }}</strong>
                        </small>
                    </div>
                    
                    <!-- Category Selection -->
                    <div class="mb-4">
                        <label for="category_id" class="form-label fw-bold">
                            <i class="fas fa-folder me-1 text-info"></i>Category
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-tags text-info"></i>
                            </span>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" 
                                    name="category_id"
                                    required>
                                <option value="" disabled>Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}
                                        data-icon="{{ getCategoryIcon($category->name) }}">
                                        {{ $category->name }}
                                        @if($product->category_id == $category->id)
                                            <span class="badge bg-success float-end">Current</span>
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('category_id')
                            <div class="invalid-feedback d-block mt-2">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                        <small class="text-muted mt-1 d-block">
                            <i class="fas fa-info-circle me-1"></i>
                            @if($product->category)
                                Current category: <strong>{{ $product->category->name }}</strong>
                            @else
                                <span class="text-danger">No category assigned!</span>
                            @endif
                        </small>
                    </div>
                    
                    <!-- Description -->
                    <div class="mb-4">
                        <label for="description" class="form-label fw-bold">
                            <i class="fas fa-align-left me-1 text-warning"></i>Description
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light align-items-start pt-3">
                                <i class="fas fa-comment text-warning"></i>
                            </span>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="4"
                                      placeholder="Describe the product features, specifications, and benefits...">{{ old('description', $product->description) }}</textarea>
                        </div>
                        @error('description')
                            <div class="invalid-feedback d-block mt-2">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                        <div class="d-flex justify-content-between mt-1">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>Current length: {{ strlen($product->description ?? '') }} characters
                            </small>
                            <small class="text-muted">
                                <span id="charCount">{{ strlen(old('description', $product->description ?? '')) }}</span> characters
                            </small>
                        </div>
                    </div>
                    
                    <!-- Form Actions -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4 pt-3 border-top">
                        <a href="{{ route('products.show', $product) }}" 
                           class="btn btn-outline-info me-md-2">
                            <i class="fas fa-eye me-1"></i>View Product
                        </a>
                        <a href="{{ route('products.index') }}" 
                           class="btn btn-outline-secondary me-md-2">
                            <i class="fas fa-times me-1"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-warning" id="submitBtn">
                            <i class="fas fa-sync-alt me-1"></i>Update Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Product Information Card -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card shadow-sm slide-in">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>Product Details
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <p class="mb-2">
                                    <strong><i class="fas fa-hashtag me-1 text-muted"></i>ID</strong><br>
                                    <span class="badge bg-dark">#{{ $product->id }}</span>
                                </p>
                                <p class="mb-2">
                                    <strong><i class="fas fa-calendar-plus me-1 text-muted"></i>Created</strong><br>
                                    {{ $product->created_at->format('F d, Y') }}<br>
                                    <small class="text-muted">{{ $product->created_at->diffForHumans() }}</small>
                                </p>
                            </div>
                            <div class="col-6">
                                <p class="mb-2">
                                    <strong><i class="fas fa-dollar-sign me-1 text-muted"></i>Current Price</strong><br>
                                    <span class="badge bg-success fs-6">${{ number_format($product->price, 2) }}</span>
                                </p>
                                <p class="mb-2">
                                    <strong><i class="fas fa-calendar-check me-1 text-muted"></i>Last Updated</strong><br>
                                    {{ $product->updated_at->format('F d, Y') }}<br>
                                    <small class="text-muted">{{ $product->updated_at->diffForHumans() }}</small>
                                </p>
                            </div>
                        </div>
                        <div class="mt-3">
                            <strong><i class="fas fa-history me-1 text-muted"></i>Edit History</strong><br>
                            <small class="text-muted">This product has been updated {{ $product->updated_at->diffInDays($product->created_at) }} days after creation</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card shadow-sm slide-in" style="animation-delay: 0.1s">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="fas fa-shield-alt me-2 text-success"></i>Update Rules
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-warning mb-3">
                            <h6><i class="fas fa-exclamation-circle me-2"></i>Important:</h6>
                            <small class="mb-0">
                                Product name must remain unique. The current product will be excluded from uniqueness check.
                            </small>
                        </div>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <small>All fields except description are required</small>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <small>Price must be greater than $0.01</small>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <small>Category must be selected from list</small>
                            </li>
                            <li>
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <small>Changes are saved immediately</small>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Category Comparison Card -->
        @if($product->category)
        <div class="card mt-4 shadow-sm slide-in" style="animation-delay: 0.2s">
            <div class="card-header bg-gradient-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-exchange-alt me-2"></i>Category Change Preview
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-6">
                        <div class="p-3 rounded bg-light">
                            <h6>Current Category</h6>
                            <div class="category-badge-large my-3 
                                @if($product->category->name == 'Electronics') category-electronics
                                @elseif($product->category->name == 'Fashion') category-fashion
                                @elseif($product->category->name == 'Home & Garden') category-home
                                @elseif($product->category->name == 'Books') category-books
                                @elseif($product->category->name == 'Sports') category-sports
                                @elseif($product->category->name == 'Health & Beauty') category-health
                                @elseif($product->category->name == 'Toys') category-toys
                                @elseif($product->category->name == 'Automotive') category-automotive
                                @endif">
                                <i class="fas fa-{{ getCategoryIcon($product->category->name) }} fa-2x mb-2"></i>
                                <h5>{{ $product->category->name }}</h5>
                            </div>
                            <small class="text-muted">
                                {{ $product->category->products_count ?? 0 }} products in this category
                            </small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded bg-light">
                            <h6>New Category</h6>
                            <div class="category-badge-large my-3" id="newCategoryPreview">
                                <i class="fas fa-question fa-2x mb-2 text-muted"></i>
                                <h5 class="text-muted">Select a category</h5>
                            </div>
                            <small class="text-muted" id="newCategoryStats">
                                Select a category to see details
                            </small>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <small class="text-muted">
                        <i class="fas fa-lightbulb me-1"></i>
                        Changing categories helps organize products better in the system
                    </small>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Character counter for description
        const description = document.getElementById('description');
        const charCount = document.getElementById('charCount');
        
        if (description && charCount) {
            // Update count on load
            charCount.textContent = description.value.length;
            
            // Update count on input
            description.addEventListener('input', function() {
                charCount.textContent = this.value.length;
                if (this.value.length > 1000) {
                    charCount.classList.add('text-danger');
                } else {
                    charCount.classList.remove('text-danger');
                }
            });
        }
        
        // Form submission animation
        const form = document.getElementById('editProductForm');
        const submitBtn = document.getElementById('submitBtn');
        
        if (form && submitBtn) {
            form.addEventListener('submit', function(e) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';
                submitBtn.disabled = true;
            });
        }
        
        // Category change preview
        const categorySelect = document.getElementById('category_id');
        const newCategoryPreview = document.getElementById('newCategoryPreview');
        const newCategoryStats = document.getElementById('newCategoryStats');
        
        if (categorySelect && newCategoryPreview && newCategoryStats) {
            categorySelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const categoryName = selectedOption.text.split('\n')[0].trim();
                const categoryId = this.value;
                
                // Update preview
                const icons = {
                    'Electronics': 'laptop',
                    'Fashion': 'tshirt',
                    'Home & Garden': 'home',
                    'Books': 'book',
                    'Sports': 'futbol',
                    'Health & Beauty': 'spa',
                    'Toys': 'gamepad',
                    'Automotive': 'car'
                };
                
                const icon = icons[categoryName] || 'tag';
                const colorClass = getCategoryColorClass(categoryName);
                
                newCategoryPreview.innerHTML = `
                    <i class="fas fa-${icon} fa-2x mb-2"></i>
                    <h5>${categoryName}</h5>
                `;
                newCategoryPreview.className = `category-badge-large my-3 ${colorClass}`;
                
                // Update stats (you could fetch this via AJAX if you want real data)
                newCategoryStats.textContent = 'Category selected';
            });
        }
        
        // Auto-focus on first field
        document.getElementById('name').focus();
        
        function getCategoryColorClass(categoryName) {
            switch(categoryName) {
                case 'Electronics': return 'category-electronics';
                case 'Fashion': return 'category-fashion';
                case 'Home & Garden': return 'category-home';
                case 'Books': return 'category-books';
                case 'Sports': return 'category-sports';
                case 'Health & Beauty': return 'category-health';
                case 'Toys': return 'category-toys';
                case 'Automotive': return 'category-automotive';
                default: return '';
            }
        }
    });
</script>
@endpush
@endsection

@php
    // Helper function to get category icon
    function getCategoryIcon($categoryName) {
        switch($categoryName) {
            case 'Electronics': return 'laptop';
            case 'Fashion': return 'tshirt';
            case 'Home & Garden': return 'home';
            case 'Books': return 'book';
            case 'Sports': return 'futbol';
            case 'Health & Beauty': return 'spa';
            case 'Toys': return 'gamepad';
            case 'Automotive': return 'car';
            case 'Test Empty Category': return 'vial'; // Test tube icon for testing
            default: return 'tag';
        }
    }
@endphp