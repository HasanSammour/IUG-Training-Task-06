@extends('layouts.app')

@section('title', 'Add Product')

@section('content')
<div class="row justify-content-center fade-in">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">
                    <i class="fas fa-plus-circle me-2"></i>Add New Product
                </h4>
            </div>
            <div class="card-body">
                <form action="{{ route('products.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">
                            <i class="fas fa-tag me-1"></i>Product Name
                        </label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}"
                               placeholder="Enter product name"
                               required>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="price" class="form-label">
                            <i class="fas fa-dollar-sign me-1"></i>Price
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" 
                                   step="0.01" 
                                   min="0"
                                   class="form-control @error('price') is-invalid @enderror" 
                                   id="price" 
                                   name="price" 
                                   value="{{ old('price') }}"
                                   placeholder="0.00"
                                   required>
                        </div>
                        @error('price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="description" class="form-label">
                            <i class="fas fa-align-left me-1"></i>Description
                        </label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="4"
                                  placeholder="Enter product description">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('products.index') }}" 
                           class="btn btn-secondary me-md-2">
                            <i class="fas fa-arrow-left me-1"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Save Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Tips Card -->
        <div class="card mt-4 slide-in" style="animation-delay: 0.2s">
            <div class="card-body">
                <h5><i class="fas fa-lightbulb text-warning me-2"></i>Tips:</h5>
                <ul class="mb-0">
                    <li>Product names should be descriptive and unique</li>
                    <li>Use decimal values for prices (e.g., 29.99)</li>
                    <li>Descriptions help customers understand your product</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection