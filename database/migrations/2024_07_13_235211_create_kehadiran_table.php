<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('kehadiran', function (Blueprint $table) {

            $table->id('id_kehadiran');
            $table->unsignedBigInteger('ekstrakurikuler_id');
            $table->unsignedBigInteger('ketua_id');
            $table->unsignedBigInteger('pembina_id')->nullable();
            $table->string('nama_kegiatan', 100);
            $table->integer('tahun_ajaran');
            $table->date('tanggal');
            $table->text('deskripsi');
            $table->string('berkas', 255);
            $table->integer('jumlah_hadir');
            $table->integer('jumlah_anggota');
            $table->enum('status', [
                'pending',
                'disetujui',
                'ditolak'
            ])->default('pending');
            $table->text('keterangan_pembina')->nullable();
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
        Schema::dropIfExists('kehadiran');
    }
};
