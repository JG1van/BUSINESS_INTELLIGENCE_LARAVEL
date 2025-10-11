<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('jurnal', function (Blueprint $table) {
            $table->id('id_jurnal');

            // Relasi
            $table->unsignedBigInteger('id_user');          // Relasi ke users

            // Data utama
            $table->string('nama_jurnal');                  // Nama Jurnal
            $table->string('singkatan')->nullable();        // Singkatan Nama Jurnal
            $table->string('link')->nullable();             // Link Jurnal

            // Identitas ISSN
            $table->string('issn')->nullable();             // ISSN Cetak
            $table->string('e_issn')->nullable();           // E-ISSN (Online)

            // Bidang & Industri
            $table->enum('bidang', ['Penelitian', 'Pengabdian'])->nullable();
            $table->unsignedBigInteger('id_bidang_ilmu');   // Relasi ke bidang_ilmu

            // Akreditasi Sinta
            $table->string('akreditasi_sinta')->nullable(); // Sinta 1–6 / Non-Sinta
            $table->string('masa_aktif_sinta')->nullable(); // Contoh: 2020–2024

            // Scopus
            $table->string('scopus_index')->nullable();     // Q1–Q4 atau kosong
            $table->string('masa_aktif_scopus')->nullable();// Contoh: 2020–2024

            // Penerbit & lokasi
            $table->string('penerbit')->nullable();
            $table->string('kota_terbit')->nullable();

            $table->timestamps();

            // Relasi ke tabel lain
            $table->foreign('id_user')
                ->references('id_user')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('id_bidang_ilmu')
                ->references('id_bidang_ilmu')
                ->on('bidang_ilmu')
                ->onDelete('cascade');
        });
    }

    /**
     * Rollback migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnal');
    }
};
