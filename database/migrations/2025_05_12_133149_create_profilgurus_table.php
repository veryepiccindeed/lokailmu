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
            $table->string('NUPTK', 45); // Nama kolom dengan '/' mungkin perlu perhatian di Model Eloquent
            $table->integer('idSekolah'); // Foreign key
            $table->enum('tingkatPengajar', ['SD', 'SMP', 'SMA']);
            $table->string('pathKTP', 255)->nullable();
            $table->timestamps();

            // Indexes (selain PK)
            $table->index('idSekolah');
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
