@extends('layouts.app')

@section('title', 'Task 03 Solution')

@section('content')
<div class="row fade-in">
    <div class="col-12">
        <!-- Header -->
        <div class="text-center mb-5">
            <h1 class="display-4 mb-3">
                <i class="fas fa-database text-primary"></i> Task 03 Solution
            </h1>
            <p class="lead text-muted">Laravel Database Operations & CRUD System</p>
        </div>
        
        <!-- Task Cards -->
        <div class="row mb-5">
            <div class="col-md-6 mb-4">
                <div class="card h-100 slide-in">
                    <div class="card-header bg-primary text-white">
                        <h4><i class="fas fa-tasks me-2"></i> Part 1: Database Operations</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Product Model</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Database Migration</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Seeder with Factory</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Tinker Testing</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 mb-4">
                <div class="card h-100 slide-in" style="animation-delay: 0.2s">
                    <div class="card-header bg-success text-white">
                        <h4><i class="fas fa-cogs me-2"></i> Part 2: CRUD Operations</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-plus-circle text-info me-2"></i> Create Products</li>
                            <li class="mb-2"><i class="fas fa-eye text-info me-2"></i> Read/View Products</li>
                            <li class="mb-2"><i class="fas fa-edit text-info me-2"></i> Update Products</li>
                            <li class="mb-2"><i class="fas fa-trash text-info me-2"></i> Delete Products</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Action Button -->
        <div class="text-center mb-5 fade-in" style="animation-delay: 0.5s">
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg pulse-animation">
                <i class="fas fa-rocket me-2"></i> Launch Product Manager
            </a>
        </div>
        
        <!-- Quick Stats -->
        <div class="row mb-5">
            <div class="col-md-3 col-6 mb-3">
                <div class="stats-card text-center fade-in" style="animation-delay: 0.3s">
                    <i class="fas fa-code fa-2x mb-2"></i>
                    <h4>Laravel 12</h4>
                    <small>Framework</small>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="stats-card text-center fade-in" style="animation-delay: 0.4s">
                    <i class="fas fa-database fa-2x mb-2"></i>
                    <h4>MySQL</h4>
                    <small>Database</small>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="stats-card text-center fade-in" style="animation-delay: 0.5s">
                    <i class="fas fa-paint-brush fa-2x mb-2"></i>
                    <h4>Bootstrap 5</h4>
                    <small>UI Framework</small>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="stats-card text-center fade-in" style="animation-delay: 0.6s">
                    <i class="fas fa-bolt fa-2x mb-2"></i>
                    <h4>Animations</h4>
                    <small>CSS Effects</small>
                </div>
            </div>
        </div>
        
        <!-- Tinker Commands -->
        <div class="card fade-in" style="animation-delay: 0.7s">
            <div class="card-header bg-dark text-white">
                <h5><i class="fas fa-terminal me-2"></i> Tinker Commands Used</h5>
            </div>
            <div class="card-body">
                <div class="bg-light p-3 rounded mb-3">
                    <code>$ php artisan tinker</code><br>
                    <code>>> Product::all()</code><br>
                    <code>>> Product::find(1)</code><br>
                    <code>>> Product::where('price', '>', 50)->get()</code><br>
                    <code>>> Product::create(['name' => 'Test', 'price' => 99.99])</code><br>
                    <code>>> Product::find(1)->update(['price' => 79.99])</code><br>
                    <code>>> Product::find(1)->delete()</code>
                    <code>>> Product::count()</code><br>
                </div>
                <small class="text-muted">Use these commands to test database operations</small>
            </div>
        </div>
    </div>
</div>
@endsection