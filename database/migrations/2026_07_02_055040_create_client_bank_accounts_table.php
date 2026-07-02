<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_bank_accounts', function (Blueprint $table) {

            $table->id();

            $table->foreignId('client_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('bank_name');

            $table->string('branch_name')->nullable();

            $table->string('account_holder_name');

            $table->string('account_number');

            $table->string('ifsc_code',20);

            $table->string('micr_code',20)->nullable();

            $table->string('account_type')
                ->default('Current');

            $table->string('upi_id')->nullable();

            $table->boolean('is_primary')->default(false);

            $table->boolean('is_active')->default(true);

            $table->text('remarks')->nullable();

            $table->timestamps();

            $table->softDeletes();

            $table->index('client_id');
            $table->index('bank_name');
            $table->index('ifsc_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_bank_accounts');
    }
};