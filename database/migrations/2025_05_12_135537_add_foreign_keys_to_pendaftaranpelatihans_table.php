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
        Schema::table('pendaftaranpelatihans', function (Blueprint $table) {
            $table->foreign('idPelatihan', 'FK_idPelatihan_pendaftaran')
                  ->references('idPelatihan')->on('pelatihans')
                  ->onDelete('no action') // Sesuaikan jika perlu
                  ->onUpdate('no action');

            $table->foreign('idUser', 'FK_idUser_pelatihan')
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
        Schema::table('pendaftaranpelatihans', function (Blueprint $table) {
            $table->dropForeign('FK_idPelatihan_pendaftaran');
            $table->dropForeign('FK_idUser_pelatihan');
        });
    }
};
