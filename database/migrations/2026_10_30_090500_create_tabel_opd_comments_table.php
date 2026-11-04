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
        if (!Schema::hasTable('tabel_opd_comments')) {
            Schema::create('tabel_opd_comments', function (Blueprint $table) {
                $table->id();
                $table->string('table_code', 50)->index();
                $table->string('opd_code', 50)->index();
                $table->integer('year')->index();
                $table->string('cell_key', 150)->index();
                $table->string('cell_label', 255)->nullable();
                $table->string('cell_value', 100)->nullable();
                $table->string('user_name', 100)->nullable();
                $table->string('user_role', 50)->default('opd');
                $table->text('comment');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabel_opd_comments');
    }
};

