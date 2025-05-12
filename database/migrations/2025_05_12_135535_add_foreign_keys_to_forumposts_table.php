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
        Schema::table('forumposts', function (Blueprint $table) {
            $table->foreign('idThread', 'FK_idThread_forumPost')
            ->references('idThread')->on('threadforums')
            ->onDelete('no action')
            ->onUpdate('no action');

      $table->foreign('dibuatOleh', 'FK_idUser_forumPost')
            ->references('idUser')->on('users')
            ->onDelete('no action')
            ->onUpdate('no action');

      // Self-referencing foreign key
      $table->foreign('parentPost', 'FK_idPost_parentPost')
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
        Schema::table('forumpost', function (Blueprint $table) {
            $table->dropForeign('FK_idThread_forumPost');
            $table->dropForeign('FK_idUser_forumPost');
            $table->dropForeign('FK_idPost_parentPost');
        });
    }
};
