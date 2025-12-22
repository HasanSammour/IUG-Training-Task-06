@extends('layouts.app')

@section('title', $category->name . ' - Products')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('products.index') }}"><i class="fas fa-boxes"></i> Products</a></li>
    <li class="breadcrumb-item active"><i class="fas fa-folder"></i> {{ $category->name }} Category</li>
@endsection

@section('content')
<div class="fade-in">
    <!-- Category Header -->
    <div class="card mb-4 slide-in">
        <div class="card-header d-flex justify-content-between align-items-center
            @if($category->name == 'Electronics') bg-primary
            @elseif($category->name == 'Fashion') bg-danger
            @elseif($category->name == 'Home & Garden') bg-success
            @elseif($category->name == 'Books') bg-warning text-dark
            @elseif($category->name == 'Sports') bg-info
            @elseif($category->name == 'Health & Beauty') bg-purple
            @elseif($category->name == 'Toys') bg-teal
            @elseif($category->name == 'Automotive') bg-orange
            @elseif($category->name == 'Test Empty Category') bg-secondary
            @else bg-info @endif text-white">
            <div class="d-flex align-items-center">
                @switch($category->name)
                    @case('Electronics')<i class="fas fa-laptop fa-2x me-3"></i>@break
                    @case('Fashion')<i class="fas fa-tshirt fa-2x me-3"></i>@break
                    @case('Home & Garden')<i class="fas fa-home fa-2x me-3"></i>@break
                    @case('Books')<i class="fas fa-book fa-2x me-3"></i>@break
                    @case('Sports')<i class="fas fa-futbol fa-2x me-3"></i>@break
                    @case('Health & Beauty')<i class="fas fa-spa fa-2x me-3"></i>@break
                    @case('Toys')<i class="fas fa-gamepad fa-2x me-3"></i>@break
                    @case('Automotive')<i class="fas fa-car fa-2x me-3"></i>@break
                    @case('Test Empty Category')<i class="fas fa-vial fa-2x me-3"></i>@break
                    @default<i class="fas fa-tag fa-2x me-3"></i>@break
                @endswitch
                <div>
                    <h3 class="mb-0">{{ $category->name }}</h3>
                    <small>All Products in This Category</small>
                </div>
            </div>
            <div class="text-end">
                <span class="badge bg-light text-dark fs-5 px-3 py-2">
                    {{ $categoryStats['total_products'] }} Products
                </span>
            </div>
        </div>
        <div class="card-body">
            <!-- Category Statistics -->
            <div class="row mb-4">
                <div class="col-md-3 col-6 mb-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="fas fa-boxes text-primary fa-2x mb-2"></i>
                            <h4>{{ $categoryStats['total_products'] }}</h4>
                            <p class="text-muted mb-0">Total Products</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="fas fa-dollar-sign text-success fa-2x mb-2"></i>
                            <h4>${{ number_format($categoryStats['avg_price'], 2) }}</h4>
                            <p class="text-muted mb-0">Avg Price</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="fas fa-chart-line text-warning fa-2x mb-2"></i>
                            <h4>${{ number_format($categoryStats['total_value'], 2) }}</h4>
                            <p class="text-muted mb-0">Total Value</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="fas fa-tags text-info fa-2x mb-2"></i>
                            <h4>1 Category</h4>
                            <p class="text-muted mb-0">Current</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Back to All Products
                    </a>
                    <a href="{{ route('products.create') }}" class="btn btn-primary ms-2">
                        <i class="fas fa-plus me-1"></i>Add Product to {{ $category->name }}
                    </a>
                </div>
                <div class="text-muted">
                    <i class="fas fa-filter me-1"></i>
                    Filtered by: <strong>{{ $category->name }}</strong>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Products Table -->
    @if($products->count() > 0)
        <div class="card fade-in">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2"></i>Products in {{ $category->name }}
                    <small class="text-light">(Page {{ $products->currentPage() }} of {{ $products->lastPage() }})</small>
                </h5>
                <div class="text-light">
                    <i class="fas fa-chart-bar me-1"></i>
                    {{ $products->count() }} shown
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th width="5%">ID</th>
                                <th width="25%">Product Name</th>
                                <th width="15%">Price</th>
                                <th width="30%">Description</th>
                                <th width="15%">Created Date</th>
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
                                                <i class="fas fa-hashtag me-1"></i>
                                                ID: {{ $product->id }}
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
                                    @if($product->description)
                                        <div class="text-truncate" style="max-width: 250px;" 
                                             title="{{ $product->description }}">
                                            {{ Str::limit($product->description, 60) }}
                                        </div>
                                    @else
                                        <span class="text-muted"><i>No description</i></span>
                                    @endif
                                </td>
                                <td>
                                    <div class="text-muted">
                                        {{ $product->created_at->format('M d, Y') }}<br>
                                        <small>{{ $product->created_at->diffForHumans() }}</small>
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
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="card fade-in">
            <div class="card-body">
                <div class="text-center py-5">
                    <div class="mb-4">
                        @switch($category->name)
                            @case('Electronics')<i class="fas fa-laptop fa-4x text-primary mb-3"></i>@break
                            @case('Fashion')<i class="fas fa-tshirt fa-4x text-danger mb-3"></i>@break
                            @case('Home & Garden')<i class="fas fa-home fa-4x text-success mb-3"></i>@break
                            @case('Books')<i class="fas fa-book fa-4x text-warning mb-3"></i>@break
                            @case('Sports')<i class="fas fa-futbol fa-4x text-info mb-3"></i>@break
                            @case('Health & Beauty')<i class="fas fa-spa fa-4x text-purple mb-3"></i>@break
                            @case('Toys')<i class="fas fa-gamepad fa-4x text-teal mb-3"></i>@break
                            @case('Automotive')<i class="fas fa-car fa-4x text-orange mb-3"></i>@break
                            @case('Test Empty Category')<i class="fas fa-vial fa-4x text-secondary mb-3"></i>@break
                            @default<i class="fas fa-tag fa-4x text-secondary mb-3"></i>@break
                        @endswitch
                    </div>
                    <h4>No Products Found in {{ $category->name }}</h4>
                    <p class="text-muted mb-4">There are no products in this category yet.</p>
                    <a href="{{ route('products.create') }}" class="btn btn-primary pulse-animation me-2">
                        <i class="fas fa-plus me-2"></i>Add First Product
                    </a>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-boxes me-2"></i>Browse All Products
                    </a>
                </div>
            </div>
        </div>
    @endif
    

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add animation to table rows
        const tableRows = document.querySelectorAll('tbody tr');
        tableRows.forEach((row, index) => {
            row.style.animationDelay = `${index * 0.05}s`;
        });
        
        console.log('Category Products Page Loaded');
        console.log('Category: {{ $category->name }}');
        console.log('Total Products: {{ $categoryStats['total_products'] }}');
    });

    // Fix dropdown z-index issue on category products page
    document.addEventListener('DOMContentLoaded', function() {
        // Check if we're on the category products page
        if (window.location.pathname.match(/\/categories\/\d+\/products/)) {
            console.log('Fixing dropdown z-index on category products page...');

            // 1. Push category header card to back
            const categoryHeader = document.querySelector('.card.mb-4.slide-in');
            if (categoryHeader) {
                categoryHeader.style.zIndex = '5';
                categoryHeader.style.position = 'relative';
            }

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

            // 4. Lower z-index for statistics cards
            const statsCards = document.querySelectorAll('.row.mb-4 .card');
            statsCards.forEach(card => {
                card.style.zIndex = '5';
                card.style.position = 'relative';
            });

            // 5. Lower z-index for products table card
            const productsTable = document.querySelector('.card.fade-in');
            if (productsTable) {
                productsTable.style.zIndex = '10';
                productsTable.style.position = 'relative';
            }

            // 6. Lower z-index for action buttons section
            const actionButtons = document.querySelector('.d-flex.justify-content-between.align-items-center.mb-4');
            if (actionButtons) {
                actionButtons.style.zIndex = '5';
                actionButtons.style.position = 'relative';
            }

            // 7. Lower z-index for quick links card
            const quickLinks = document.querySelector('.row.mt-4 .card.fade-in');
            if (quickLinks) {
                quickLinks.style.zIndex = '5';
                quickLinks.style.position = 'relative';
            }

            // 8. Lower z-index for empty state card (if exists)
            const emptyState = document.querySelector('.card .card-body .text-center');
            if (emptyState && emptyState.querySelector('.fa-4x')) {
                const emptyStateCard = emptyState.closest('.card');
                if (emptyStateCard) {
                    emptyStateCard.style.zIndex = '5';
                    emptyStateCard.style.position = 'relative';
                }
            }

            // 9. Lower z-index for breadcrumb
            const breadcrumb = document.querySelector('nav[aria-label="breadcrumb"]');
            if (breadcrumb) {
                breadcrumb.style.zIndex = '5';
                breadcrumb.style.position = 'relative';
            }

            console.log('Category products page dropdown fix applied successfully');
        }
    });
</script>
@endpush
@endsection