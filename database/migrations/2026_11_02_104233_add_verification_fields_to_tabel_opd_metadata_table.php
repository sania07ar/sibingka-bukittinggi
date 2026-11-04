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
        Schema::table('tabel_opd_metadata', function (Blueprint $table) {
            $table->string('verification_status', 30)->default('draft')->after('is_saved');
            $table->timestamp('verified_at')->nullable()->after('verification_status');
            $table->string('verified_by', 255)->nullable()->after('verified_at');
            $table->text('rejection_notes')->nullable()->after('verified_by');
            $table->boolean('is_locked')->default(false)->after('rejection_notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tabel_opd_metadata', function (Blueprint $table) {
            $table->dropColumn([
                'verification_status',
                'verified_at',
                'verified_by',
                'rejection_notes',
                'is_locked',
            ]);
        });
    }
};
