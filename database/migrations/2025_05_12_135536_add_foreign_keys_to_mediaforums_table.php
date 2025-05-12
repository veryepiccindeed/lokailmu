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
        Schema::table('mediaforums', function (Blueprint $table) {
            $table->foreign('idPost', 'FK_idPost_mediaForum')
            ->references('idPost')->on('forumposts')
            ->onDelete('no action') // Sesuaikan jika perlu
            ->onUpdate('no action');
         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mediaforums', function (Blueprint $table) {
            $table->dropForeign('FK_idPost_mediaForum');
        });
    }
};
