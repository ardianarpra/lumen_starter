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
        Schema::create('gd_kategori_penilaian_pivot', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gawat_darurat_id')->constrained('gawat_darurat')->onDelete('cascade');
            $table->foreignId('kategori_penilaian_id')
                ->constrained('gd_kategori_penilaian')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gd_kategori_penilaian_pivot');
    }
};
