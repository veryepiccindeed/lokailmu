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
        Schema::create('forumposts', function (Blueprint $table) {
            $table->bigIncrements('idPost'); // Primary Key BIGINT Auto Increment
            $table->string('idThread'); // Diubah dari unsignedBigInteger ke string
            $table->string('dibuatOleh', 12); // Foreign key
            $table->text('isi');
            $table->unsignedBigInteger('parentPost')->nullable(); // Foreign key (self-reference)
            $table->timestamp('tglPost')->useCurrent(); // Default CURRENT_TIMESTAMP

            // Indexes
            $table->index('idThread');
            $table->index('dibuatOleh');
            $table->index('parentPost');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forumposts');
    }
};
