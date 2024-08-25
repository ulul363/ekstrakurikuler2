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
        Schema::create('pembina', function (Blueprint $table) {
            $table->id('id_pembina');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('ekstrakurikuler_id');
            $table->string('nip', 18)->unique();
            $table->string('nama', 50);
            $table->boolean('status')->default(true);
            // $table->string('alamat', 50);
            // $table->enum('jk', ['L', 'P']);
            // $table->string('no_hp', 15);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('ekstrakurikuler_id')->references('id_ekstrakurikuler')->on('ekstrakurikuler')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembina');
    }
};
