<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BidangIlmu;
use App\Models\Jurnal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportJurnalController extends Controller
{
    public function index()
    {
        return view('pengaturan.import-jurnal');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv|max:4096'
        ]);

        $file = $request->file('file');

        try {
            // Gunakan reader tanpa evaluasi formula
            $reader = IOFactory::createReaderForFile($file->getRealPath());
            $reader->setReadDataOnly(true);

            if (method_exists($reader, 'setReadEmptyCells')) {
                $reader->setReadEmptyCells(false);
            }

            $spreadsheet = $reader->load($file->getRealPath());
        } catch (\PhpOffice\PhpSpreadsheet\Calculation\Exception $e) {
            return back()->withErrors([
                'file' => 'Terjadi kesalahan membaca file Excel. Pastikan tidak ada formula kompleks seperti "=Sinta 2 !A2".'
            ]);
        } catch (\Exception $e) {
            return back()->withErrors([
                'file' => 'File tidak bisa dibaca. Pastikan format .xlsx atau .csv valid.'
            ]);
        }

        $totalImported = 0;

        DB::beginTransaction();
        try {
            foreach ($spreadsheet->getWorksheetIterator() as $sheet) {
                $rows = $sheet->toArray(null, true, true, true);

                // Lewati header (baris pertama)
                foreach (array_slice($rows, 1) as $row) {

                    // ✅ Bersihkan semua spasi/tab/newline di setiap cell
                    foreach ($row as &$cell) {
                        if (is_string($cell)) {
                            // Hapus spasi di awal/akhir & ubah tab/newline jadi 1 spasi
                            $cell = trim(preg_replace('/\s+/', ' ', $cell));
                            // Jika cell adalah formula Excel (=...), kosongkan
                            if (str_starts_with($cell, '='))
                                $cell = '';
                        }
                    }
                    unset($cell); // hapus referensi

                    // ✅ Cek apakah semua kolom A–N terisi
                    $isComplete = true;
                    foreach (range('A', 'N') as $col) {
                        if (empty(trim($row[$col] ?? ''))) {
                            $isComplete = false;
                            break;
                        }
                    }

                    if (!$isComplete)
                        continue; // lewati baris jika ada kolom kosong

                    $namaJurnal = trim($row['B']);

                    // ✅ Cek duplikat nama jurnal
                    if (Jurnal::where('nama_jurnal', $namaJurnal)->exists())
                        continue;

                    // ✅ Cek atau buat bidang ilmu
                    $bidangIlmuNama = trim($row['H']);
                    $bidangIlmu = BidangIlmu::firstOrCreate([
                        'nama_bidang_ilmu' => $bidangIlmuNama
                    ]);

                    // ✅ Batasi panjang link
                    $link = isset($row['D']) ? substr($row['D'], 0, 255) : null;

                    // ✅ Simpan data
                    Jurnal::create([
                        'id_user' => Auth::id(),
                        'nama_jurnal' => $namaJurnal,
                        'singkatan' => $row['C'],
                        'link' => $link,
                        'issn' => $row['E'],
                        'e_issn' => $row['F'],
                        'bidang' => $row['G'],
                        'id_bidang_ilmu' => $bidangIlmu->id_bidang_ilmu,
                        'akreditasi_sinta' => $row['I'],
                        'masa_aktif_sinta' => $row['J'],
                        'scopus_index' => $row['K'],
                        'masa_aktif_scopus' => $row['L'],
                        'penerbit' => $row['M'],
                        'lokasi_terbit' => $row['N'],
                    ]);

                    $totalImported++;
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['file' => 'Gagal mengimpor data: ' . $e->getMessage()]);
        }

        return redirect()->back()->with('success', "✅ Import selesai! Total {$totalImported} jurnal berhasil dimasukkan.");
    }
}
