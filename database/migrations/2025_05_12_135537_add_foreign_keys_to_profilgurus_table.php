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
        Schema::table('profilgurus', function (Blueprint $table) {
            $table->foreign('idSekolah', 'FK_idSekolahr_profilGuru') // Nama constraint dari SQL
            ->references('idSekolah')->on('sekolahs')
            ->onDelete('no action') // Sesuaikan jika perlu
            ->onUpdate('no action');

          // idUser adalah primary key di profilguru, tapi juga foreign key ke user
            $table->foreign('idUser', 'FK_idUser_profilGuru')
            ->references('idUser')->on('users')
            ->onDelete('no action') // Mungkin 'cascade' lebih cocok di sini? Jika user dihapus, profilnya juga.
            ->onUpdate('no action');
         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profilgurus', function (Blueprint $table) {
            $table->dropForeign('FK_idSekolahr_profilGuru');
            $table->dropForeign('FK_idUser_profilGuru');
        });
    }
};
