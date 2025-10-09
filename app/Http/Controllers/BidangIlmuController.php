<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BidangIlmu;

class BidangIlmuController extends Controller
{
    public function index()
    {
        $bidangIlmu = BidangIlmu::orderBy('id_bidang_ilmu')->get();
        return view('pengaturan.bidang-ilmu', compact('bidangIlmu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_bidang_ilmu' => 'required|string|max:100|unique:bidang_ilmu,nama_bidang_ilmu',
        ]);

        BidangIlmu::create(['nama_bidang_ilmu' => $request->nama_bidang_ilmu]);

        return redirect()->route('bidang-ilmu.index')->with('success', 'Bidang ilmu berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $bidang = BidangIlmu::findOrFail($id);

        $request->validate([
            'nama_bidang_ilmu' => 'required|string|max:100|unique:bidang_ilmu,nama_bidang_ilmu,' . $id . ',id_bidang_ilmu',
        ]);

        $bidang->update(['nama_bidang_ilmu' => $request->nama_bidang_ilmu]);

        return redirect()->route('bidang-ilmu.index')->with('success', 'Bidang ilmu berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $bidang = BidangIlmu::findOrFail($id);
        $bidang->delete();

        return redirect()->route('bidang-ilmu.index')->with('success', 'Bidang ilmu berhasil dihapus!');
    }
}
