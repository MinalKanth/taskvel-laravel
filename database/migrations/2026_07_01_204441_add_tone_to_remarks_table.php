<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('remarks', function (Blueprint $table) {
            if (!Schema::hasColumn('remarks', 'tone')) {
                $table->string('tone', 30)->nullable()->after('remark');
            }
        });
    }

    public function down(): void
    {
        Schema::table('remarks', function (Blueprint $table) {
            $table->dropColumn('tone');
        });
    }
};