<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('program_kegiatan', function (Blueprint $table) {

            $table->id('id_program_kegiatan');

            $table->unsignedBigInteger('ekstrakurikuler_id');

            $table->unsignedBigInteger('ketua_id');

            $table->unsignedBigInteger('pembina_id')->nullable();

            $table->string('nama_program', 100);

            $table->integer('tahun_ajaran');

            $table->text('deskripsi');

            $table->enum('status', [
                'pending',
                'disetujui',
                'ditolak'
            ])->default('pending');

            $table->enum('status_pelaksanaan', [
                'belum',
                'terlaksana'
            ])->default('belum');

            $table->text('keterangan')->nullable();

            $table->timestamps();

            $table->foreign('ekstrakurikuler_id')
                ->references('id_ekstrakurikuler')
                ->on('ekstrakurikuler');

            $table->foreign('ketua_id')
                ->references('id_ketua')
                ->on('ketua');

            $table->foreign('pembina_id')
                ->references('id_pembina')
                ->on('pembina');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_kegiatan');
    }
};