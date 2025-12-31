@extends('layouts.app')

@section('title', 'Add Product')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('products.index') }}"><i class="fas fa-boxes"></i> Products</a></li>
    <li class="breadcrumb-item active"><i class="fas fa-plus-circle"></i> Add New Product</li>
@endsection

@section('content')
<div class="row justify-content-center fade-in">
    <div class="col-md-8">
        <!-- Main Form Card -->
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-plus-circle me-2"></i>Add New Product
                    </h4>
                    <span class="badge bg-light text-primary">
                        <i class="fas fa-exclamation-circle me-1"></i>All fields are required
                    </span>
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
                <form action="{{ route('products.store') }}" method="POST" id="createProductForm">
                    @csrf

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
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Enter product name (e.g., 'Laptop Pro 15')" required autofocus>
                        </div>
                        @error('name')
                            <div class="invalid-feedback d-block mt-2">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                        <small class="text-muted mt-1 d-block">
                            <i class="fas fa-info-circle me-1"></i>Must be unique. Max 255 characters.
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
                            <input type="number" step="0.01" min="0.01" max="999999.99" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" placeholder="0.00" required>
                            <span class="input-group-text bg-light">USD</span>
                        </div>
                        @error('price')
                            <div class="invalid-feedback d-block mt-2">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                        <small class="text-muted mt-1 d-block">
                            <i class="fas fa-info-circle me-1"></i>Must be greater than 0. Max $999,999.99
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
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                <option value="" disabled selected>Select a category</option>
                                @foreach($allCategories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }} data-icon="{{ getCategoryIcon($category->name) }}">
                                        {{ $category->name }}
                                        <span class="badge bg-light text-dark float-end">
                                            {{ $category->products_count ?? $category->products()->count() }} products
                                        </span>
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
                            Products are organized by categories for better management.
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
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Describe the product features, specifications, and benefits...">{{ old('description') }}</textarea>
                        </div>
                        @error('description')
                            <div class="invalid-feedback d-block mt-2">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                        <div class="d-flex justify-content-between mt-1">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>Optional but recommended
                            </small>
                            <small class="text-muted">
                                <span id="charCount">0</span> characters
                            </small>
                        </div>
                    </div>

                    <!-- ========== FIXED: SUPPLIERS SECTION ========== -->
                    <div class="mb-4 border-top pt-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-warning rounded-circle p-2 me-3">
                                <i class="fas fa-truck text-white"></i>
                            </div>
                            <div>
                                <h4 class="mb-0">
                                    <i class="fas fa-truck me-2 text-warning"></i>Suppliers Selection
                                    <span class="text-danger">*</span>
                                </h4>
                                <small class="text-muted">Select at least one supplier and enter their pricing and lead time</small>
                            </div>
                        </div>

                        @error('suppliers')
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                            </div>
                        @enderror

                        @if($suppliers && $suppliers->count() > 0)
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <!-- Supplier Selection Summary -->
                                <div class="alert alert-warning mb-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="fas fa-info-circle me-2"></i>
                                            <strong>Selected Suppliers:</strong>
                                            <span id="selected_count" class="badge bg-warning text-dark ms-2">0</span>
                                        </div>
                                        <small>
                                            <i class="fas fa-lightbulb me-1"></i>
                                            At least 1 supplier required
                                        </small>
                                    </div>
                                    <div id="selected_suppliers_list" class="mt-2">
                                        <small class="text-muted">No suppliers selected yet</small>
                                    </div>
                                </div>

                                <!-- Suppliers List -->
                                <div class="suppliers-list">
                                    @foreach($suppliers as $supplier)
                                    @php
                                        $isSelected = old('suppliers.' . $supplier->id . '.selected', false);
                                        $costPrice = old('suppliers.' . $supplier->id . '.cost_price', '0.00');
                                        $leadTime = old('suppliers.' . $supplier->id . '.lead_time_days', '0');
                                    @endphp
                                    <div class="supplier-item mb-3">
                                        <div class="card border {{ $isSelected ? 'border-warning' : 'border-light' }}">
                                            <div class="card-body p-3">
                                                <div class="row align-items-center">
                                                    <!-- Supplier Checkbox -->
                                                    <div class="col-md-4">
                                                        <div class="form-check">
                                                            <!-- Hidden input for unchecked state -->
                                                            <input type="hidden" name="suppliers[{{ $supplier->id }}][selected]" value="0">
                                                            
                                                            <input class="form-check-input supplier-checkbox" 
                                                                   type="checkbox" 
                                                                   id="supplier_{{ $supplier->id }}"
                                                                   name="suppliers[{{ $supplier->id }}][selected]"
                                                                   value="1"
                                                                   {{ $isSelected ? 'checked' : '' }}
                                                                   data-supplier-id="{{ $supplier->id }}">
                                                            <label class="form-check-label" for="supplier_{{ $supplier->id }}">
                                                                <div class="supplier-name-line">
                                                                    <i class="fas fa-truck me-2 text-warning"></i>
                                                                    <span class="supplier-name-text">{{ $supplier->name }}</span>
                                                                </div>
                                                                <div class="supplier-email-line">
                                                                    <i class="fas fa-envelope me-1"></i>
                                                                    <span class="supplier-email-text">{{ $supplier->email }}</span>
                                                                </div>
                                                            </label>
                                                        </div>
                                                        <!-- Hidden inputs for pivot data (always submit) -->
                                                        <input type="hidden" name="suppliers[{{ $supplier->id }}][cost_price]" value="0">
                                                        <input type="hidden" name="suppliers[{{ $supplier->id }}][lead_time_days]" value="0">
                                                    </div>
                                                    
                                                    <!-- Cost Price Input -->
                                                    <div class="col-md-4 supplier-details" 
                                                         id="cost_price_details_{{ $supplier->id }}"
                                                         style="{{ $isSelected ? '' : 'display: none;' }}">
                                                        <label for="cost_price_{{ $supplier->id }}" class="form-label small fw-bold">
                                                            <i class="fas fa-money-bill-wave me-1 text-success"></i>Cost Price
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text">$</span>
                                                            <input type="number" 
                                                                   step="0.01" 
                                                                   min="0"
                                                                   class="form-control form-control-sm @error('suppliers.' . $supplier->id . '.cost_price') is-invalid @enderror" 
                                                                   id="cost_price_{{ $supplier->id }}"
                                                                   name="suppliers[{{ $supplier->id }}][cost_price]"
                                                                   value="{{ $costPrice }}"
                                                                   placeholder="0.00"
                                                                   {{ $isSelected ? '' : 'disabled' }}>
                                                        </div>
                                                        @error('suppliers.' . $supplier->id . '.cost_price')
                                                            <div class="invalid-feedback d-block">
                                                                <small><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</small>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    
                                                    <!-- Lead Time Input -->
                                                    <div class="col-md-4 supplier-details" 
                                                         id="lead_time_details_{{ $supplier->id }}"
                                                         style="{{ $isSelected ? '' : 'display: none;' }}">
                                                        <label for="lead_time_{{ $supplier->id }}" class="form-label small fw-bold">
                                                            <i class="fas fa-clock me-1 text-info"></i>Lead Time
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <div class="input-group input-group-sm">
                                                            <input type="number" 
                                                                   min="0"
                                                                   max="365"
                                                                   class="form-control form-control-sm @error('suppliers.' . $supplier->id . '.lead_time_days') is-invalid @enderror" 
                                                                   id="lead_time_{{ $supplier->id }}"
                                                                   name="suppliers[{{ $supplier->id }}][lead_time_days]"
                                                                   value="{{ $leadTime }}"
                                                                   placeholder="0"
                                                                   {{ $isSelected ? '' : 'disabled' }}>
                                                            <span class="input-group-text">days</span>
                                                        </div>
                                                        @error('suppliers.' . $supplier->id . '.lead_time_days')
                                                            <div class="invalid-feedback d-block">
                                                                <small><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</small>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="alert alert-warning">
                            <div class="text-center py-3">
                                <i class="fas fa-truck fa-2x mb-3"></i>
                                <h5>No Suppliers Available</h5>
                                <p class="text-muted">Please run the SupplierSeeder to add suppliers to the database.</p>
                            </div>
                        </div>
                        @endif
                    </div>
                    <!-- ========== END SUPPLIERS SECTION ========== -->

                    <!-- Form Actions -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4 pt-3 border-top">
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary me-md-2">
                            <i class="fas fa-arrow-left me-1"></i>Back to Products
                        </a>
                        <button type="reset" class="btn btn-outline-warning me-md-2" id="resetBtn">
                            <i class="fas fa-redo me-1"></i>Reset Form
                        </button>
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="fas fa-save me-1"></i>Save Product with Suppliers
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Category Information Card -->
        <div class="card mt-4 shadow-sm slide-in">
            <div class="card-header bg-info text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-tags me-2"></i>All Product Categories
                    </h5>
                    <div>
                        <span class="badge bg-light text-dark me-2">
                            <i class="fas fa-layer-group me-1"></i>
                            {{ $categories->total() }} total
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($categories->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="15%">Icon</th>
                                    <th>Category Name</th>
                                    <th width="20%">Products</th>
                                    <th width="15%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td class="text-center">
                                            @if($category->name == 'Electronics')
                                                <i class="fas fa-laptop fa-2x text-primary"></i>
                                            @elseif($category->name == 'Fashion')
                                                <i class="fas fa-tshirt fa-2x text-danger"></i>
                                            @elseif($category->name == 'Home & Garden')
                                                <i class="fas fa-home fa-2x text-success"></i>
                                            @elseif($category->name == 'Books')
                                                <i class="fas fa-book fa-2x text-warning"></i>
                                            @elseif($category->name == 'Sports')
                                                <i class="fas fa-futbol fa-2x text-info"></i>
                                            @elseif($category->name == 'Health & Beauty')
                                                <i class="fas fa-spa fa-2x text-purple"></i>
                                            @elseif($category->name == 'Toys')
                                                <i class="fas fa-gamepad fa-2x text-teal"></i>
                                            @elseif($category->name == 'Automotive')
                                                <i class="fas fa-car fa-2x text-orange"></i>
                                            @elseif($category->name == 'Test Empty Category')
                                                <i class="fas fa-vial fa-2x text-secondary"></i>
                                            @else
                                                <i class="fas fa-tag fa-2x text-info"></i>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $category->name }}</strong><br>
                                            <small class="text-muted">
                                                ID: {{ $category->id }}
                                            </small>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="me-3">
                                                    <span class="badge 
                                                        @if($category->products_count == 0) bg-secondary
                                                        @elseif($category->products_count <= 5) bg-success
                                                        @elseif($category->products_count <= 10) bg-info
                                                        @elseif($category->products_count <= 20) bg-warning
                                                        @else bg-danger @endif fs-6">
                                                        @if($category->products_count == 0)
                                                            <i class="fas fa-exclamation-circle me-1"></i>No products yet
                                                        @elseif($category->products_count == 1)
                                                            <i class="fas fa-box me-1"></i> {{ $category->products_count }} product
                                                        @else
                                                            <i class="fas fa-boxes me-1"></i> {{ $category->products_count }} products
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('categories.products.show', ['category' => $category->id]) }}" class="btn btn-sm btn-outline-primary" title="View products in this category">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-info"
                                                        data-bs-toggle="popover" 
                                                        data-bs-html="true"
                                                        data-bs-placement="right"
                                                        data-bs-custom-class="category-popover"
                                                        data-bs-title="
                                                            <div class='d-flex align-items-center'>
                                                                @if($category->name == 'Electronics')
                                                                    <i class='fas fa-laptop me-2' style='color: #007bff;'></i>
                                                                @elseif($category->name == 'Fashion')
                                                                    <i class='fas fa-tshirt me-2' style='color: #dc3545;'></i>
                                                                @elseif($category->name == 'Home & Garden')
                                                                    <i class='fas fa-home me-2' style='color: #28a745;'></i>
                                                                @elseif($category->name == 'Books')
                                                                    <i class='fas fa-book me-2' style='color: #ffc107;'></i>
                                                                @elseif($category->name == 'Sports')
                                                                    <i class='fas fa-futbol me-2' style='color: #17a2b8;'></i>
                                                                @elseif($category->name == 'Health & Beauty')
                                                                    <i class='fas fa-spa me-2' style='color: #6f42c1;'></i>
                                                                @elseif($category->name == 'Toys')
                                                                    <i class='fas fa-gamepad me-2' style='color: #20c997;'></i>
                                                                @elseif($category->name == 'Automotive')
                                                                    <i class='fas fa-car me-2' style='color: #fd7e14;'></i>
                                                                @elseif($category->name == 'Test Empty Category')
                                                                    <i class='fas fa-vial me-2' style='color: #6c757d;'></i>
                                                                @else
                                                                    <i class='fas fa-tag me-2' style='color: #17a2b8;'></i>
                                                                @endif
                                                                <span>{{ $category->name }}</span>
                                                            </div>
                                                        "
                                                        data-bs-content="
                                                            <div class='category-popover-content'>
                                                                <div class='row g-2 mb-3'>
                                                                    <div class='col-6'>
                                                                        <div class='info-card 
                                                                            @if($category->name == 'Electronics') bg-primary-light border-primary
                                                                            @elseif($category->name == 'Fashion') bg-danger-light border-danger
                                                                            @elseif($category->name == 'Home & Garden') bg-success-light border-success
                                                                            @elseif($category->name == 'Books') bg-warning-light border-warning
                                                                            @elseif($category->name == 'Sports') bg-info-light border-info
                                                                            @elseif($category->name == 'Health & Beauty') bg-purple-light border-purple
                                                                            @elseif($category->name == 'Toys') bg-teal-light border-teal
                                                                            @elseif($category->name == 'Automotive') bg-orange-light border-orange
                                                                            @elseif($category->name == 'Test Empty Category') bg-secondary-light border-secondary
                                                                            @else bg-secondary-light border-secondary @endif'>
                                                                            <div class='display-6 
                                                                                @if($category->name == 'Electronics') text-primary
                                                                                @elseif($category->name == 'Fashion') text-danger
                                                                                @elseif($category->name == 'Home & Garden') text-success
                                                                                @elseif($category->name == 'Books') text-warning
                                                                                @elseif($category->name == 'Sports') text-info
                                                                                @elseif($category->name == 'Health & Beauty') text-purple
                                                                                @elseif($category->name == 'Toys') text-teal
                                                                                @elseif($category->name == 'Automotive') text-orange
                                                                                @elseif($category->name == 'Test Empty Category') text-secondary
                                                                                @else text-secondary @endif'>
                                                                                {{ $category->products_count ?? 0 }}
                                                                            </div>
                                                                            <div class='text-muted small'>Products</div>
                                                                        </div>
                                                                    </div>
                                                                    <div class='col-6'>
                                                                        <div class='info-card bg-light border'>
                                                                            <div class='display-6 text-dark'>#{{ $category->id }}</div>
                                                                            <div class='text-muted small'>Category ID</div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                @if($category->description)
                                                                    <div class='description-section'>
                                                                        <div class='section-label'>Description</div>
                                                                        <p class='mb-0'>{{ Str::limit($category->description, 100) }}</p>
                                                                    </div>
                                                                @endif

                                                                <div class='mt-3'>
                                                                    <div class='section-label'>Created</div>
                                                                    <div class='text-muted'>{{ $category->created_at->format('M d, Y') }}</div>
                                                                </div>

                                                                <div class='popover-actions mt-4'>
                                                                    <a href='{{ route('categories.products.show', $category) }}' 
                                                                       class='btn btn-sm w-100 
                                                                        @if($category->name == 'Electronics') btn-primary
                                                                        @elseif($category->name == 'Fashion') btn-danger
                                                                        @elseif($category->name == 'Home & Garden') btn-success
                                                                        @elseif($category->name == 'Books') btn-warning
                                                                        @elseif($category->name == 'Sports') btn-info
                                                                        @elseif($category->name == 'Health & Beauty') btn-purple
                                                                        @elseif($category->name == 'Toys') btn-teal
                                                                        @elseif($category->name == 'Automotive') btn-orange
                                                                        @elseif($category->name == 'Test Empty Category') btn-secondary
                                                                        @else btn-info @endif'>
                                                                        <i class='fas fa-eye me-1'></i>View Products
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        "
                                                        title="Category Info">
                                                    <i class="fas fa-info-circle"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($categories->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div class="text-muted">
                                Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }}
                                of {{ $categories->total() }} categories
                            </div>
                            <nav aria-label="Category pagination">
                                <ul class="pagination pagination-sm mb-0">
                                    {{-- Previous Page Link --}}
                                    @if($categories->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link">
                                                <i class="fas fa-chevron-left"></i>
                                            </span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $categories->previousPageUrl() }}">
                                                <i class="fas fa-chevron-left"></i>
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach(range(1, $categories->lastPage()) as $page)
                                        @if($page == $categories->currentPage())
                                            <li class="page-item active">
                                                <span class="page-link">{{ $page }}</span>
                                            </li>
                                        @elseif($page <= 3 || $page> $categories->lastPage() - 3 || abs($page - $categories->currentPage()) <= 2)
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $categories->url($page) }}">{{ $page }}</a>
                                                </li>
                                        @endif
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if($categories->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $categories->nextPageUrl() }}">
                                                <i class="fas fa-chevron-right"></i>
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link">
                                                <i class="fas fa-chevron-right"></i>
                                            </span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                        <h5>No Categories Found</h5>
                        <p class="text-muted">Create your first category to get started</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Validation Rules Card -->
        <div class="card mt-4 shadow-sm slide-in">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="fas fa-clipboard-check me-2 text-success"></i>Validation Rules
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-success bg-opacity-10 p-2 rounded me-3">
                                <i class="fas fa-check text-success"></i>
                            </div>
                            <div>
                                <h6>Product Name</h6>
                                <small class="text-muted">Required, unique, max 255 characters</small>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-success bg-opacity-10 p-2 rounded me-3">
                                <i class="fas fa-check text-success"></i>
                            </div>
                            <div>
                                <h6>Category</h6>
                                <small class="text-muted">Required, must exist in categories table</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-success bg-opacity-10 p-2 rounded me-3">
                                <i class="fas fa-check text-success"></i>
                            </div>
                            <div>
                                <h6>Price</h6>
                                <small class="text-muted">Required, numeric, min 0.01</small>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-warning bg-opacity-10 p-2 rounded me-3">
                                <i class="fas fa-check text-warning"></i>
                            </div>
                            <div>
                                <h6>Suppliers</h6>
                                <small class="text-muted">At least 1 required with cost & lead time</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

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

        // Supplier checkbox toggle
        const checkboxes = document.querySelectorAll('.supplier-checkbox');
        const selectedCount = document.getElementById('selected_count');
        const selectedList = document.getElementById('selected_suppliers_list');

        // Update selected suppliers list
        function updateSelectedSuppliers() {
            const selected = Array.from(checkboxes).filter(cb => cb.checked);
            selectedCount.textContent = selected.length;
                
            if (selected.length > 0) {
                const names = selected.map(cb => {
                    const label = cb.closest('.form-check').querySelector('.form-check-label');
                    return label.textContent.trim();
                });
                selectedList.innerHTML = names.map(name => 
                    `<span class="badge bg-warning text-dark me-1 mb-1">${name}</span>`
                ).join('');
            } else {
                selectedList.innerHTML = '<small class="text-muted">No suppliers selected yet</small>';
            }
        }

        // Toggle supplier details visibility and enable/disable inputs
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const supplierId = this.dataset.supplierId;
                const costDetails = document.getElementById(`cost_price_details_${supplierId}`);
                const leadDetails = document.getElementById(`lead_time_details_${supplierId}`);
                const costInput = document.getElementById(`cost_price_${supplierId}`);
                const leadInput = document.getElementById(`lead_time_${supplierId}`);
                const card = this.closest('.card');
                
                if (this.checked) {
                    costDetails.style.display = 'block';
                    leadDetails.style.display = 'block';
                    costInput.disabled = false;
                    leadInput.disabled = false;
                    costInput.required = true;
                    leadInput.required = true;
                    card.classList.add('border-warning');
                    card.classList.remove('border-light');
                    
                    // Focus on cost price input
                    setTimeout(() => costInput.focus(), 100);
                } else {
                    costDetails.style.display = 'none';
                    leadDetails.style.display = 'none';
                    costInput.disabled = true;
                    leadInput.disabled = true;
                    costInput.required = false;
                    leadInput.required = false;
                    card.classList.remove('border-warning');
                    card.classList.add('border-light');
                }
                    
                updateSelectedSuppliers();
            });
                
            // Trigger change event on page load if checked
            if (checkbox.checked) {
                checkbox.dispatchEvent(new Event('change'));
            }
        });

        // Form submission validation
        const form = document.getElementById('createProductForm');
        const submitBtn = document.getElementById('submitBtn');

        if (form && submitBtn) {
            form.addEventListener('submit', function(e) {
                // Validate at least one supplier is selected
                const selectedSuppliers = Array.from(checkboxes).filter(cb => cb.checked);
                if (selectedSuppliers.length === 0) {
                    e.preventDefault();
                    alert('Please select at least one supplier.');
                    return false;
                }
                    
                // Validate all selected suppliers have valid pivot data
                let hasErrors = false;
                selectedSuppliers.forEach(cb => {
                    const supplierId = cb.dataset.supplierId;
                    const costInput = document.getElementById(`cost_price_${supplierId}`);
                    const leadInput = document.getElementById(`lead_time_${supplierId}`);
                    
                    if (!costInput.value || parseFloat(costInput.value) <= 0) {
                        e.preventDefault();
                        alert(`Please enter a valid cost price for ${cb.closest('.form-check').querySelector('.form-check-label').textContent.trim()}`);
                        costInput.focus();
                        hasErrors = true;
                        return false;
                    }
                    
                    if (!leadInput.value || parseInt(leadInput.value) < 0) {
                        e.preventDefault();
                        alert(`Please enter a valid lead time for ${cb.closest('.form-check').querySelector('.form-check-label').textContent.trim()}`);
                        leadInput.focus();
                        hasErrors = true;
                        return false;
                    }
                });
                
                if (hasErrors) return false;
                    
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Saving...';
                submitBtn.disabled = true;
            });
        }

        // Reset button
        const resetBtn = document.getElementById('resetBtn');
        if (resetBtn) {
            resetBtn.addEventListener('click', function() {
                charCount.textContent = '0';
                checkboxes.forEach(cb => {
                    cb.checked = false;
                    cb.dispatchEvent(new Event('change'));
                });
                updateSelectedSuppliers();
            });
        }

        // Auto-focus on first field
        document.getElementById('name').focus();

        // Initialize on page load
        updateSelectedSuppliers();

        // Initialize popovers
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl, {
                trigger: 'click',
                html: true,
                sanitize: false,
                customClass: 'category-popover',
                offset: [0, 10]
            });
        });
    });
</script>
@endpush

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
            case 'Test Empty Category': return 'vial';
            default: return 'tag';
        }
    }
@endphp