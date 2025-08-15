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
        Schema::create('financial_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->unique()->comment('Unique transaction identifier');
            $table->enum('type', ['income', 'expense'])->comment('Transaction type');
            $table->string('category')->comment('Transaction category');
            $table->decimal('amount', 12, 2)->comment('Transaction amount');
            $table->text('description')->comment('Transaction description');
            $table->string('reference')->nullable()->comment('Reference number or document');
            $table->string('account')->comment('Account name or type');
            $table->date('transaction_date')->comment('Date of transaction');
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending')->comment('Transaction status');
            $table->string('payment_method')->nullable()->comment('Payment method used');
            $table->foreignId('employee_id')->nullable()->constrained();
            $table->timestamps();
            
            // Indexes for performance
            $table->index('transaction_id');
            $table->index('type');
            $table->index('category');
            $table->index('status');
            $table->index('transaction_date');
            $table->index(['type', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_transactions');
    }
};