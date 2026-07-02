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
        Schema::create('client_communications', function (Blueprint $table) {

            $table->id();

            $table->foreignId('client_id')
                ->constrained()
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Communication
            |--------------------------------------------------------------------------
            */

            $table->enum('channel', [
                'Email',
                'WhatsApp',
                'SMS',
                'Phone Call',
                'Meeting',
                'Internal Chat',
                'Push Notification',
                'Other',
            ]);

            $table->enum('direction', [
                'Incoming',
                'Outgoing',
            ]);

            /*
            |--------------------------------------------------------------------------
            | Message
            |--------------------------------------------------------------------------
            */

            $table->string('subject')->nullable();

            $table->longText('message');

            /*
            |--------------------------------------------------------------------------
            | Contact
            |--------------------------------------------------------------------------
            */

            $table->string('sender_name')->nullable();
            $table->string('sender_email')->nullable();
            $table->string('sender_phone', 20)->nullable();

            $table->string('receiver_name')->nullable();
            $table->string('receiver_email')->nullable();
            $table->string('receiver_phone', 20)->nullable();

            /*
            |--------------------------------------------------------------------------
            | Thread
            |--------------------------------------------------------------------------
            */

            $table->string('thread_id')->nullable();
            $table->string('message_id')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Attachments
            |--------------------------------------------------------------------------
            */

            $table->boolean('has_attachment')->default(false);

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'Draft',
                'Queued',
                'Sending',
                'Sent',
                'Delivered',
                'Read',
                'Replied',
                'Failed',
                'Cancelled',
            ])->default('Sent');

            /*
            |--------------------------------------------------------------------------
            | User
            |--------------------------------------------------------------------------
            */

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Date
            |--------------------------------------------------------------------------
            */

            $table->timestamp('communication_at');

            /*
            |--------------------------------------------------------------------------
            | Metadata
            |--------------------------------------------------------------------------
            */

            $table->json('metadata')->nullable();

            $table->timestamps();

            $table->softDeletes();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('client_id');
            $table->index('channel');
            $table->index('direction');
            $table->index('status');
            $table->index('communication_at');
            $table->index('thread_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_communications');
    }
};