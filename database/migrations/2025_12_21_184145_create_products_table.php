<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();  // Add unique constraint
            $table->decimal('price', 10, 2);  // Decimal As you Ask in the Task Requirements
            $table->text('description')->nullable();
            // ! From Task 05: 
            // * Add a category_id field to the products migration.
            // * Define a Foreign Key constraint linking category_id to the id on the categories table.
            // * Implement an appropriate onDelete strategy (e.g., cascade or set null).
            $table->foreignId('category_id')
                  ->nullable()
                  ->constrained('categories')
                  ->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};