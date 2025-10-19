<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BidangIlmu;
use App\Models\User;
use App\Models\Jurnal;

class PengaturanController extends Controller
{
    // 🏠 Halaman utama pengaturan
    public function index()
    {
        return view('pengaturan.index');
    }

    // 👤 Halaman profil
    public function profil()
    {
        $user = Auth::user();
        return view('pengaturan.profil', compact('user'));
    }

    // 📚 Manajemen Bidang Ilmu
    public function bidangIlmu()
    {
        $bidangIlmu = BidangIlmu::orderBy('id_bidang_ilmu', 'asc')->get();
        return view('pengaturan.bidang-ilmu', compact('bidangIlmu'));
    }

    public function storeBidangIlmu(Request $request)
    {
        $request->validate([
            'nama_bidang_ilmu' => 'required|string|max:100|unique:bidang_ilmu,nama_bidang_ilmu',
        ]);

        BidangIlmu::create([
            'nama_bidang_ilmu' => $request->nama_bidang_ilmu,
        ]);

        return redirect()->route('pengaturan.bidang-ilmu')->with('success', 'Bidang ilmu berhasil ditambahkan.');
    }

    public function updateBidangIlmu(Request $request, $id)
    {
        $request->validate([
            'nama_bidang_ilmu' => 'required|string|max:100|unique:bidang_ilmu,nama_bidang_ilmu,' . $id . ',id_bidang_ilmu',
        ]);

        $bidang = BidangIlmu::findOrFail($id);
        $bidang->update(['nama_bidang_ilmu' => $request->nama_bidang_ilmu]);

        return redirect()->route('pengaturan.bidang-ilmu')->with('success', 'Bidang ilmu berhasil diperbarui.');
    }

    public function destroyBidangIlmu($id)
    {
        $bidang = BidangIlmu::findOrFail($id);
        $bidang->delete();

        return redirect()->route('pengaturan.bidang-ilmu')->with('success', 'Bidang ilmu berhasil dihapus.');
    }

    // 📖 Manajemen Jurnal
    public function manajemenJurnal()
    {
        $jurnals = Jurnal::with('bidangIlmu')->orderBy('id_jurnal', 'asc')->get();
        $bidangIlmus = BidangIlmu::orderBy('nama_bidang_ilmu', 'asc')->get();

        return view('pengaturan.jurnal', compact('jurnals', 'bidangIlmus'));
    }

    // 👥 Manajemen Pengguna
    public function pengguna()
    {
        $users = User::orderBy('id_user', 'asc')->get();
        return view('pengaturan.pengguna', compact('users'));
    }


    public function storePengguna(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:user,admin',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('pengaturan.pengguna')->with('success', 'Pengguna berhasil ditambahkan.');
    }


    // 🔄 Aktif/Nonaktifkan Pengguna
    public function nonaktifkan($id)
    {
        if (Auth::id() == $id) {
            return redirect()->back()->with('error', 'Anda tidak dapat menonaktifkan akun sendiri.');
        }

        $user = User::findOrFail($id);
        $user->update(['status' => 'nonaktif']);

        return redirect()->back()->with('success', 'Pengguna berhasil dinonaktifkan.');
    }

    public function aktifkan($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'aktif']);

        return redirect()->back()->with('success', 'Pengguna berhasil diaktifkan kembali.');
    }

}
