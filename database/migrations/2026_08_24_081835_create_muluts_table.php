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
        Schema::create('muluts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggota_kelas_id')->constrained('anggota_kelas')->cascadeOnDelete();
            $table->enum('kesehatan_mulut', ['Baik', 'Kurang baik']);
            $table->string('keterangan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('muluts');
    }
};
