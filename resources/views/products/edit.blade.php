{{-- ! for testing --}}
{{-- @dd($product->suppliers)
@dd($product->suppliers_count) --}}

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
                        <span class="badge bg-warning">
                            <i class="fas fa-truck me-1"></i>{{ $product->suppliers_count }} suppliers
                        </span>
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

                    <!-- ========== FIXED: SUPPLIERS SECTION ========== -->
                    <div class="mb-4 border-top pt-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-warning rounded-circle p-2 me-3">
                                <i class="fas fa-truck text-white"></i>
                            </div>
                            <div>
                                <h4 class="mb-0">
                                    <i class="fas fa-truck me-2 text-warning"></i>Suppliers Management
                                    <span class="text-danger">*</span>
                                </h4>
                                <small class="text-muted">Update supplier relationships and pricing</small>
                            </div>
                        </div>

                        @error('suppliers')
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                            </div>
                        @enderror

                        <!-- Current Suppliers Summary -->
                        @if($product->suppliers_count > 0)
                        <div class="alert alert-warning mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Current Suppliers:</strong>
                                    <span class="badge bg-warning text-dark ms-2">{{ $product->suppliers_count }}</span>
                                </div>
                                <small>
                                    <i class="fas fa-sync-alt me-1"></i>
                                    Update below to modify supplier relationships
                                </small>
                            </div>
                            <div class="mt-2">
                                @foreach($product->suppliers as $supplier)
                                    <span class="badge bg-warning bg-opacity-10 text-warning border border-warning mb-1 me-1">
                                        <i class="fas fa-truck me-1"></i>{{ $supplier->name }}
                                        <small class="ms-1">
                                            (${{ number_format($supplier->pivot->cost_price, 2) }}, 
                                            {{ $supplier->pivot->lead_time_days }} days)
                                        </small>
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        @endif

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

                                <!-- Suppliers List - Changed to same layout as create page -->
                                <div class="suppliers-list">
                                    @foreach($suppliers as $supplier)
                                    @php
                                        $currentSupplier = $product->suppliers->where('id', $supplier->id)->first();
                                        $isSelected = old('suppliers.' . $supplier->id . '.selected') !== null ? 
                                                      old('suppliers.' . $supplier->id . '.selected') : 
                                                      ($currentSupplier ? true : false);
                                        $costPrice = old('suppliers.' . $supplier->id . '.cost_price', 
                                                      $currentSupplier ? $currentSupplier->pivot->cost_price : '0.00');
                                        $leadTime = old('suppliers.' . $supplier->id . '.lead_time_days', 
                                                     $currentSupplier ? $currentSupplier->pivot->lead_time_days : '0');
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
                                                        <small class="supplier-helper-text">
                                                            Supplier's price to you
                                                        </small>
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
                                                        <small class="supplier-helper-text">
                                                            Delivery time from this supplier
                                                        </small>
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
                        <a href="{{ route('products.show', $product) }}" 
                           class="btn btn-outline-info me-md-2">
                            <i class="fas fa-eye me-1"></i>View Product
                        </a>
                        <a href="{{ route('products.index') }}" 
                           class="btn btn-outline-secondary me-md-2">
                            <i class="fas fa-times me-1"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-warning" id="submitBtn">
                            <i class="fas fa-sync-alt me-1"></i>Update Product with Suppliers
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
                                    <strong><i class="fas fa-dollar-sign me-1 text-muted"></i>Price</strong><br>
                                    <span class="badge bg-success fs-6">${{ number_format($product->price, 2) }}</span>
                                </p>
                                <p class="mb-2">
                                    <strong><i class="fas fa-truck me-1 text-muted"></i>Suppliers</strong><br>
                                    <span class="badge bg-warning fs-6">{{ $product->suppliers->count() }}</span>                                    
                                </p>
                            </div>
                        </div>

                        <!-- Display Current Suppliers List -->
                        @if($product->suppliers && $product->suppliers->count() > 0)
                        <div class="mt-3 pt-3 border-top">
                            <strong><i class="fas fa-list me-1 text-muted"></i>Current Suppliers ({{ $product->suppliers->count() }}):</strong>
                            <div class="suppliers-list-small mt-1">
                                @foreach($product->suppliers as $supplier)
                                @php
                                    // Access pivot data correctly - it's stored in the original array
                                    $pivotData = $supplier->getOriginal();
                                    $costPrice = $pivotData['pivot_cost_price'] ?? $supplier->pivot->cost_price ?? 0;
                                    $leadTime = $pivotData['pivot_lead_time_days'] ?? $supplier->pivot->lead_time_days ?? 0;
                                @endphp
                                <div class="supplier-line-small d-flex justify-content-between align-items-center mb-1">
                                    <div class="supplier-name-small text-truncate me-2" style="max-width: 150px;">
                                        <i class="fas fa-truck fa-xs me-1 text-warning"></i>
                                        <small>{{ $supplier->name }}</small>
                                    </div>
                                    <div class="supplier-details-small text-muted">
                                        <small>
                                            <span class="text-success">${{ number_format($costPrice, 2) }}</span>
                                            <span class="mx-1">•</span>
                                            <span class="text-info">{{ $leadTime }}d</span>
                                        </small>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @else
                        <div class="mt-3 pt-3 border-top">
                            <strong><i class="fas fa-list me-1 text-muted"></i>Current Suppliers:</strong>
                            <div class="text-muted mt-1">
                                <small><i class="fas fa-exclamation-circle me-1"></i>No suppliers assigned to this product</small>
                            </div>
                        </div>
                        @endif

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
                                <i class="fas fa-check-circle text-warning me-2"></i>
                                <small>At least 1 supplier required</small>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <small>Price must be greater than $0.01</small>
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
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Character counter for description
        const description = document.getElementById('description');
        const charCount = document.getElementById('charCount');
        
        if (description && charCount) {
            charCount.textContent = description.value.length;
            description.addEventListener('input', function() {
                charCount.textContent = this.value.length;
                if (this.value.length > 1000) {
                    charCount.classList.add('text-danger');
                } else {
                    charCount.classList.remove('text-danger');
                }
            });
        }
        
        // Supplier checkbox toggle - UPDATED to match create page
        const checkboxes = document.querySelectorAll('.supplier-checkbox');
        const selectedCount = document.getElementById('selected_count');
        const selectedList = document.getElementById('selected_suppliers_list');

        function updateSelectedSuppliers() {
            const selected = Array.from(checkboxes).filter(cb => cb.checked);
            selectedCount.textContent = selected.length;
            
            if (selected.length > 0) {
                const names = selected.map(cb => {
                    const nameSpan = cb.closest('.form-check').querySelector('.supplier-name-text');
                    return nameSpan ? nameSpan.textContent.trim() : '';
                }).filter(name => name);
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
                    if (costDetails) costDetails.style.display = 'block';
                    if (leadDetails) leadDetails.style.display = 'block';
                    if (costInput) costInput.disabled = false;
                    if (leadInput) leadInput.disabled = false;
                    if (card) {
                        card.classList.add('border-warning');
                        card.classList.remove('border-light');
                    }
                } else {
                    if (costDetails) costDetails.style.display = 'none';
                    if (leadDetails) leadDetails.style.display = 'none';
                    if (costInput) costInput.disabled = true;
                    if (leadInput) leadInput.disabled = true;
                    if (card) {
                        card.classList.remove('border-warning');
                        card.classList.add('border-light');
                    }
                }
                
                updateSelectedSuppliers();
            });
            
            // Trigger change event on page load if checked
            if (checkbox.checked) {
                checkbox.dispatchEvent(new Event('change'));
            }
        });

        // Form submission validation
        const form = document.getElementById('editProductForm');
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
                    
                    if (costInput && (!costInput.value || parseFloat(costInput.value) <= 0)) {
                        e.preventDefault();
                        const nameSpan = cb.closest('.form-check').querySelector('.supplier-name-text');
                        alert(`Please enter a valid cost price for ${nameSpan ? nameSpan.textContent.trim() : 'selected supplier'}`);
                        if (costInput) costInput.focus();
                        hasErrors = true;
                        return false;
                    }
                    
                    if (leadInput && (!leadInput.value || parseInt(leadInput.value) < 0)) {
                        e.preventDefault();
                        const nameSpan = cb.closest('.form-check').querySelector('.supplier-name-text');
                        alert(`Please enter a valid lead time for ${nameSpan ? nameSpan.textContent.trim() : 'selected supplier'}`);
                        if (leadInput) leadInput.focus();
                        hasErrors = true;
                        return false;
                    }
                });
                
                if (hasErrors) return false;
                    
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';
                submitBtn.disabled = true;
            });
        }

        // Initialize on page load
        updateSelectedSuppliers();
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
            case 'Test Empty Category': return 'vial';
            default: return 'tag';
        }
    }
@endphp