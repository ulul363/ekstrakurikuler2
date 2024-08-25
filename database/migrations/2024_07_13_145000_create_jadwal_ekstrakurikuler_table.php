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
        Schema::create('jadwal_ekstrakurikuler', function (Blueprint $table) {
            $table->id('id_jadwal_ekstrakurikuler');
            $table->unsignedBigInteger('ekstrakurikuler_id');
            $table->string('hari', 8);
            $table->time('waktu');
            $table->string('lokasi', 30);
            $table->timestamps();

            $table->foreign('ekstrakurikuler_id')->references('id_ekstrakurikuler')->on('ekstrakurikuler')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_ekstrakurikuler');
    }
};