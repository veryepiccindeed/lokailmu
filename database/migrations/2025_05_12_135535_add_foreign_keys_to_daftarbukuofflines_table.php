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
        Schema::table('daftarbukuofflines', function (Blueprint $table) {
            $table->foreign('idBuku', 'FK_idBuku_bukuOffline')
            ->references('idBuku')->on('daftarbukus')
            ->onDelete('no action')
            ->onUpdate('no action');

      $table->foreign('idUser', 'FK_idUser_bukuOffline')
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
        Schema::table('daftarbukuofflines', function (Blueprint $table) {
            $table->dropForeign('FK_idBuku_bukuOffline');
            $table->dropForeign('FK_idUser_bukuOffline');
        });
    }
};
