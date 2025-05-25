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
        Schema::create('daftarbukuofflines', function (Blueprint $table) {
            $table->string('idOffline')->primary(); // Diubah dari integer ke string
            $table->string('idBuku', 12); // Foreign key
            $table->string('idUser', 12); // Foreign key
            $table->string('pathCache', 255);
            $table->timestamp('tglDownload')->useCurrent(); // Default current_timestamp()
            $table->timestamp('tglAkses')->useCurrent();    // Default current_timestamp()

            // Indexes for foreign keys (performance)
            $table->index('idBuku');
            $table->index('idUser');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftarbukuofflines');
    }
};
