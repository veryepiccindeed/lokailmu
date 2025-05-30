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
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->string('guru_id');
            $table->foreign('guru_id')->references('idUser')->on('users')->onDelete('cascade');
            $table->string('mentor_id');
            $table->foreign('mentor_id')->references('idUser')->on('users')->onDelete('cascade');
            $table->timestamp('last_message_at')->nullable();
            $table->timestamps();

            $table->unique(['guru_id', 'mentor_id']); // Ensure only one conversation per pair
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
