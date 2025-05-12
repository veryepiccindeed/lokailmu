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
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->foreign('idPelatihan', 'FK_idPelatihan_pembayaran')
            ->references('idPelatihan')->on('pelatihans')
            ->onDelete('no action') // Sesuaikan jika perlu
            ->onUpdate('no action');

      // Ingat: idGuru merujuk ke tabel user
      $table->foreign('idGuru', 'FK_idUser_pembayaran')
            ->references('idUser')->on('users')
            ->onDelete('no action')
            ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->dropForeign('FK_idPelatihan_pembayaran');
            $table->dropForeign('FK_idUser_pembayaran');
        });
    }
};
