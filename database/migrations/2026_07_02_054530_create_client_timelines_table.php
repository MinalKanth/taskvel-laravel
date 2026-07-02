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
        Schema::create('client_timelines', function (Blueprint $table) {

            $table->id();

            $table->foreignId('client_id')
                ->constrained()
                ->cascadeOnDelete();

            // User who performed the action

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // Module

            $table->string('module',100);

            // Action

            $table->string('action',100);

            // Title

            $table->string('title');

            // Description

            $table->longText('description')->nullable();

            // Reference

            $table->unsignedBigInteger('reference_id')->nullable();

            $table->string('reference_type')->nullable();

            // Event

            $table->enum('event_type',[
                'Create',
                'Update',
                'Delete',
                'Upload',
                'Download',
                'Approval',
                'Payment',
                'Reminder',
                'Communication',
                'Status Change',
                'Assignment',
                'Other'
            ])->default('Other');

            // Icon

            $table->string('icon')->nullable();

            // Badge Color

            $table->string('color',20)
                ->default('primary');

            // Metadata

            $table->json('metadata')->nullable();

            // Visibility

            $table->boolean('is_visible')->default(true);

            $table->timestamps();

            // Indexes

            $table->index('client_id');
            $table->index('user_id');
            $table->index('module');
            $table->index('event_type');
            $table->index('reference_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_timelines');
    }
};