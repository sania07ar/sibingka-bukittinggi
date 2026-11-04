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
        Schema::create('monitoring_stages', function (Blueprint $table) {
            $table->id();
            $table->string('agency_type', 20)->default('opd'); // 'opd' or 'instansi'
            $table->string('agency_code', 50);
            $table->integer('year');
            $table->tinyInteger('stage')->default(1); // 1: Persiapan, 2: Input Data, 3: Verifikasi, 4: Validasi BPS, 5: Publikasi
            $table->string('status_text', 100)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['agency_type', 'agency_code', 'year'], 'uniq_agency_yr_stage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoring_stages');
    }
};
