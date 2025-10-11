<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use App\Models\BidangIlmu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JurnalController extends Controller
{
    // --- TAMPILAN UMUM (semua jurnal)
    public function index()
    {
        $jurnals = Jurnal::with('bidangIlmu', 'user')
            ->orderBy('id_jurnal', 'desc')
            ->get();

        $bidangIlmus = BidangIlmu::orderBy('nama_bidang_ilmu')->get();

        return view('jurnal.index', compact('jurnals', 'bidangIlmus'));
    }

    // --- TAMPILAN KHUSUS (halaman pengaturan user)
// --- TAMPILAN KHUSUS (halaman pengaturan user / admin)
    public function manage()
    {
        // Ambil user login
        $user = Auth::user();

        // Jika admin → tampilkan semua jurnal
        if ($user->role === 'admin') {
            $jurnals = Jurnal::with('bidangIlmu', 'user')
                ->orderBy('id_jurnal', 'desc')
                ->get();
        }
        // Jika user biasa → hanya tampilkan miliknya
        else {
            $jurnals = Jurnal::where('id_user', $user->id_user)
                ->with('bidangIlmu', 'user')
                ->orderBy('id_jurnal', 'desc')
                ->get();
        }

        $bidangIlmus = BidangIlmu::orderBy('nama_bidang_ilmu')->get();

        return view('pengaturan.jurnal', compact('jurnals', 'bidangIlmus'));
    }


    // --- SIMPAN DATA BARU
    public function storeJurnal(Request $request)
    {
        $request->validate([
            'nama_jurnal' => 'required|string|max:255',
            'singkatan' => 'nullable|string|max:255',
            'link' => 'nullable|url',
            'issn' => 'nullable|string|max:50',
            'e_issn' => 'nullable|string|max:50',
            'id_bidang_ilmu' => 'required|integer',
            'bidang' => 'nullable|string|max:255',
            'akreditasi_sinta' => 'nullable|string|max:100',
            'masa_aktif_sinta' => 'nullable|string|max:100',
            'scopus_index' => 'nullable|string|max:100',
            'masa_aktif_scopus' => 'nullable|string|max:100',
            'penerbit' => 'nullable|string|max:255',
            'kota_terbit' => 'nullable|string|max:255',
        ]);

        Jurnal::create([
            'id_user' => Auth::id(),
            'id_bidang_ilmu' => $request->id_bidang_ilmu,
            'nama_jurnal' => $request->nama_jurnal,
            'singkatan' => $request->singkatan,
            'link' => $request->link,
            'issn' => $request->issn,
            'e_issn' => $request->e_issn,
            'bidang' => $request->bidang,
            'akreditasi_sinta' => $request->akreditasi_sinta,
            'masa_aktif_sinta' => $request->masa_aktif_sinta,
            'scopus_index' => $request->scopus_index,
            'masa_aktif_scopus' => $request->masa_aktif_scopus,
            'penerbit' => $request->penerbit,
            'kota_terbit' => $request->kota_terbit,
        ]);

        return redirect()->route('pengaturan.jurnal')
            ->with('success', 'Data jurnal berhasil ditambahkan.');
    }

    // --- UPDATE DATA JURNAL
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_jurnal' => 'required|string|max:255',
            'link' => 'nullable|url',
            'issn' => 'nullable|string|max:50',
            'e_issn' => 'nullable|string|max:50',
            'kota_terbit' => 'nullable|string|max:255',
        ]);

        $jurnal = Jurnal::findOrFail($id);

        // Hanya pemilik jurnal yang boleh mengedit
        if ($jurnal->id_user !== Auth::id()) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit jurnal ini.');
        }

        $jurnal->update([
            'nama_jurnal' => $request->nama_jurnal,
            'singkatan' => $request->singkatan,
            'link' => $request->link,
            'issn' => $request->issn,
            'e_issn' => $request->e_issn,
            'bidang' => $request->bidang,
            'id_bidang_ilmu' => $request->id_bidang_ilmu,
            'akreditasi_sinta' => $request->akreditasi_sinta,
            'masa_aktif_sinta' => $request->masa_aktif_sinta,
            'scopus_index' => $request->scopus_index,
            'masa_aktif_scopus' => $request->masa_aktif_scopus,
            'penerbit' => $request->penerbit,
            'kota_terbit' => $request->kota_terbit,
        ]);

        return redirect()->route('pengaturan.jurnal')
            ->with('success', 'Data jurnal berhasil diperbarui.');
    }

    // --- HAPUS DATA JURNAL
    public function destroy($id)
    {
        $jurnal = Jurnal::findOrFail($id);

        // Hanya pemilik jurnal yang boleh menghapus
        if ($jurnal->id_user !== Auth::id()) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus jurnal ini.');
        }

        $jurnal->delete();

        return redirect()->route('pengaturan.jurnal')
            ->with('success', 'Data jurnal berhasil dihapus.');
    }
}
