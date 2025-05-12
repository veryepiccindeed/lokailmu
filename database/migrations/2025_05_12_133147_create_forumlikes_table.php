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
        Schema::create('forumlikes', function (Blueprint $table) {
            $table->bigIncrements('idLike'); // Primary Key BIGINT Auto Increment
            $table->unsignedBigInteger('idPost'); // Foreign key
            $table->string('likeOleh', 12); // Foreign key
            // Perhatikan: ON UPDATE CURRENT_TIMESTAMP sulit direplikasi langsung di Schema Builder
            // Laravel biasanya mengandalkan $table->timestamps() atau event listener/observer
            // Untuk saat ini kita buat timestamp biasa
            $table->timestamp('tglLike')->useCurrent();

            // Indexes
            $table->index('idPost');
            $table->index('likeOleh');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forumlikes');
    }
};
