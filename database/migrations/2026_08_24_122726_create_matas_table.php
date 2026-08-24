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
        Schema::create('matas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggota_kelas_id')->constrained('anggota_kelas')->cascadeOnDelete();
            $table->enum('ketajaman_kanan', ['Baik', 'Kurang baik'])->nullable();
            $table->enum('ketajaman_kiri', ['Baik', 'Kurang baik'])->nullable();
            $table->enum('buta_warna', ['Baik', 'Kurang baik'])->nullable();
            $table->enum('radang_kanan', ['Baik', 'Kurang baik'])->nullable();
            $table->enum('radang_kiri', ['Baik', 'Kurang baik'])->nullable();
            $table->enum('juling_kanan', ['Baik', 'Kurang baik'])->nullable();
            $table->enum('juling_kiri', ['Baik', 'Kurang baik'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matas');
    }
};
