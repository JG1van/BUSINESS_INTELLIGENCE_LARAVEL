<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use App\Models\BidangIlmu;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Total jurnal
        $totalJurnal = Jurnal::count();

        // Total jurnal SINTA (1-6)
        $sintaCounts = Jurnal::selectRaw("
    CASE
        WHEN akreditasi_sinta REGEXP '^S[1-6]$' THEN akreditasi_sinta
        WHEN akreditasi_sinta = 'Blm_akreditasi' THEN 'Blm_akreditasi'
        ELSE 'Blm_akreditasi'
    END as kategori,
    COUNT(*) as total
")
            ->groupBy('kategori')
            ->pluck('total', 'kategori')
            ->toArray();

        // Urutkan label untuk grafik
        $sintaLabels = ['S1', 'S2', 'S3', 'S4', 'S5', 'S6', 'Blm_akreditasi'];
        $sintaData = array_map(fn($label) => $sintaCounts[$label] ?? 0, $sintaLabels);


        // Scopus (Q0–Q4)
        $scopusCounts = Jurnal::selectRaw("
    CASE
        WHEN scopus_index REGEXP '^Q[1-4]$' THEN scopus_index
        WHEN scopus_index = 'Blm_scopus' THEN 'Blm_scopus'
        ELSE 'Blm_scopus'
    END as kategori,
    COUNT(*) as total
")
            ->groupBy('kategori')
            ->pluck('total', 'kategori')
            ->toArray();

        $scopusLabels = ['Q1', 'Q2', 'Q3', 'Q4', 'Blm_scopus'];
        $scopusData = array_map(fn($label) => $scopusCounts[$label] ?? 0, $scopusLabels);

        // Kategori berdasarkan bidang ilmu
        $bidangIlmuLabels = BidangIlmu::pluck('nama_bidang_ilmu')->toArray();
        $bidangIlmuData = [];
        foreach ($bidangIlmuLabels as $bidang) {
            $bidangIlmuData[] = Jurnal::whereHas('bidangIlmu', fn($q) => $q->where('nama_bidang_ilmu', $bidang))->count();
        }

        return view('dashboard', compact(
            'totalJurnal',
            'sintaLabels',
            'sintaData',
            'scopusLabels',
            'scopusData',
            'bidangIlmuLabels',
            'bidangIlmuData'
        ));
    }
}
