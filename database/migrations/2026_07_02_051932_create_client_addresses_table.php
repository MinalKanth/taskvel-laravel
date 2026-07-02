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
        Schema::create('client_addresses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('client_id')
                ->constrained()
                ->cascadeOnDelete();

            // Address Type
            $table->enum('address_type', [
                'Registered Office',
                'Corporate Office',
                'Branch Office',
                'Factory',
                'Warehouse',
                'Billing',
                'Shipping',
                'Other'
            ])->default('Registered Office');

            // Address Details
            $table->string('address_line_1');
            $table->string('address_line_2')->nullable();
            $table->string('landmark')->nullable();

            $table->string('city');
            $table->string('district')->nullable();
            $table->string('state');
            $table->string('country')->default('India');
            $table->string('postal_code', 10);

            // GPS Coordinates
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // Default Address
            $table->boolean('is_default')->default(false);

            // Status
            $table->boolean('is_active')->default(true);

            // Notes
            $table->text('remarks')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('client_id');
            $table->index('address_type');
            $table->index('city');
            $table->index('state');
            $table->index('postal_code');
            $table->index('is_default');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_addresses');
    }
};