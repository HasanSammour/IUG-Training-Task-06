<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Part 1: Task Solution Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Part 2: CRUD Operations
Route::resource('products', ProductController::class);