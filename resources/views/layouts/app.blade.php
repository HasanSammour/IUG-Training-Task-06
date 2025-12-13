<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Product CRUD</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Simple Animations -->
    <style>
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes slideIn {
            from { transform: translateX(-20px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        /* Custom Styles */
        .fade-in { animation: fadeIn 0.6s ease; }
        .slide-in { animation: slideIn 0.5s ease; }
        .pulse-animation { animation: pulse 2s infinite; }
        
        .navbar-brand { font-weight: bold; }
        .btn { transition: all 0.3s; }
        .btn:hover { transform: translateY(-2px); }
        
        .card { 
            border: none; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .card:hover { transform: translateY(-5px); }
        
        .table-hover tbody tr { transition: background 0.3s; }
        .table-hover tbody tr:hover { background: rgba(0,123,255,0.1); }
        
        .alert { border: none; }
        .badge { font-size: 0.9em; }
        
        footer { 
            margin-top: 50px;
            padding: 20px 0;
            background: #f8f9fa;
            border-top: 1px solid #dee2e6;
        }
        
        .action-btns .btn { margin: 0 3px; }
        .price-tag { font-weight: bold; color: #28a745; }
        
        .form-control:focus { 
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
        }
        
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin: 10px 0;
        }
        
        .page-title {
            border-left: 5px solid #007bff;
            padding-left: 15px;
            margin-bottom: 30px;
        }
    </style>
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
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container my-4">
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
        
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="text-center text-muted">
        <div class="container">
            <p class="mb-0">
                <i class="fas fa-code me-2"></i>Laravel Task 03 - Product CRUD System
            </p>
            <small>University Training Project</small>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Simple Scripts -->
    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                alert.classList.remove('show');
            });
        }, 5000);
        
        // Delete confirmation
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('Are you sure you want to delete this product?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>