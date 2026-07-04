<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->string('phone')->nullable()->after('email');

            $table->string('user_type')
                ->default('staff')
                ->after('password');

            $table->foreignId('client_id')
                ->nullable()
                ->constrained('clients')
                ->nullOnDelete()
                ->after('user_type');

            $table->string('avatar')->nullable()->after('client_id');

            $table->string('designation')->nullable()->after('avatar');

            $table->string('department')->nullable()->after('designation');

            $table->string('status')
                ->default('active')
                ->after('department');

            $table->timestamp('last_login_at')->nullable()->after('status');

            $table->string('timezone')->default('Asia/Kolkata')->after('last_login_at');

            $table->string('language')->default('en')->after('timezone');

            $table->softDeletes();

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn([
                'phone',
                'user_type',
                'client_id',
                'avatar',
                'designation',
                'department',
                'status',
                'last_login_at',
                'timezone',
                'language',
            ]);

            $table->dropSoftDeletes();

        });
    }
};