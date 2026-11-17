<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Pernyataan kebenaran data: dicatat saat instansi mengirim tabel ke Wali Data.
     */
    public function up(): void
    {
        Schema::table('tabel_opd_metadata', function (Blueprint $table) {
            $table->boolean('data_declared')->default(false)->after('is_locked');
            $table->timestamp('submitted_at')->nullable()->after('data_declared');
            $table->string('submitted_by', 255)->nullable()->after('submitted_at');
        });
    }

    public function down(): void
    {
        Schema::table('tabel_opd_metadata', function (Blueprint $table) {
            $table->dropColumn(['data_declared', 'submitted_at', 'submitted_by']);
        });
    }
};
