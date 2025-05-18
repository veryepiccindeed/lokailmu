<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftaranpelatihans', function (Blueprint $table) {
            $table->string('status')->default('ongoing')->after('tglSelesai');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftaranpelatihans', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}; 