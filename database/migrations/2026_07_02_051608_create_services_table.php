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
        Schema::create('services', function (Blueprint $table) {
            $table->id();

            // Basic Information
            $table->string('service_code', 30)->unique();
            $table->string('name');
            $table->string('short_name')->nullable();
            $table->text('description')->nullable();

            // Category
            $table->enum('category', [
                'Registration',
                'Compliance',
                'Payroll',
                'Taxation',
                'Accounting',
                'Licensing',
                'Consultancy',
                'Legal',
                'Other'
            ])->default('Compliance');

            // Recurrence
            $table->boolean('is_recurring')->default(true);

            $table->enum('frequency', [
                'One Time',
                'Monthly',
                'Quarterly',
                'Half Yearly',
                'Yearly',
                'Custom'
            ])->default('Monthly');

            // Due Date
            $table->unsignedTinyInteger('due_day')
                ->nullable()
                ->comment('Day of month e.g. 15');

            // Billing
            $table->decimal('default_price', 12, 2)->default(0);

            // UI
            $table->string('icon')->nullable();
            $table->string('color', 20)->default('#0d6efd');

            // Display
            $table->unsignedInteger('sort_order')->default(0);

            // Status
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('name');
            $table->index('category');
            $table->index('frequency');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};