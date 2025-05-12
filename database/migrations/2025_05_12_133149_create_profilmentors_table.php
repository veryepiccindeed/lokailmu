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
        Schema::create('profilmentors', function (Blueprint $table) {
             // Sama seperti profilguru, idUser jadi primary key
             $table->string('idUser', 12)->primary(); // Foreign key
             $table->string('pathCV', 255);
             $table->string('pathSertifikat', 255);
             $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profilmentors');
    }
};
