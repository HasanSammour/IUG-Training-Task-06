<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Product CRUD</title>
    
    <!-- Bootstrap 5 -->
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="{{ asset('font-awesome/css/all.min.css') }}" rel="stylesheet">
    
    <!-- Custom Animations CSS -->
    <link href="{{ asset('bootstrap/css/animations.css') }}" rel="stylesheet">
    <link href="{{ asset('bootstrap/css/custom.css') }}" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark slide-in">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-database me-2"></i>Product System
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">
                            <i class="fas fa-home me-1"></i>Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">
                            <i class="fas fa-boxes me-1"></i>Products
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.create') }}">
                            <i class="fas fa-plus me-1"></i>Add Product
                        </a>
                    </li>
                    <!-- Categories Dropdown -->
                    <li class="nav-item dropdown position-static">
                        <a class="nav-link dropdown-toggle" href="#" id="categoriesDropdown" role="button" 
                           data-bs-toggle="dropdown" data-bs-auto-close="outside"
                           aria-expanded="false">
                            <i class="fas fa-folder me-1"></i>Categories
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg" 
                            style="z-index: 1050; position: absolute;"
                            aria-labelledby="categoriesDropdown">
                            @php
                                $categories = \App\Models\Category::withCount('products')->orderBy('name')->get();
                            @endphp
                            @if($categories->count() > 0)
                                <li><h6 class="dropdown-header bg-light">
                                    <i class="fas fa-tags me-2"></i>All Categories
                                </h6></li>
                                @foreach($categories as $category)
                                    <li>
                                        <a class="dropdown-item d-flex justify-content-between align-items-center py-2" 
                                           href="{{ route('categories.products.show', $category->id) }}">
                                            <div class="d-flex align-items-center">
                                                @switch($category->name)
                                                    @case('Electronics')
                                                        <span class="badge bg-primary me-2 px-2 py-1">
                                                            <i class="fas fa-laptop"></i>
                                                        </span>
                                                        @break
                                                    @case('Fashion')
                                                        <span class="badge bg-danger me-2 px-2 py-1">
                                                            <i class="fas fa-tshirt"></i>
                                                        </span>
                                                        @break
                                                    @case('Home & Garden')
                                                        <span class="badge bg-success me-2 px-2 py-1">
                                                            <i class="fas fa-home"></i>
                                                        </span>
                                                        @break
                                                    @case('Books')
                                                        <span class="badge bg-warning me-2 px-2 py-1">
                                                            <i class="fas fa-book"></i>
                                                        </span>
                                                        @break
                                                    @case('Sports')
                                                        <span class="badge bg-info me-2 px-2 py-1">
                                                            <i class="fas fa-futbol"></i>
                                                        </span>
                                                        @break
                                                    @case('Health & Beauty')
                                                        <span class="badge bg-purple me-2 px-2 py-1">
                                                            <i class="fas fa-spa"></i>
                                                        </span>
                                                        @break
                                                    @case('Toys')
                                                        <span class="badge bg-teal me-2 px-2 py-1">
                                                            <i class="fas fa-gamepad"></i>
                                                        </span>
                                                        @break
                                                    @case('Automotive')
                                                        <span class="badge bg-orange me-2 px-2 py-1">
                                                            <i class="fas fa-car"></i>
                                                        </span>
                                                        @break
                                                    @case('Test Empty Category')
                                                        <span class="badge bg-secondary text-white me-2 px-2 py-1">
                                                            <i class="fas fa-vial"></i>
                                                        </span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary text-white me-2 px-2 py-1">
                                                            <i class="fas fa-tag"></i>
                                                        </span>
                                                @endswitch
                                                <span>{{ $category->name }}</span>
                                            </div>
                                            <span class="badge bg-light text-dark rounded-pill">
                                                {{ $category->products_count }}
                                            </span>
                                        </a>
                                    </li>
                                @endforeach
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-center text-primary fw-bold" href="{{ route('products.index') }}">
                                        <i class="fas fa-eye me-2"></i>View All Products
                                    </a>
                                </li>
                            @else
                                <li><a class="dropdown-item text-muted" href="#">
                                    <i class="fas fa-exclamation-circle me-2"></i>No categories found
                                </a></li>
                            @endif
                        </ul>
                    </li>
                    <!-- NEW: Suppliers Link -->
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#suppliersModal">
                            <i class="fas fa-truck me-1"></i>Suppliers
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Suppliers Modal -->
    <div class="modal fade" id="suppliersModal" tabindex="-1" aria-labelledby="suppliersModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="suppliersModalLabel">
                        <i class="fas fa-truck me-2"></i>All Suppliers
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @php
                        $suppliers = \App\Models\Supplier::withCount('products')->orderBy('name')->get();
                    @endphp
                    @if($suppliers->count() > 0)
                        <div class="row">
                            @foreach($suppliers as $supplier)
                            <div class="col-md-6 mb-3">
                                <div class="card border h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-start">
                                            <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                                                <i class="fas fa-truck text-warning"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">{{ $supplier->name }}</h6>
                                                <p class="text-muted mb-2">
                                                    <i class="fas fa-envelope me-1"></i>{{ $supplier->email }}
                                                </p>
                                                <div class="small text-muted">
                                                    <i class="fas fa-database me-1"></i>
                                                    Supplies: <strong>{{ $supplier->products_count }}</strong> products
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-truck fa-3x text-muted mb-3"></i>
                            <h5>No Suppliers Found</h5>
                            <p class="text-muted">Run the SupplierSeeder to add suppliers</p>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Task 06: Many-to-Many Relationships
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container my-4 page-transition">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show fade-in">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show fade-in">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Breadcrumb -->
        @hasSection('breadcrumb')
            <nav aria-label="breadcrumb" class="mb-3 fade-in">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i> Home</a></li>
                    @yield('breadcrumb')
                </ol>
            </nav>
        @endif
        
        @yield('content')
    </div>

    <!-- Footer - UPDATED FOR TASK 06 -->
    <footer class="text-center text-muted fade-in">
        <div class="container py-3">
            <p class="mb-0">
                <i class="fas fa-code me-2"></i>Laravel Task 06 - Many-to-Many Relationships & Suppliers
            </p>
            <small>IUG University Training Project |
                <i class="fas fa-truck me-1"></i>Many-to-Many Relationships |
                <i class="fas fa-exchange-alt ms-2 me-1"></i>Pivot Tables |
                <i class="fas fa-table ms-2 me-1"></i>Suppliers System
            </small>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    
    <!-- Custom Animations JS -->
    <script src="{{ asset('bootstrap/js/animations.js') }}"></script>
    <script src="{{ asset('bootstrap/js/script.js') }}"></script>
    <script src="{{ asset('bootstrap/js/delete-confirm.js') }}"></script>
    
    @stack('scripts')
</body>
</html>