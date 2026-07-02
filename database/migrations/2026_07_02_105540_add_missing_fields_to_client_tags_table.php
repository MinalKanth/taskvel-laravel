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
        Schema::table('client_tags', function (Blueprint $table) {

            if (!Schema::hasColumn('client_tags', 'name')) {
                $table->string('name')->unique()->after('id');
            }

            if (!Schema::hasColumn('client_tags', 'slug')) {
                $table->string('slug')->unique()->after('name');
            }

            if (!Schema::hasColumn('client_tags', 'color')) {
                $table->string('color', 20)->default('#0d6efd')->after('slug');
            }

            if (!Schema::hasColumn('client_tags', 'icon')) {
                $table->string('icon')->nullable()->after('color');
            }

            if (!Schema::hasColumn('client_tags', 'description')) {
                $table->text('description')->nullable()->after('icon');
            }

            if (!Schema::hasColumn('client_tags', 'sort_order')) {
                $table->unsignedInteger('sort_order')->default(0)->after('description');
            }

            if (!Schema::hasColumn('client_tags', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('sort_order');
            }

            if (!Schema::hasColumn('client_tags', 'deleted_at')) {
                $table->softDeletes();
            }

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_tags', function (Blueprint $table) {

            $columns = [];

            foreach ([
                'name',
                'slug',
                'color',
                'icon',
                'description',
                'sort_order',
                'is_active',
                'deleted_at',
            ] as $column) {

                if (Schema::hasColumn('client_tags', $column)) {
                    $columns[] = $column;
                }

            }

            if (!empty($columns)) {
                $table->dropColumn($columns);
            }

        });
    }
};