<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bidang_ilmu', function (Blueprint $table) {
            $table->id('id_bidang_ilmu');
            $table->string('nama_bidang_ilmu')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bidang_ilmu');
    }
};
