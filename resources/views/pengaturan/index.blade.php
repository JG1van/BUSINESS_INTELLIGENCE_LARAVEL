@extends('layouts.app')

@section('title', 'Pengaturan - Sistem Jurnal')

@section('content')
    <div class="header d-flex justify-content-center align-items-center mb-4 position-relative">
        <div class="d-md-none position-absolute start-0">
            <button class="btn btn-outline-dark" data-bs-toggle="offcanvas" data-bs-target="#sidebarMobile">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        <h1 class="m-0 text-center">Pengaturan</h1>
    </div>

    <div class="row g-3">
        <!-- Profil Akun -->
        <div class="col-md-12">
            <div class="card text-center h-200">
                <div class="card-body">
                    <i class="fas fa-user-circle fa-2x mb-2"></i>
                    <h5 class="card-title">Profil Akun</h5>
                    <p class="card-text">
                        Lihat dan perbarui informasi akun Anda secara langsung.
                    </p>
                    <a href="{{ route('pengaturan.profil') }}" class="btn btn-sm-1 w-100">
                        Kelola Profil
                    </a>
                </div>
            </div>
        </div>

        <!-- Hanya tampil untuk admin -->
        @if (auth()->user() && auth()->user()->role === 'admin')
            <div class="col-md-6">
                <div class="card text-center h-200">
                    <div class="card-body">
                        <i class="fas fa-users-cog fa-2x mb-2"></i>
                        <h5 class="card-title">Manajemen Pengguna</h5>
                        <p class="card-text">Atur akses, tambah, dan kelola data pengguna sistem.</p>
                        <a href="{{ route('pengaturan.pengguna') }}" class="btn btn-sm-1 w-100">Kelola Pengguna</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-center h-200">
                    <div class="card-body">
                        <i class="fas fa-file-excel fa-2x mb-2"></i>
                        <h5 class="card-title">Impor Excel ke SQL</h5>
                        <p class="card-text">
                            Unggah file Excel untuk dimasukkan otomatis ke dalam database sistem.
                        </p>
                        <a href="#" class="btn btn-sm-1 w-100">
                            Impor Data
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <!-- Manajemen Bidang Ilmu -->
        <div class="col-md-6">
            <div class="card text-center h-100">
                <div class="card-body">
                    <i class="fas fa-th-list fa-2x mb-3"></i>
                    <h5 class="card-title">Manajemen Bidang Ilmu</h5>
                    <p class="card-text">
                        Tambah, ubah, atau hapus bidang ilmu jurnal sesuai kebutuhan.
                    </p>
                    <a href="{{ route('pengaturan.bidang-ilmu') }}" class="btn btn-sm-1 w-100">
                        Pilih
                    </a>
                </div>
            </div>
        </div>

        <!-- Manajemen Jurnal -->
        <div class="col-md-6">
            <div class="card text-center h-100">
                <div class="card-body">
                    <i class="fas fa-book fa-2x mb-3"></i>
                    <h5 class="card-title">Manajemen Jurnal</h5>
                    <p class="card-text">
                        Kelola daftar jurnal: tambah, edit, hapus, dan lihat detail.
                    </p>
                    <a href="{{ route('pengaturan.jurnal') }}" class="btn btn-sm-1 w-100">
                        Pilih
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
