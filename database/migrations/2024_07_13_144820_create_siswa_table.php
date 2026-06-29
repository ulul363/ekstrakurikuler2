<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            // Sesuai model Anda, NIS dijadikan primary key bertipe string
            $table->string('nis', 20)->primary();
            $table->string('nama', 100);
            $table->string('alamat', 255);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('email', 100)->unique();
            $table->string('no_hp', 15);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};