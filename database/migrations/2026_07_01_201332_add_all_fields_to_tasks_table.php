<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {

            // Core tracking fields
            if (!Schema::hasColumn('tasks', 'progress')) {
                $table->unsignedTinyInteger('progress')->default(0)->after('status');
            }
            if (!Schema::hasColumn('tasks', 'completed_at')) {
                $table->timestamp('completed_at')->nullable()->after('progress');
            }
            if (!Schema::hasColumn('tasks', 'estimated_minutes')) {
                $table->unsignedInteger('estimated_minutes')->nullable()->after('completed_at');
            }
            if (!Schema::hasColumn('tasks', 'actual_minutes')) {
                $table->unsignedInteger('actual_minutes')->default(0)->after('estimated_minutes');
            }

            // Priority & scheduling
            if (!Schema::hasColumn('tasks', 'due_date')) {
                $table->dateTime('due_date')->nullable()->after('actual_minutes');
            }
            if (!Schema::hasColumn('tasks', 'reminder_at')) {
                $table->dateTime('reminder_at')->nullable()->after('due_date');
            }
            if (!Schema::hasColumn('tasks', 'recurrence')) {
                $table->enum('recurrence', ['none', 'daily', 'weekly', 'monthly'])->default('none')->after('reminder_at');
            }

            // Classification
            if (!Schema::hasColumn('tasks', 'category')) {
                $table->string('category')->nullable()->after('recurrence');
            }
            if (!Schema::hasColumn('tasks', 'color')) {
                $table->string('color', 7)->default('#4f46e5')->after('category');
            }

            // Flags
            if (!Schema::hasColumn('tasks', 'is_favorite')) {
                $table->boolean('is_favorite')->default(false)->after('color');
            }
            if (!Schema::hasColumn('tasks', 'is_archived')) {
                $table->boolean('is_archived')->default(false)->after('is_favorite');
            }
            if (!Schema::hasColumn('tasks', 'is_pinned')) {
                $table->boolean('is_pinned')->default(false)->after('is_archived');
            }

            // Impact / urgency matrix (Eisenhower)
            if (!Schema::hasColumn('tasks', 'urgency')) {
                $table->unsignedTinyInteger('urgency')->default(1)->comment('1-5')->after('is_pinned');
            }
            if (!Schema::hasColumn('tasks', 'impact')) {
                $table->unsignedTinyInteger('impact')->default(1)->comment('1-5')->after('urgency');
            }

            // Sort
            if (!Schema::hasColumn('tasks', 'sort_order')) {
                $table->unsignedInteger('sort_order')->default(0)->after('impact');
            }

            // Notes / attachments count cache
            if (!Schema::hasColumn('tasks', 'notes')) {
                $table->text('notes')->nullable()->after('sort_order');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn([
                'progress', 'completed_at', 'estimated_minutes', 'actual_minutes',
                'due_date', 'reminder_at', 'recurrence', 'category', 'color',
                'is_favorite', 'is_archived', 'is_pinned',
                'urgency', 'impact', 'sort_order', 'notes',
            ]);
        });
    }
};