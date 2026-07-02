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

            // Login Details
            $table->string('username');
            $table->text('password');

            // Additional Details
            $table->string('registered_email')->nullable();
            $table->string('registered_mobile', 20)->nullable();

            $table->string('security_question')->nullable();
            $table->text('security_answer')->nullable();

            $table->string('client_id_number')->nullable();

            // OTP / DSC
            $table->boolean('otp_required')->default(true);
            $table->boolean('dsc_required')->default(false);

            // Expiry
            $table->date('expiry_date')->nullable();

            // Status
            $table->boolean('is_active')->default(true);

            $table->text('remarks')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('client_id');
            $table->index('portal');
            $table->index('username');
            $table->index('expiry_date');
            $table->index('is_active');

            $table->unique([
                'client_id',
                'portal'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_credentials');
    }
};