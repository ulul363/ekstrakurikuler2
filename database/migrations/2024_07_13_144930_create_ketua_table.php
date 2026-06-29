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
        Schema::create('ketua', function (Blueprint $table) {
            $table->id('id_ketua');

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->unsignedBigInteger('ekstrakurikuler_id');

            $table->string('nis', 20)->unique();
            $table->string('nama', 100);

            $table->boolean('status')->default(true);

            $table->timestamps();

            $table->foreign('ekstrakurikuler_id')
                ->references('id_ekstrakurikuler')
                ->on('ekstrakurikuler');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ketua');
    }
};
