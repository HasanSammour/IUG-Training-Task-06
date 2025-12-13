@extends('layouts.app')

@section('title', 'All Products')

@section('content')
<div class="fade-in">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="page-title">
                <i class="fas fa-boxes me-2"></i>Products Management
            </h2>
            <p class="text-muted mb-0">Total Products: <strong>{{ $products->count() }}</strong></p>
        </div>
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>Add New Product
        </a>
    </div>
    
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 col-6 mb-3">
            <div class="card text-center slide-in">
                <div class="card-body">
                    <i class="fas fa-box text-primary fa-2x mb-2"></i>
                    <h3>{{ $products->count() }}</h3>
                    <p class="text-muted mb-0">Total</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="card text-center slide-in" style="animation-delay: 0.1s">
                <div class="card-body">
                    <i class="fas fa-dollar-sign text-success fa-2x mb-2"></i>
                    <h3>${{ number_format($products->avg('price'), 2) }}</h3>
                    <p class="text-muted mb-0">Avg Price</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="card text-center slide-in" style="animation-delay: 0.2s">
                <div class="card-body">
                    <i class="fas fa-arrow-up text-warning fa-2x mb-2"></i>
                    <h3>${{ number_format($products->max('price'), 2) }}</h3>
                    <p class="text-muted mb-0">Highest</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="card text-center slide-in" style="animation-delay: 0.3s">
                <div class="card-body">
                    <i class="fas fa-arrow-down text-info fa-2x mb-2"></i>
                    <h3>${{ number_format($products->min('price'), 2) }}</h3>
                    <p class="text-muted mb-0">Lowest</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Products Table -->
    <div class="card fade-in">
        <div class="card-body">
            @if($products->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Description</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr class="slide-in" style="animation-delay: {{ $loop->index * 0.05 }}s">
                                <td><strong>#{{ $product->id }}</strong></td>
                                <td>
                                    <i class="fas fa-box text-primary me-2"></i>
                                    {{ $product->name }}
                                </td>
                                <td class="price-tag">${{ number_format($product->price, 2) }}</td>
                                <td>
                                    @if($product->description)
                                        {{ Str::limit($product->description, 50) }}
                                    @else
                                        <span class="text-muted">No description</span>
                                    @endif
                                </td>
                                <td>{{ $product->created_at->format('M d, Y') }}</td>
                                <td class="action-btns">
                                    <a href="{{ route('products.show', $product) }}" 
                                       class="btn btn-sm btn-info" 
                                       title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('products.edit', $product) }}" 
                                       class="btn btn-sm btn-warning"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('products.destroy', $product) }}" 
                                          method="POST" 
                                          class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-danger"
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-box-open fa-4x text-muted mb-4"></i>
                    <h4>No Products Found</h4>
                    <p class="text-muted mb-4">Start by adding your first product</p>
                    <a href="{{ route('products.create') }}" class="btn btn-primary pulse-animation">
                        <i class="fas fa-plus me-2"></i>Add First Product
                    </a>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Total Value -->
    @if($products->count() > 0)
    <div class="alert alert-info mt-3 fade-in">
        <i class="fas fa-calculator me-2"></i>
        Total Inventory Value: <strong>${{ number_format($products->sum('price'), 2) }}</strong>
    </div>
    @endif
</div>
@endsection