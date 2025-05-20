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
        Schema::create('profilgurus', function (Blueprint $table) {
            // Tidak ada Primary Key eksplisit di CREATE TABLE SQL,
            // tapi idUser akan jadi foreign key dan logikanya unik/primary.
            // Kita buat idUser sebagai primary key di sini untuk konsistensi model Laravel.
            $table->string('idUser', 12)->primary(); // Foreign key (akan ditambahkan constraint nanti)
            $table->string('NUPTK', 45);
            $table->integer('NPSN', false, true)->length(8); 
            $table->enum('tingkatPengajar', ['SD', 'SMP', 'SMA']);
            $table->string('pathKTP', 255)->nullable();
            $table->timestamps();


            // Index untuk NIP/NUPTK jika sering dicari
            $table->index('NUPTK');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profilgurus');
    }
};
