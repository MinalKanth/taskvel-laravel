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
        Schema::create('client_remarks', function (Blueprint $table) {

            $table->id();

            $table->foreignId('client_id')
                ->constrained()
                ->cascadeOnDelete();

            // Reply System

            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('client_remarks')
                ->nullOnDelete();

            // User

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // Remark

            $table->longText('remark');

            // Type

            $table->enum('type',[
                'General',
                'Follow Up',
                'Important',
                'Payment',
                'Compliance',
                'Registration',
                'Document',
                'Meeting',
                'Phone Call',
                'Email',
                'WhatsApp'
            ])->default('General');

            // Visibility

            $table->boolean('is_private')->default(true);

            $table->boolean('is_pinned')->default(false);

            // Status

            $table->enum('status',[
                'Open',
                'In Progress',
                'Resolved',
                'Closed'
            ])->default('Open');

            // Attachment

            $table->string('attachment')->nullable();

            // Mention

            $table->foreignId('mentioned_user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Read

            $table->timestamp('read_at')->nullable();

            $table->timestamps();

            $table->softDeletes();

            $table->index('client_id');
            $table->index('user_id');
            $table->index('parent_id');
            $table->index('type');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_remarks');
    }
};