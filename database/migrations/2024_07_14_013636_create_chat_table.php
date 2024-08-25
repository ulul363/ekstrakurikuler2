<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chat', function (Blueprint $table) {
            $table->id('id_chat')->autoIncrement();
            $table->text('pesan');
            $table->string('pengirim');
            $table->unsignedBigInteger('pengajuan_pertemuan_id')->nullable();
            $table->timestamps();

            // $table->foreign('ketua_id')->references('id_ketua')->on('ketua')->ondelete('restrict')->onupdate('restrict');
            // $table->foreign('pembina_id')->references('id_pembina')->on('pembina')->ondelete('restrict')->onupdate('restrict');
            $table->foreign('pengajuan_pertemuan_id')->references('id_pengajuan_pertemuan')->on('pengajuan_pertemuan')->ondelete('restrict')->onupdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat');
    }
};
