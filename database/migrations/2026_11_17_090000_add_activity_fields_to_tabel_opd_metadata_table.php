<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Waktu dan nama pelaku verifikasi Wali Data dan validasi Admin BPS dicatat terpisah,
     * agar riwayat aktivitas di Monitoring menampilkan kejadian yang sebenarnya.
     */
    public function up(): void
    {
        Schema::table('tabel_opd_metadata', function (Blueprint $table) {
            $table->timestamp('walidata_verified_at')->nullable()->after('submitted_by');
            $table->string('walidata_verified_by', 255)->nullable()->after('walidata_verified_at');
            $table->timestamp('validated_at')->nullable()->after('walidata_verified_by');
            $table->string('validated_by', 255)->nullable()->after('validated_at');
        });
    }

    public function down(): void
    {
        Schema::table('tabel_opd_metadata', function (Blueprint $table) {
            $table->dropColumn(['walidata_verified_at', 'walidata_verified_by', 'validated_at', 'validated_by']);
        });
    }
};
