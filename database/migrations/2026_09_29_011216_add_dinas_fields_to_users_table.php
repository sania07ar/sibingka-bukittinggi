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
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable()->unique()->after('name');
            $table->string('nip', 30)->nullable()->after('email');
            $table->string('phone', 25)->nullable()->after('nip');
            $table->string('role', 20)->default('opd')->after('phone');
            $table->string('opd_code', 20)->nullable()->after('role');
            $table->string('dinas_name', 150)->nullable()->after('opd_code');
            $table->json('allowed_pages')->nullable()->after('dinas_name');
            $table->boolean('is_active')->default(true)->after('allowed_pages');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username',
                'nip',
                'phone',
                'role',
                'opd_code',
                'dinas_name',
                'allowed_pages',
                'is_active',
            ]);
        });
    }
};
