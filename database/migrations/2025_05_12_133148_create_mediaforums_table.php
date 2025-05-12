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
        Schema::create('mediaforums', function (Blueprint $table) {
            $table->bigIncrements('idmedia'); // Primary Key BIGINT Auto Increment
            $table->unsignedBigInteger('idPost'); // Foreign key
            $table->string('urlMedia', 255);
            $table->timestamps();

            // Index
            $table->index('idPost');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mediaforums');
    }
};
