<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_credentials', function (Blueprint $table) {

            $table->id();

            $table->foreignId('client_id')
                ->constrained()
                ->cascadeOnDelete();

            // Portal Details
            $table->enum('portal', [
                'GST',
                'EPFO',
                'ESIC',
                'TRACES',
                'Income Tax',
                'MCA',
                'ICEGATE',
                'FSSAI',
                'UDYAM',
                'DGFT',
                'Professional Tax',
                'Other'
            ]);

            $table->string('portal_name')->nullable();

            // Login Credentials
            $table->string('username');
            $table->text('password');

            // Registered Details
            $table->string('registered_email')->nullable();
            $table->string('registered_mobile', 20)->nullable();

            // Security
            $table->string('security_question')->nullable();
            $table->text('security_answer')->nullable();

            $table->string('client_id_number')->nullable();

            // Authentication
            $table->boolean('otp_required')->default(true);
            $table->boolean('dsc_required')->default(false);

            // URLs
            $table->string('login_url')->nullable();

            // API Credentials
            $table->text('api_key')->nullable();
            $table->text('api_secret')->nullable();

            // PIN / Secret
            $table->text('pin')->nullable();

            // DSC
            $table->string('dsc_serial_number')->nullable();
            $table->string('dsc_owner')->nullable();
            $table->date('dsc_expiry_date')->nullable();

            // Dates
            $table->date('expiry_date')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamp('last_password_changed_at')->nullable();

            // Status
            $table->boolean('is_active')->default(true);

            // Extra
            $table->json('metadata')->nullable();
            $table->longText('remarks')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['client_id', 'portal']);

            $table->index('client_id');
            $table->index('portal');
            $table->index('username');
            $table->index('expiry_date');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_credentials');
    }
};