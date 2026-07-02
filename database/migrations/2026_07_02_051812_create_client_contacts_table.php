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
        Schema::create('client_contacts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('client_id')
                ->constrained()
                ->cascadeOnDelete();

            // Personal Details
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('full_name');

            $table->string('designation')->nullable();
            $table->string('department')->nullable();

            // Contact Information
            $table->string('mobile', 20);
            $table->string('alternate_mobile', 20)->nullable();

            $table->string('email')->nullable();

            $table->string('whatsapp_number', 20)->nullable();

            // Dates
            $table->date('date_of_birth')->nullable();
            $table->date('anniversary')->nullable();

            // Communication Preferences
            $table->boolean('is_primary')->default(false);
            $table->boolean('receive_email')->default(true);
            $table->boolean('receive_whatsapp')->default(true);
            $table->boolean('receive_sms')->default(false);

            // Status
            $table->boolean('is_active')->default(true);

            // Additional Information
            $table->text('remarks')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('client_id');
            $table->index('mobile');
            $table->index('email');
            $table->index('is_primary');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_contacts');
    }
};