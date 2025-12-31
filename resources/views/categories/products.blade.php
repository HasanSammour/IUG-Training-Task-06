@extends('layouts.app')

@section('title', $category->name . ' - Products')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('products.index') }}"><i class="fas fa-boxes"></i> Products</a></li>
    <li class="breadcrumb-item active"><i class="fas fa-folder"></i> {{ $category->name }} Category</li>
@endsection

@section('content')
@php
    // Calculate additional statistics using the shared data from View Composer
    $productsWithSuppliers = [];
    
    if(isset($allProducts)) {
        foreach($allProducts as $product) {
            if($product->suppliers && $product->suppliers->count() > 0) {
                $productTotalSuppliers = $product->suppliers->count();
                $productCostPrices = collect();
                $productLeadTimes = collect();
                
                foreach($product->suppliers as $supplier) {
                    $productCostPrices->push($supplier->pivot->cost_price ?? 0);
                    $productLeadTimes->push($supplier->pivot->lead_time_days ?? 0);
                }
                
                // Calculate product efficiency
                $productMaxCost = $productCostPrices->max() ?: 1;
                $productMaxLead = $productLeadTimes->max() ?: 1;
                $productEfficiency = 0;
                
                foreach($product->suppliers as $supplier) {
                    $cost = $supplier->pivot->cost_price ?? 0;
                    $lead = $supplier->pivot->lead_time_days ?? 0;
                    $efficiency = 100 - (($cost/$productMaxCost * 50) + ($lead/$productMaxLead * 50));
                    $productEfficiency = max($productEfficiency, $efficiency);
                }
                
                $productsWithSuppliers[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'suppliers_count' => $productTotalSuppliers,
                    'efficiency' => $productEfficiency
                ];
            }
        }
    }
    
    // Calculate category efficiency
    $bestEfficiency = 0;
    if(isset($costPrices) && $costPrices->count() > 0 && isset($leadTimes) && $leadTimes->count() > 0) {
        $maxCost = $costPrices->max() ?: 1;
        $maxLead = $leadTimes->max() ?: 1;
        
        foreach($suppliersData ?? [] as $data) {
            $efficiency = 100 - (($data['cost_price']/$maxCost * 50) + ($data['lead_time_days']/$maxLead * 50));
            if ($efficiency > $bestEfficiency) {
                $bestEfficiency = $efficiency;
            }
        }
    }
    
    // Find most efficient product
    $mostEfficientProduct = null;
    if(count($productsWithSuppliers) > 0) {
        $mostEfficientProduct = collect($productsWithSuppliers)->sortByDesc('efficiency')->first();
    }
    
    // Find suppliers with min and max cost
    $minCostSuppliers = collect($suppliersData ?? [])->filter(function($item) use ($costPrices) {
        return isset($costPrices) && $item['cost_price'] == $costPrices->min();
    });
    
    $maxCostSuppliers = collect($suppliersData ?? [])->filter(function($item) use ($costPrices) {
        return isset($costPrices) && $item['cost_price'] == $costPrices->max();
    });
@endphp

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
                <span class="badge bg-warning ms-2 fs-5 px-3 py-2">
                    <i class="fas fa-truck me-1"></i>{{ $totalSuppliers ?? 0 }} Suppliers
                </span>
            </div>
        </div>
        
        <div class="card-body">
            <!-- Supplier Statistics Cards - 3 columns, 2 rows -->
            @if(($totalSuppliers ?? 0) > 0)
            <div class="row mb-4">
                <!-- Row 1 -->
                
                <!-- Card 1: Products in Category -->
                <div class="col-md-4 col-6 mb-3">
                    <div class="bg-white p-3 rounded border h-100">
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                                <i class="fas fa-boxes text-primary"></i>
                            </div>
                            <div>
                                <div class="h4 mb-0">{{ $categoryStats['total_products'] }}</div>
                                <small class="supplier-helper-text">Products in Category</small>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="button" 
                                    class="btn btn-sm btn-outline-primary wide-popover-btn" 
                                    data-bs-toggle="popover" 
                                    data-bs-html="true"
                                    data-bs-title="All {{ $categoryStats['total_products'] }} Products in {{ $category->name }}"
                                    data-bs-content="@foreach($allProducts as $product)&bull; {{ $product->name }}<br>@endforeach">
                                <i class="fas fa-info-circle me-1"></i>View All
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Card 2: Total Suppliers -->
                <div class="col-md-4 col-6 mb-3">
                    <div class="bg-white p-3 rounded border h-100">
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-2">
                                <i class="fas fa-truck text-warning"></i>
                            </div>
                            <div>
                                <div class="h4 mb-0">{{ $totalSuppliers ?? 0 }}</div>
                                <small class="supplier-helper-text">Total Suppliers</small>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="button" 
                                    class="btn btn-sm btn-outline-warning wide-popover-btn" 
                                    data-bs-toggle="popover" 
                                    data-bs-html="true"
                                    data-bs-title="All {{ $totalSuppliers ?? 0 }} Suppliers in {{ $category->name }}"
                                    data-bs-content="@foreach($suppliersData as $data)&bull; {{ $data['supplier_name'] }} ({{ $data['product_name'] }})<br>@endforeach">
                                <i class="fas fa-info-circle me-1"></i>View All
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Card 3: Min Cost -->
                <div class="col-md-4 col-6 mb-3">
                    <div class="bg-white p-3 rounded border h-100">
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-success bg-opacity-10 rounded-circle p-2 me-2">
                                <i class="fas fa-dollar-sign text-success"></i>
                            </div>
                            <div>
                                <div class="h4 mb-0">${{ number_format(($costPrices->min() ?? 0), 2) }}</div>
                                <small class="supplier-helper-text">Min Cost</small>
                            </div>
                        </div>
                        @if(($minCostSuppliers->count() ?? 0) > 0)
                        <div class="mt-2">
                            <button type="button" 
                                    class="btn btn-sm btn-outline-success wide-popover-btn" 
                                    data-bs-toggle="popover" 
                                    data-bs-html="true"
                                    data-bs-title="Lowest Cost Suppliers"
                                    data-bs-content="@foreach($minCostSuppliers as $supplier)&bull; {{ $supplier['supplier_name'] }} ({{ $supplier['product_name'] }})<br>@endforeach">
                                <i class="fas fa-info-circle me-1"></i>View All
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Row 2 -->
                
                <!-- Card 4: Max Cost -->
                <div class="col-md-4 col-6 mb-3">
                    <div class="bg-white p-3 rounded border h-100">
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-danger bg-opacity-10 rounded-circle p-2 me-2">
                                <i class="fas fa-dollar-sign text-danger"></i>
                            </div>
                            <div>
                                <div class="h4 mb-0">${{ number_format(($costPrices->max() ?? 0), 2) }}</div>
                                <small class="supplier-helper-text">Max Cost</small>
                            </div>
                        </div>
                        @if(($maxCostSuppliers->count() ?? 0) > 0)
                        <div class="mt-2">
                            <button type="button" 
                                    class="btn btn-sm btn-outline-danger wide-popover-btn" 
                                    data-bs-toggle="popover" 
                                    data-bs-html="true"
                                    data-bs-title="Highest Cost Suppliers"
                                    data-bs-content="@foreach($maxCostSuppliers as $supplier)&bull; {{ $supplier['supplier_name'] }} ({{ $supplier['product_name'] }})<br>@endforeach">
                                <i class="fas fa-info-circle me-1"></i>View All
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Card 5: Best Efficiency -->
                <div class="col-md-4 col-6 mb-3">
                    <div class="bg-white p-3 rounded border h-100">
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-indigo bg-opacity-10 rounded-circle p-2 me-2">
                                <i class="fas fa-trophy text-indigo"></i>
                            </div>
                            <div>
                                <div class="h4 mb-0">{{ number_format($bestEfficiency, 0) }}%</div>
                                <small class="supplier-helper-text">Best Efficiency</small>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="button" 
                                    class="btn btn-sm btn-outline-indigo wide-popover-btn" 
                                    data-bs-toggle="popover" 
                                    data-bs-html="true"
                                    data-bs-title="Category Efficiency Score"
                                    data-bs-content="Combined efficiency score for {{ $category->name }} based on cost and lead time across all {{ $totalSuppliers ?? 0 }} suppliers.">
                                <i class="fas fa-info-circle me-1"></i>Info
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Card 6: Most Efficient Product -->
                <div class="col-md-4 col-6 mb-3">
                    <div class="bg-white p-3 rounded border h-100">
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-teal bg-opacity-10 rounded-circle p-2 me-2">
                                <i class="fas fa-star text-teal"></i>
                            </div>
                            <div>
                                @if($mostEfficientProduct)
                                    <div class="h5 mb-1">{{ Str::limit($mostEfficientProduct['product_name'], 20) }}</div>
                                    <small class="supplier-helper-text">{{ number_format($mostEfficientProduct['efficiency'], 0) }}% Efficiency</small>
                                @else
                                    <div class="h5 mb-1">No Data</div>
                                    <small class="supplier-helper-text">No efficient product found</small>
                                @endif
                            </div>
                        </div>
                        @if($mostEfficientProduct)
                        <div class="mt-2">
                            <button type="button" 
                                    class="btn btn-sm btn-outline-teal wide-popover-btn" 
                                    data-bs-toggle="popover" 
                                    data-bs-html="true"
                                    data-bs-title="Most Efficient Product"
                                    data-bs-content="<strong>{{ $mostEfficientProduct['product_name'] }}</strong><br>Efficiency: {{ number_format($mostEfficientProduct['efficiency'], 0) }}%<br>Suppliers: {{ $mostEfficientProduct['suppliers_count'] }}">
                                <i class="fas fa-info-circle me-1"></i>Details
                            </button>
                            @if($mostEfficientProduct['product_id'])
                            <a href="{{ route('products.show', $mostEfficientProduct['product_id']) }}" 
                               class="btn btn-sm btn-teal ms-1" title="View Product">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Action Buttons -->
            <div class="d-flex justify-content-between align-items-center">
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
    
    <!-- Products Table - Using paginated $products from controller -->
    @if($products->count() > 0)
        <div class="card fade-in">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2"></i>Products in {{ $category->name }}
                    <small class="text-light">(Page {{ $products->currentPage() }} of {{ $products->lastPage() }})</small>
                </h5>
                <div class="text-light">
                    <i class="fas fa-chart-bar me-1"></i>
                    {{ $products->count() }} shown of {{ $categoryStats['total_products'] }} total
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th width="5%">ID</th>
                                <th width="30%">Product Name</th>
                                <th width="15%">Price</th>
                                <th width="15%">Suppliers</th>
                                <th width="25%">Supplier Details</th>
                                <th width="10%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            @php
                                $productSuppliersCount = $product->suppliers ? $product->suppliers->count() : 0;
                                
                                // Calculate product supplier statistics
                                $productCostPrices = collect();
                                $productLeadTimes = collect();
                                $productSuppliersData = [];
                                
                                if($productSuppliersCount > 0) {
                                    foreach($product->suppliers as $supplier) {
                                        $cost = $supplier->pivot->cost_price ?? 0;
                                        $lead = $supplier->pivot->lead_time_days ?? 0;
                                        
                                        $productCostPrices->push($cost);
                                        $productLeadTimes->push($lead);
                                        
                                        $productSuppliersData[] = [
                                            'name' => $supplier->name,
                                            'cost' => $cost,
                                            'lead_time' => $lead,
                                            'email' => $supplier->email
                                        ];
                                    }
                                }
                            @endphp
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
                                <td>
                                    <span class="badge bg-success fs-6">
                                        ${{ number_format($product->price, 2) }}
                                    </span>
                                </td>
                                <td>
                                    @if($productSuppliersCount > 0)
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-truck me-1"></i>{{ $productSuppliersCount }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-truck me-1"></i>0
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($productSuppliersCount > 0)
                                        <div class="supplier-info">
                                            <div class="mb-1">
                                                <strong>Min Cost:</strong> 
                                                <span class="badge bg-success">${{ number_format($productCostPrices->min(), 2) }}</span>
                                            </div>
                                            <div class="mb-1">
                                                <strong>Max Cost:</strong> 
                                                <span class="badge bg-danger">${{ number_format($productCostPrices->max(), 2) }}</span>
                                            </div>
                                            <div>
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-info wide-popover-btn" 
                                                        data-bs-toggle="popover" 
                                                        data-bs-html="true"
                                                        data-bs-title="Suppliers for {{ $product->name }}"
                                                        data-bs-content="@foreach($productSuppliersData as $supplier)&bull; {{ $supplier['name'] }} - ${{ number_format($supplier['cost'], 2) }} ({{ $supplier['lead_time'] }} days)<br>@endforeach">
                                                    <i class="fas fa-info-circle me-1"></i>View All
                                                </button>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            No suppliers
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('products.show', $product) }}" 
                                       class="btn btn-sm btn-outline-primary" 
                                       title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('products.edit', $product) }}" 
                                       class="btn btn-sm btn-outline-warning ms-1"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
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
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add animation to table rows
        const tableRows = document.querySelectorAll('tbody tr');
        tableRows.forEach((row, index) => {
            row.style.animationDelay = `${index * 0.05}s`;
        });
        
        // Initialize popovers with HTML enabled and wider width
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            // Check if it's a wide popover button
            if (popoverTriggerEl.classList.contains('wide-popover-btn')) {
                return new bootstrap.Popover(popoverTriggerEl, {
                    html: true,
                    trigger: 'click',
                    placement: 'top',
                    container: 'body',
                    sanitize: false,
                    customClass: 'wide-popover'
                });
            } else {
                return new bootstrap.Popover(popoverTriggerEl, {
                    html: true,
                    trigger: 'click',
                    placement: 'top',
                    container: 'body',
                    sanitize: false
                });
            }
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
        
        console.log('Category Products Page Loaded');
        console.log('Category: {{ $category->name }}');
        console.log('Total Products: {{ $categoryStats['total_products'] }}');
        console.log('Total Suppliers: {{ $totalSuppliers ?? 0 }}');
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
            const statsCards = document.querySelectorAll('.row.mb-4 .bg-white');
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
            const actionButtons = document.querySelector('.d-flex.justify-content-between.align-items-center');
            if (actionButtons) {
                actionButtons.style.zIndex = '5';
                actionButtons.style.position = 'relative';
            }

            // 7. Lower z-index for empty state card (if exists)
            const emptyState = document.querySelector('.card .card-body .text-center');
            if (emptyState && emptyState.querySelector('.fa-4x')) {
                const emptyStateCard = emptyState.closest('.card');
                if (emptyStateCard) {
                    emptyStateCard.style.zIndex = '5';
                    emptyStateCard.style.position = 'relative';
                }
            }

            // 8. Lower z-index for breadcrumb
            const breadcrumb = document.querySelector('nav[aria-label="breadcrumb"]');
            if (breadcrumb) {
                breadcrumb.style.zIndex = '5';
                breadcrumb.style.position = 'relative';
            }

            console.log('Category products page dropdown fix applied successfully');
        }
    });

    // format popover content
    document.addEventListener('DOMContentLoaded', function() {
        // Format all popover content to ensure each item is on one line
        const popoverButtons = document.querySelectorAll('.wide-popover-btn');
        
        popoverButtons.forEach(button => {
            button.addEventListener('shown.bs.popover', function() {
                const popover = document.querySelector('.popover.show');
                if (popover) {
                    const popoverBody = popover.querySelector('.popover-body');
                    if (popoverBody) {
                        // Replace <br> with proper line breaks
                        const content = popoverBody.innerHTML;
                        const formattedContent = content.replace(/<br>/g, '</div><div class="popover-item">');
                        popoverBody.innerHTML = '<div class="popover-item" style="white-space: nowrap; margin-bottom: 5px;">' + formattedContent + '</div>';
                        
                        // Ensure popover stays wide
                        popover.style.maxWidth = '600px';
                        popover.style.minWidth = '450px';
                    }
                }
            });
        });
    });
</script>
@endpush
@endsection