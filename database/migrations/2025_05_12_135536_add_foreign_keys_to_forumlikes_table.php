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
        Schema::table('forumlikes', function (Blueprint $table) {
            $table->foreign('idPost', 'FK_idPost_forumLike')
            ->references('idPost')->on('forumposts')
            ->onDelete('no action') // Sesuaikan jika perlu (cascade, set null, restrict)
            ->onUpdate('no action');

      $table->foreign('likeOleh', 'FK_idUser_likeOleh')
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
        Schema::table('forumlikes', function (Blueprint $table) {
            $table->dropForeign('FK_idPost_forumLike');
            $table->dropForeign('FK_idUser_likeOleh');
        });
    }
};
