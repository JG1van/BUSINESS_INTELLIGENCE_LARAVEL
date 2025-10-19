<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BidangIlmuSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk tabel bidang_ilmu.
     */
    public function run(): void
    {
        $data = [
            ['nama_bidang_ilmu' => 'Informatika Komputer'],
            ['nama_bidang_ilmu' => 'Elektro'],
            ['nama_bidang_ilmu' => 'Manajemen'],
            ['nama_bidang_ilmu' => 'Akuntansi'],
            ['nama_bidang_ilmu' => 'Hukum'],
            ['nama_bidang_ilmu' => 'Sastra Inggris'],
            ['nama_bidang_ilmu' => 'Sastra Indonesia'],
            ['nama_bidang_ilmu' => 'Sastra Arab'],
            ['nama_bidang_ilmu' => 'Pertanian'],
            ['nama_bidang_ilmu' => 'Sipil'],
            ['nama_bidang_ilmu' => 'Arsitektur'],
            ['nama_bidang_ilmu' => 'Industri'],
            ['nama_bidang_ilmu' => 'Kimia'],
            ['nama_bidang_ilmu' => 'Kedokteran'],
            ['nama_bidang_ilmu' => 'Kehutanan'],
            ['nama_bidang_ilmu' => 'Kedokteran Gigi'],
            ['nama_bidang_ilmu' => 'Kedokteran Hewan'],
            ['nama_bidang_ilmu' => 'Sciene'],
            ['nama_bidang_ilmu' => 'Psikologi'],
            ['nama_bidang_ilmu' => 'Komunikasi'],
            ['nama_bidang_ilmu' => 'Sosial & Politik'],
            ['nama_bidang_ilmu' => 'Keperawatan'],
            ['nama_bidang_ilmu' => 'Kesehatan'],
            ['nama_bidang_ilmu' => 'Pariwisata'],
            ['nama_bidang_ilmu' => 'Pendidikan'],
            ['nama_bidang_ilmu' => 'Ekonomi'],
            ['nama_bidang_ilmu' => 'Islam'],
            ['nama_bidang_ilmu' => 'Sejarah'],
            ['nama_bidang_ilmu' => 'Bisnis'],
        ];

        DB::table('bidang_ilmu')->insert($data);
    }
}
