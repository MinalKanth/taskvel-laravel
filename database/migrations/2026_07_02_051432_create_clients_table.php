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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();

            // Basic Information
            $table->string('client_code', 30)->unique();
            $table->string('company_name');
            $table->string('legal_name')->nullable();

            // Business Details
            $table->enum('business_type', [
                'Proprietorship',
                'Partnership',
                'LLP',
                'Private Limited',
                'Public Limited',
                'OPC',
                'Trust',
                'Society',
                'NGO',
                'Government',
                'Other'
            ])->default('Proprietorship');

            $table->string('constitution')->nullable();

            // Registration Numbers
            $table->string('gstin', 20)->nullable()->unique();
            $table->string('pan', 15)->nullable()->unique();
            $table->string('tan', 15)->nullable()->unique();
            $table->string('cin', 30)->nullable()->unique();
            $table->string('udyam_number')->nullable();
            $table->string('esic_code')->nullable();
            $table->string('epf_code')->nullable();

            // Contact
            $table->string('email')->nullable();
            $table->string('website')->nullable();

            $table->string('phone', 20);
            $table->string('alternate_phone', 20)->nullable();

            // Status
            $table->enum('status', [
                'Lead',
                'Prospect',
                'Active',
                'Inactive',
                'Suspended',
                'Closed'
            ])->default('Lead');

            $table->enum('priority', [
                'Low',
                'Medium',
                'High',
                'Critical'
            ])->default('Medium');

            // Business Information
            $table->date('incorporation_date')->nullable();

            // Financial
            $table->decimal('opening_balance', 15, 2)->default(0);
            $table->decimal('credit_limit', 15, 2)->default(0);

            $table->integer('payment_terms')
                ->default(30)
                ->comment('Payment due in days');

            // Assignment
            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Notes
            $table->longText('notes')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('company_name');
            $table->index('phone');
            $table->index('email');
            $table->index('status');
            $table->index('priority');
            $table->index('assigned_to');
            $table->index('gstin');
            $table->index('pan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};