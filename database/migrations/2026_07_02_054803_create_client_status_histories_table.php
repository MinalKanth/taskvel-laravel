<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_status_histories', function (Blueprint $table) {

            $table->id();

            $table->foreignId('client_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('old_status')->nullable();

            $table->string('new_status');

            $table->foreignId('changed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->text('reason')->nullable();

            $table->timestamp('changed_at');

            $table->timestamps();

            $table->index('client_id');
            $table->index('new_status');
            $table->index('changed_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_status_histories');
    }
};