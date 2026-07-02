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
        Schema::create('client_custom_fields', function (Blueprint $table) {

            $table->id();

            $table->foreignId('client_id')
                ->constrained()
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Field
            |--------------------------------------------------------------------------
            */

            $table->string('field_name');

            $table->string('field_key');

            /*
            |--------------------------------------------------------------------------
            | Type
            |--------------------------------------------------------------------------
            */

            $table->enum('field_type',[
                'Text',
                'Textarea',
                'Number',
                'Decimal',
                'Email',
                'Phone',
                'Date',
                'DateTime',
                'Checkbox',
                'Select',
                'Radio',
                'File',
                'URL'
            ]);

            /*
            |--------------------------------------------------------------------------
            | Value
            |--------------------------------------------------------------------------
            */

            $table->longText('field_value')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Extra
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_required')->default(false);

            $table->boolean('is_visible')->default(true);

            $table->boolean('is_searchable')->default(false);

            $table->unsignedInteger('sort_order')->default(0);

            $table->text('remarks')->nullable();

            $table->timestamps();

            $table->softDeletes();

            $table->index('client_id');
            $table->index('field_key');
            $table->index('field_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_custom_fields');
    }
};