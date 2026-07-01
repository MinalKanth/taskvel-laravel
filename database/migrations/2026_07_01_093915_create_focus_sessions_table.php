<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('focus_sessions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('task_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->enum('session_type', [
                'focus',
                'short_break',
                'long_break'
            ])->default('focus');

            $table->unsignedInteger('planned_minutes')->default(25);
            $table->unsignedInteger('actual_minutes')->default(0);

            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();

            $table->boolean('completed')->default(false);
            $table->boolean('interrupted')->default(false);

            $table->unsignedSmallInteger('interruptions')->default(0);

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index('user_id');
            $table->index('task_id');
            $table->index('session_type');
            $table->index('completed');
            $table->index('started_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('focus_sessions');
    }
};