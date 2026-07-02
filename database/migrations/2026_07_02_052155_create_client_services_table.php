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
        Schema::create('client_services', function (Blueprint $table) {

            $table->id();

            // Relationships
            $table->foreignId('client_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('service_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Service Period
            $table->date('start_date')->nullable();

            $table->date('end_date')->nullable();

            // Pricing
            $table->decimal('service_fee', 12, 2)->default(0);

            $table->decimal('discount', 12, 2)->default(0);

            $table->decimal('tax_percentage', 5, 2)->default(0);

            // Billing
            $table->enum('billing_cycle', [
                'One Time',
                'Monthly',
                'Quarterly',
                'Half Yearly',
                'Yearly',
            ])->default('Monthly');

            $table->unsignedTinyInteger('due_day')
                ->nullable();

            // Automation
            $table->boolean('auto_generate_tasks')
                ->default(true);

            // Status
            $table->enum('status', [
                'Pending',
                'Active',
                'Suspended',
                'Completed',
                'Expired',
                'Cancelled',
            ])->default('Pending');

            $table->boolean('renewable')
                ->default(true);

            $table->date('renewal_date')
                ->nullable();

            $table->longText('remarks')
                ->nullable();

            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();

            $table->softDeletes();

            // Indexes
            $table->index('client_id');
            $table->index('service_id');
            $table->index('assigned_to');
            $table->index('status');
            $table->index('billing_cycle');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_services');
    }
};