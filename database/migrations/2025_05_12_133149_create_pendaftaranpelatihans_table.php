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
        Schema::create('pendaftaranpelatihans', function (Blueprint $table) {
            $table->bigIncrements('id'); // Primary Key BIGINT Auto Increment
            $table->string('idPelatihan', 15); // Foreign key
            $table->string('idUser', 12); // Foreign key
            $table->enum('status', ['pending', 'ongoing', 'done', 'cancelled'])->default('pending');
            $table->timestamp('tglMulai')->useCurrent();
            $table->timestamp('tglSelesai')->useCurrent();
            $table->timestamps();

            // Indexes
            $table->index('idPelatihan');
            $table->index('idUser');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaranpelatihans');
    }
};
