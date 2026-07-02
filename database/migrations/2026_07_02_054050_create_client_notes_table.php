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
        Schema::create('client_documents', function (Blueprint $table) {

            $table->id();

            $table->foreignId('client_id')
                ->constrained()
                ->cascadeOnDelete();

            // Category

            $table->enum('category', [
                'GST',
                'EPF',
                'ESIC',
                'Payroll',
                'Registration',
                'Invoice',
                'Agreement',
                'Employee',
                'Bank',
                'Tax',
                'ROC',
                'License',
                'Certificate',
                'Identity',
                'Other'
            ]);

            // Document Details

            $table->string('title');

            $table->string('document_number')->nullable();

            $table->text('description')->nullable();

            // File

            $table->string('original_name');

            $table->string('file_name');

            $table->string('file_path');

            $table->string('disk')->default('public');

            $table->string('extension',20);

            $table->string('mime_type');

            $table->unsignedBigInteger('file_size');

            // Version

            $table->unsignedInteger('version')->default(1);

            // Dates

            $table->date('issue_date')->nullable();

            $table->date('expiry_date')->nullable();

            // Approval

            $table->enum('status',[
                'Pending',
                'Approved',
                'Rejected',
                'Expired',
                'Archived'
            ])->default('Pending');

            // Visibility

            $table->boolean('is_confidential')->default(false);

            $table->boolean('is_downloadable')->default(true);

            // Audit

            $table->foreignId('uploaded_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('approved_at')->nullable();

            // Remarks

            $table->longText('remarks')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->softDeletes();

            // Indexes

            $table->index('client_id');
            $table->index('category');
            $table->index('status');
            $table->index('expiry_date');
            $table->index('uploaded_by');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_documents');
    }
};