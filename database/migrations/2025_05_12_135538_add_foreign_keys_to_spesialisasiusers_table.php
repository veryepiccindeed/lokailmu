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
        Schema::table('spesialisasiusers', function (Blueprint $table) {
            $table->foreign('idUser', 'FK_idUser_spesialisasi')
            ->references('idUser')->on('users')
            ->onDelete('no action') // Mungkin 'cascade' lebih cocok?
            ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spesialisasiusers', function (Blueprint $table) {
            $table->dropForeign('FK_idUser_spesialisasi');
        });
    }
};
