<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('prestasi', function (Blueprint $table) {

            $table->id('id_prestasi');

            $table->unsignedBigInteger('ekstrakurikuler_id');

            $table->unsignedBigInteger('ketua_id');

            $table->unsignedBigInteger('pembina_id')->nullable();

            $table->string('prestasi', 100);

            $table->enum('tingkat', [
                'kabupaten',
                'provinsi',
                'nasional'
            ]);

            $table->integer('skor_prestasi')->default(0);

            $table->json('nama_siswa');

            $table->integer('tahun_ajaran');

            $table->string('berkas', 255);

            $table->enum('status', [
                'pending',
                'disetujui',
                'ditolak'
            ])->default('pending');

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
        Schema::dropIfExists('prestasi');
    }
};
