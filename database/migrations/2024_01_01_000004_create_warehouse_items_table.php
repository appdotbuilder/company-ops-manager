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
        Schema::create('warehouse_items', function (Blueprint $table) {
            $table->id();
            $table->string('item_code')->unique()->comment('Unique item identification code');
            $table->string('name')->comment('Item name');
            $table->text('description')->nullable()->comment('Item description');
            $table->string('category')->comment('Item category');
            $table->integer('quantity')->default(0)->comment('Current stock quantity');
            $table->integer('min_quantity')->default(10)->comment('Minimum stock level for alerts');
            $table->decimal('unit_price', 10, 2)->comment('Unit price');
            $table->string('unit')->default('pcs')->comment('Unit of measurement');
            $table->string('location')->nullable()->comment('Storage location in warehouse');
            $table->string('supplier')->nullable()->comment('Supplier information');
            $table->enum('status', ['active', 'discontinued', 'out_of_stock'])->default('active')->comment('Item status');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('item_code');
            $table->index('category');
            $table->index('status');
            $table->index(['category', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouse_items');
    }
};