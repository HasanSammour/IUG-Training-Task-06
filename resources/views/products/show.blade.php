@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="row fade-in">
    <div class="col-md-8">
        <!-- Product Details Card -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-box me-2"></i>Product Details
                    </h4>
                    <span class="badge bg-light text-dark fs-6">
                        ${{ number_format($product->price, 2) }}
                    </span>
                </div>
            </div>
            <div class="card-body">
                <h2 class="mb-3">{{ $product->name }}</h2>
                
                <div class="mb-4">
                    <h5><i class="fas fa-align-left me-2"></i>Description</h5>
                    @if($product->description)
                        <p class="lead">{{ $product->description }}</p>
                    @else
                        <p class="text-muted">No description available</p>
                    @endif
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6><i class="fas fa-id-card me-2"></i>Product ID</h6>
                                <h3>#{{ $product->id }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6><i class="fas fa-calendar-plus me-2"></i>Created Date</h6>
                                <h5>{{ $product->created_at->format('F d, Y') }}</h5>
                                <small class="text-muted">{{ $product->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <!-- Action Card -->
        <div class="card slide-in" style="animation-delay: 0.2s">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">
                    <i class="fas fa-cogs me-2"></i>Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-3">
                    <a href="{{ route('products.edit', $product) }}" 
                       class="btn btn-warning btn-lg">
                        <i class="fas fa-edit me-2"></i>Edit Product
                    </a>
                    
                    <form action="{{ route('products.destroy', $product) }}" 
                          method="POST" 
                          class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-lg">
                            <i class="fas fa-trash me-2"></i>Delete Product
                        </button>
                    </form>
                    
                    <a href="{{ route('products.index') }}" 
                       class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to List
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Quick Stats -->
        <div class="card mt-4 slide-in" style="animation-delay: 0.3s">
            <div class="card-body text-center">
                <i class="fas fa-box fa-4x text-primary mb-3"></i>
                <h5>Product #{{ $product->id }}</h5>
                <p class="text-muted">In database</p>
            </div>
        </div>
    </div>
</div>
@endsection