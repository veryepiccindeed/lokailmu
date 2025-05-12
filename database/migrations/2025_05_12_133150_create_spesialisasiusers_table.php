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
        Schema::create('spesialisasiusers', function (Blueprint $table) {
            $table->bigIncrements('idSpesialisasi'); // Primary Key BIGINT Auto Increment
            $table->string('idUser', 12); // Foreign key
            $table->string('spesialisasi', 45);
            $table->timestamps();

            // Index
            $table->index('idUser');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spesialisasiusers');
    }
};
