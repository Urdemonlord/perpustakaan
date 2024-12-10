<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('denda', function (Blueprint $table) {
            $table->id('id_denda');
            $table->unsignedBigInteger('id_peminjaman');
            $table->date('tanggal_denda');
            $table->integer('jumlah_hari');
            $table->decimal('jumlah_denda', 10, 2);
            $table->enum('status', ['belum dibayar', 'sudah dibayar'])->default('belum dibayar');
            $table->timestamps();

            $table->foreign('id_peminjaman')->references('id_peminjaman')->on('peminjaman')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('denda');
    }
}; 