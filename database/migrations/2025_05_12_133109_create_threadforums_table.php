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
        Schema::create('threadforums', function (Blueprint $table) {
            $table->string('idThread')->primary();
            $table->string('judul', 255);
            $table->string('dibuatOleh');
            $table->unsignedBigInteger('idPostUtama')->nullable(); // Changed back to unsignedBigInteger
            $table->timestamps();

            // Index untuk foreign key
            $table->index('idPostUtama');
            $table->index('dibuatOleh');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('threadforums');
    }
};
