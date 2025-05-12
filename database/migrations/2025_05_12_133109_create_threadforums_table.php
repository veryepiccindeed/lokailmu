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
            $table->bigIncrements('idThread'); // Primary Key BIGINT Auto Increment
            $table->string('judul', 255);
            $table->unsignedBigInteger('idPostUtama'); // Foreign key akan ditambahkan nanti
            $table->timestamps();

            // Index untuk foreign key
            $table->index('idPostUtama');
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
