<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('task_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('title');
            $table->text('message');

            $table->enum('type', [
                'task',
                'reminder',
                'focus',
                'system',
            ])->default('system');

            $table->enum('priority', [
                'low',
                'medium',
                'high',
            ])->default('medium');

            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('read_at')->nullable();

            $table->boolean('is_read')->default(false);

            $table->json('data')->nullable();

            $table->timestamps();

            $table->index('user_id');
            $table->index('task_id');
            $table->index('type');
            $table->index('priority');
            $table->index('is_read');
            $table->index('scheduled_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};