<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('nilai_karakters')->truncate();
        DB::table('data_karakters')->truncate();
        DB::table('karakters')->truncate();

        Schema::table('karakters', function (Blueprint $table) {
            $table->bigIncrements('id')->change();
        });

        Schema::table('data_karakters', function (Blueprint $table) {
            $table->unsignedBigInteger('karakter_id')->change();
            $table->foreign('karakter_id')
                  ->references('id')
                  ->on('karakters')
                  ->onDelete('cascade');
        });

        Schema::table('nilai_karakters', function (Blueprint $table) {
            $table->unsignedBigInteger('karakter_id')->change();
            $table->foreign('karakter_id')
                  ->references('id')
                  ->on('karakters')
                  ->onDelete('cascade');
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::table('data_karakters', function (Blueprint $table) {
            $table->dropForeign(['karakter_id']);
        });

        Schema::table('nilai_karakters', function (Blueprint $table) {
            $table->dropForeign(['karakter_id']);
        });

        Schema::table('karakters', function (Blueprint $table) {
            $table->string('id', 10)->change();
        });

        Schema::table('data_karakters', function (Blueprint $table) {
            $table->string('karakter_id', 10)->change();
        });

        Schema::table('nilai_karakters', function (Blueprint $table) {
            $table->string('karakter_id', 10)->change();
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};