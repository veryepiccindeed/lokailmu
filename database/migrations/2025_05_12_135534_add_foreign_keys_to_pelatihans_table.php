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
        Schema::table('pelatihans', function (Blueprint $table) {
            $table->foreign('idMentor', 'FK_idMentor_pelatihan') // Nama constraint opsional tapi baik
                  ->references('idUser')->on('users')
                  ->onDelete('no action') // Sesuaikan jika perlu (cascade, set null, restrict)
                  ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelatihans', function (Blueprint $table) {
            $table->dropForeign('FK_idMentor_pelatihan'); // Gunakan nama constraint jika didefinisikan
            // atau $table->dropForeign(['idMentor']); jika tidak pakai nama
        });
    }
};
