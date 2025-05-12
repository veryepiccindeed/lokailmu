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
        Schema::table('tagthreads', function (Blueprint $table) {
            $table->foreign('idThread', 'FK_idThread_tagThread')
            ->references('idThread')->on('threadforums')
            ->onDelete('no action') // Mungkin 'cascade'? Jika thread dihapus, relasi tagnya juga.
            ->onUpdate('no action');

      $table->foreign('idTag', 'FK_tag_tagThread')
            ->references('idTag')->on('tags')
            ->onDelete('no action') // Mungkin 'cascade'? Jika tag dihapus, relasi threadnya juga.
            ->onUpdate('no action');
         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tagthreads', function (Blueprint $table) {
            $table->dropForeign('FK_idThread_tagThread');
            $table->dropForeign('FK_tag_tagThread');
        });
    }
};
