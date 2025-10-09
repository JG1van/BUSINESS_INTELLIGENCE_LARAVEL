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
                    WHEN akreditasi_sinta REGEXP '^Sinta [1-6]$' THEN akreditasi_sinta
                    ELSE 'Tidak Terakreditasi'
                END as kategori,
                COUNT(*) as total
            ")
            ->groupBy('kategori')
            ->pluck('total', 'kategori')
            ->toArray();

        // Grafik batang SINTA (urutkan)
        $sintaLabels = ['Sinta 1', 'Sinta 2', 'Sinta 3', 'Sinta 4', 'Sinta 5', 'Sinta 6', 'Tidak Terakreditasi'];
        $sintaData = array_map(fn($label) => $sintaCounts[$label] ?? 0, $sintaLabels);

        // Scopus (Q0–Q4)
        $scopusCounts = Jurnal::selectRaw("
                CASE
                    WHEN scopus_index REGEXP '^Q[0-4]$' THEN scopus_index
                    ELSE 'Tidak Terindeks'
                END as kategori,
                COUNT(*) as total
            ")
            ->groupBy('kategori')
            ->pluck('total', 'kategori')
            ->toArray();

        $scopusLabels = ['Q0', 'Q1', 'Q2', 'Q3', 'Q4', 'Tidak Terindeks'];
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
