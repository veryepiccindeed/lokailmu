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
        Schema::table('threadforums', function (Blueprint $table) {
           // Perhatian: idPostUtama merujuk ke forumpost.idPost
           $table->foreign('idPostUtama', 'FK_idPost_postUtama')
           ->references('idPost')->on('forumposts')
           ->onDelete('no action')
           ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('threadforums', function (Blueprint $table) {
            $table->dropForeign('FK_idPost_postUtama');
        });
    }
};
