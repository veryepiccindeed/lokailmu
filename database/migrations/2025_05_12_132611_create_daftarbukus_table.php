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
        Schema::create('daftarbukus', function (Blueprint $table) {
            $table->string('idBuku', 12)->primary();
            $table->string('judul', 255);
            $table->text('deskripsi');
            $table->string('penulis', 255);
            $table->date('tglTerbit');
            $table->string('urlCover', 255);
            $table->enum('genre', [
                'Matematika', 'Bahasa Indonesia', 'IPA', 'Sejarah', 'Geografi', 'IPS'
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftarbukus');
    }
};
