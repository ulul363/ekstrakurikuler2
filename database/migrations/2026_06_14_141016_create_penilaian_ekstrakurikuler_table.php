<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('penilaian_ekstrakurikuler', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('ekstrakurikuler_id')->unique();

            $table->double('c1_kehadiran')->default(0);
            $table->double('c2_prestasi')->default(0);
            $table->double('c3_program_kerja')->default(0);
            $table->double('c4_intensitas')->default(0);
            $table->double('nilai_akhir')->nullable();
            $table->integer('ranking')->nullable();

            $table->timestamps();

            $table->foreign('ekstrakurikuler_id')
                ->references('id_ekstrakurikuler')
                ->on('ekstrakurikuler')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaian_ekstrakurikuler');
    }
};
