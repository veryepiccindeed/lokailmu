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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->string('idTransaksi', 25)->primary(); // Primary Key VARCHAR
            $table->string('idGuru', 12); // Foreign key (merujuk ke user)
            $table->string('idPelatihan', 15); // Foreign key
            $table->decimal('total', 15, 2);
            $table->decimal('jumlahDP', 15, 2);
            $table->enum('statusByr', [
                'Pending', 'DP Terbayar', 'Lunas', 'Gagal'
            ]);
            $table->timestamp('tglBayarDP')->nullable();
            $table->timestamp('tglLunas')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('idGuru');
            $table->index('idPelatihan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
