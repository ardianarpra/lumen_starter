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
        Schema::create('gawat_darurat', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_gawat_darurat');
            $table->string('nama_pelapor');
            $table->string('telp_pelapor');
            $table->double('latitude');
            $table->double('longitude');
            $table->string('penilaian');
            $table->string('keterangan_penilaian');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gawat_darurat');
    }
};
