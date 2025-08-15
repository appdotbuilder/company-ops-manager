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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id')->unique()->comment('Employee identification number');
            $table->string('first_name')->comment('Employee first name');
            $table->string('last_name')->comment('Employee last name');
            $table->string('email')->unique()->comment('Employee email address');
            $table->string('phone')->nullable()->comment('Employee phone number');
            $table->string('department')->comment('Employee department');
            $table->string('position')->comment('Employee position/title');
            $table->decimal('salary', 10, 2)->comment('Employee salary');
            $table->date('hire_date')->comment('Date of hire');
            $table->enum('status', ['active', 'inactive', 'terminated'])->default('active')->comment('Employment status');
            $table->text('address')->nullable()->comment('Employee address');
            $table->date('birth_date')->nullable()->comment('Employee date of birth');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('employee_id');
            $table->index('department');
            $table->index('status');
            $table->index(['status', 'department']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};