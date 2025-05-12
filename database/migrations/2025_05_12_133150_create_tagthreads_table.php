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
        Schema::create('tagthreads', function (Blueprint $table) {
            // Tabel pivot (many-to-many) antara threadforum dan tag
            // SQL asli memiliki UNIQUE KEY terpisah, yang aneh.
            // Cara Laravel yang umum adalah composite primary key.
            $table->unsignedBigInteger('idThread'); // Foreign key
            $table->integer('idTag'); // Foreign key

            // Composite primary key untuk memastikan kombinasi unik
            $table->primary(['idThread', 'idTag']);

            // Foreign key constraints akan ditambahkan di migrasi terpisah
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagthreads');
    }
};
