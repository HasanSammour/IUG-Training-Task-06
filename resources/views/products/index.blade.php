@extends('layouts.app')

@section('title', 'All Products')

@section('breadcrumb')
    @if(request()->has('page'))
        <li class="breadcrumb-item"><a href="{{ route('products.index') }}"><i class="fas fa-boxes"></i> Products</a></li>
        <li class="breadcrumb-item active">Page {{ request()->get('page') }}</li>
    @else
        <li class="breadcrumb-item active"><i class="fas fa-boxes"></i> Products</li>
    @endif
@endsection

@section('content')
<div class="fade-in">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="page-title">
                <i class="fas fa-boxes me-2"></i>Products Management
            </h2>
            <p class="text-muted mb-0">Total Products: <strong>{{ $products->total() }}</strong> 
                @if($products->total() > 10)
                    | Showing: <strong>{{ $products->firstItem() }}-{{ $products->lastItem() }}</strong>
                @endif
            </p>
        </div>
        <a href="{{ route('products.create') }}" class="btn btn-primary add_new">
            <i class="fas fa-plus me-1"></i>Add New Product
        </a>
    </div>
    
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 col-6 mb-3">
            <div class="card text-center slide-in">
                <div class="card-body">
                    <i class="fas fa-box text-primary fa-2x mb-2"></i>
                    <h3>{{ $products->total() }}</h3>
                    <p class="text-muted mb-0">Total Products</p>
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
                    <p class="text-muted mb-0">Highest Price</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="card text-center slide-in" style="animation-delay: 0.3s">
                <div class="card-body">
                    <i class="fas fa-arrow-down text-info fa-2x mb-2"></i>
                    <h3>${{ number_format($products->min('price'), 2) }}</h3>
                    <p class="text-muted mb-0">Lowest Price</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card fade-in">
                <div class="card-body py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-primary me-2">
                                <i class="fas fa-filter me-1"></i>10 per page
                            </span>
                            <span class="badge bg-info me-2">
                                <i class="fas fa-sort me-1"></i>Sorted by Latest
                            </span>
                        </div>
                        <div>
                            <span class="text-muted">
                                <i class="fas fa-clock me-1"></i>
                                Page loaded in {{ round((microtime(true) - LARAVEL_START) * 1000, 2) }}ms
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Products Table -->
    <div class="card fade-in">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i>Products List
                @if($products->total() > 10)
                    <small class="text-light">(Page {{ $products->currentPage() }} of {{ $products->lastPage() }})</small>
                @endif
            </h5>
            @if($products->total() > 0)
            <div class="text-light">
                <i class="fas fa-chart-bar me-1"></i>
                {{ $products->count() }} shown
            </div>
            @endif
        </div>
        <div class="card-body">
            @if($products->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th width="5%">ID</th>
                                <th width="25%">Name</th>
                                <th width="15%">Price</th>
                                <th width="20%">Category</th>
                                <th width="25%">Description</th>
                                <th width="10%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr class="slide-in" style="animation-delay: {{ $loop->index * 0.05 }}s">
                                <td>
                                    <span class="badge bg-secondary">#{{ $product->id }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-box text-primary me-2"></i>
                                        <div>
                                            <strong>{{ $product->name }}</strong>
                                            <div class="text-muted small">
                                                <i class="fas fa-calendar me-1"></i>
                                                {{ $product->created_at->format('M d, Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="price-tag">
                                    <span class="badge bg-success fs-6">
                                        ${{ number_format($product->price, 2) }}
                                    </span>
                                </td>
                                <td>
                                    @if($product->category)
                                        <span class="category-badge {{ 'category-' . strtolower(str_replace([' ', '&'], ['-', ''], $product->category->name)) }}">
                                            <i class="fas fa-tag me-1"></i>{{ $product->category->name }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-times me-1"></i>No Category
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($product->description)
                                        <div class="text-truncate" style="max-width: 200px;" 
                                             title="{{ $product->description }}">
                                            {{ Str::limit($product->description, 60) }}
                                        </div>
                                    @else
                                        <span class="text-muted"><i>No description</i></span>
                                    @endif
                                </td>
                                <td class="action-btns">
                                    <div class="btn-group" role="group">
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
                                              class="d-inline delete-form"
                                              data-product-name="{{ $product->name }}"
                                              data-product-id="{{ $product->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>                              
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($products->hasPages())
                <div class="row mt-4">
                    <div class="col-12">
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                {{-- Previous Page Link --}}
                                @if($products->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">
                                            <i class="fas fa-chevron-left"></i> Previous
                                        </span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $products->previousPageUrl() }}" rel="prev">
                                            <i class="fas fa-chevron-left"></i> Previous
                                        </a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach(range(1, $products->lastPage()) as $page)
                                    @if($page == $products->currentPage())
                                        <li class="page-item active">
                                            <span class="page-link">{{ $page }}</span>
                                        </li>
                                    @elseif($page <= 3 || $page > $products->lastPage() - 3 || abs($page - $products->currentPage()) <= 2)
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $products->url($page) }}">{{ $page }}</a>
                                        </li>
                                    @elseif($page == 4 && $products->currentPage() > 5)
                                        <li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li>
                                    @elseif($page == $products->lastPage() - 3 && $products->currentPage() < $products->lastPage() - 4)
                                        <li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if($products->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $products->nextPageUrl() }}" rel="next">
                                            Next <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link">
                                            Next <i class="fas fa-chevron-right"></i>
                                        </span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
                @endif
                
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
    
    <!-- Summary & Stats -->
    @if($products->count() > 0)
        <div class="row mt-4">
            <div class="col-12">
                <div class="alert alert-info fade-in">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div>
                                <i class="fas fa-calculator me-2"></i>
                                <strong>Page Summary:</strong>
                                Total Value: <strong>${{ number_format($products->sum('price'), 2) }}</strong> | 
                                Avg/Product: <strong>${{ number_format($products->avg('price'), 2) }}</strong>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end mt-2 mt-md-0">
                            <div>
                                <span class="badge bg-light text-dark me-2">
                                    <i class="fas fa-database me-1"></i>
                                    {{ $products->count() }} products
                                </span>
                                <span class="badge bg-light text-dark">
                                    <i class="fas fa-table me-1"></i>
                                    {{ $products->perPage() }} per page
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Quick Links -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card fade-in">
                <div class="card-body">
                    <h6><i class="fas fa-link me-2"></i>Quick Navigation</h6>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('products.index', ['page' => 1]) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-fast-backward me-1"></i>First Page
                        </a>
                        @if($products->currentPage() > 1)
                            <a href="{{ route('products.index', ['page' => $products->currentPage() - 1]) }}" 
                               class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-step-backward me-1"></i>Previous
                            </a>
                        @endif
                        @if($products->currentPage() < $products->lastPage())
                            <a href="{{ route('products.index', ['page' => $products->currentPage() + 1]) }}" 
                               class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-step-forward me-1"></i>Next
                            </a>
                        @endif
                        <a href="{{ route('products.index', ['page' => $products->lastPage()]) }}" 
                           class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-fast-forward me-1"></i>Last Page
                        </a>
                        <a href="{{ route('products.create') }}" class="btn btn-sm btn-success ms-auto">
                            <i class="fas fa-plus-circle me-1"></i>Add New Product
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-close alerts after 5 seconds
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                const closeBtn = alert.querySelector('.btn-close');
                if (closeBtn) closeBtn.click();
            });
        }, 5000);
        
        // Add animation to table rows
        const tableRows = document.querySelectorAll('tbody tr');
        tableRows.forEach((row, index) => {
            row.style.animationDelay = `${index * 0.05}s`;
        });
        
        // Pagination active state
        const currentPage = {{ $products->currentPage() }};
        console.log(`Current Page: ${currentPage}, Total Pages: {{ $products->lastPage() }}, Showing {{ $products->count() }} of {{ $products->total() }} products`);
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Only on products index page
        if (window.location.pathname === '/products' || window.location.pathname.startsWith('/products?')) {
            console.log('Fixing dropdown z-index on products page...');
            
            // 1. Push action cards to back (Total, Avg Price, Highest, Lowest cards)
            const actionCards = document.querySelectorAll('.card.text-center.slide-in');
            actionCards.forEach(card => {
                card.style.zIndex = '5';
                card.style.position = 'relative';
            });
            
            // 2. Push quick actions container to back
            const quickActions = document.querySelector('.card.fade-in .card-body.py-2');
            if (quickActions) {
                quickActions.parentElement.style.zIndex = '5';
                quickActions.parentElement.style.position = 'relative';
            }
            
            // 3. Push stats cards to back (Total Products, Avg Price, etc)
            const statsCards = document.querySelectorAll('.card.text-center');
            statsCards.forEach(card => {
                card.style.zIndex = '5';
                card.style.position = 'relative';
            });
            
            // 4. Push main table container to back but keep it functional
            const mainTableCard = document.querySelector('.card.fade-in');
            if (mainTableCard) {
                mainTableCard.style.zIndex = '10';
                mainTableCard.style.position = 'relative';
            }
            
            // 5. Push pagination container to back
            const paginationContainer = document.querySelector('.pagination');
            if (paginationContainer) {
                paginationContainer.parentElement.style.zIndex = '5';
                paginationContainer.parentElement.style.position = 'relative';
            }
            
            // 6. Push summary alerts to back
            const summaryAlerts = document.querySelectorAll('.alert.alert-info, .alert.alert-success');
            summaryAlerts.forEach(alert => {
                alert.style.zIndex = '5';
                alert.style.position = 'relative';
            });
            
            // 7. Push quick links card to back
            const quickLinks = document.querySelector('.card.fade-in .card-body:last-child');
            if (quickLinks && quickLinks.textContent.includes('Quick Navigation')) {
                quickLinks.parentElement.style.zIndex = '5';
                quickLinks.parentElement.style.position = 'relative';
            }
            
            // 8. Bring dropdown to front (MOST IMPORTANT)
            const dropdownMenu = document.querySelector('.dropdown-menu');
            if (dropdownMenu) {
                dropdownMenu.style.zIndex = '9999';
                dropdownMenu.style.position = 'absolute';
                dropdownMenu.style.boxShadow = '0 10px 30px rgba(0,0,0,0.3)';
            }
            
            // 9. Ensure navbar is properly positioned
            const navbar = document.querySelector('.navbar');
            if (navbar) {
                navbar.style.zIndex = '1000';
                navbar.style.position = 'relative';
            }
            
            // 10. Ensure "Add New Product" button stays clickable but behind dropdown
            const addProductBtn = document.querySelector('a[href*="/products/create"]');
            if (addProductBtn && addProductBtn.textContent.includes('Add')) {
                addProductBtn.style.zIndex = '10';
                addProductBtn.style.position = 'relative';
            }
        }
    });
</script>
@endpush
@endsection