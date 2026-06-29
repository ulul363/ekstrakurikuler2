<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengajuan_pertemuan', function (Blueprint $table) {
            $table->id('id_pengajuan');

            $table->unsignedBigInteger('ekstrakurikuler_id');
            $table->unsignedBigInteger('ketua_id');
            $table->unsignedBigInteger('pembina_id')->nullable();

            $table->string('judul_pertemuan', 150);
            $table->date('tanggal_rencana');
            $table->time('waktu_rencana');
            $table->text('agenda_pertemuan');

            $table->enum('status', [
                'pending',
                'disetujui',
                'ditolak'
            ])->default('pending');

            $table->text('keterangan_pembina')->nullable();

            $table->timestamps();

            // Relasi
            $table->foreign('ekstrakurikuler_id')->references('id_ekstrakurikuler')->on('ekstrakurikuler')->cascadeOnDelete();
            $table->foreign('ketua_id')->references('id_ketua')->on('ketua')->cascadeOnDelete();
            $table->foreign('pembina_id')->references('id_pembina')->on('pembina')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_pertemuan');
    }
};
