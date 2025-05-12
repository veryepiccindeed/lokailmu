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
        Schema::create('pelatihans', function (Blueprint $table) {
            $table->string('idPelatihan', 15)->primary();
            $table->string('judul', 100);
            $table->text('deskripsi');
            $table->decimal('biaya', 15, 2);
            $table->string('idMentor', 12); // Foreign key akan ditambahkan nanti
            $table->timestamps();

            // Index untuk foreign key (opsional tapi bagus untuk performa)
            $table->index('idMentor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelatihans');
    }
};
