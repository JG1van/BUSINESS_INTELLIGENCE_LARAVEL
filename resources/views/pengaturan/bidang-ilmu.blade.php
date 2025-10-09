@extends('layouts.app')
@section('title', 'Manajemen Bidang Ilmu')

@section('content')

    <div class="header d-flex justify-content-center align-items-center mb-4 position-relative">
        <!-- Tombol Burger (mobile) -->
        <div class="d-md-none position-absolute start-0">
            <button class="btn btn-outline-dark" data-bs-toggle="offcanvas" data-bs-target="#sidebarMobile">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        <!-- Judul -->
        <h1 class="m-0 text-center">Manajemen Bidang Ilmu</h1>
    </div>

    <!-- Pencarian & Tambah -->
    <div class="row g-2 align-items-end mb-3">
        <div class="col-md-8">
            <label class="form-label">Pencarian</label>
            <input id="searchInput" type="text" class="form-control" placeholder="Cari Bidang Ilmu..."
                onkeyup="filterTable()">
        </div>
        <div class="col-md-4 text-end">
            <button class="btn btn-add w-100" data-bs-toggle="modal" data-bs-target="#modalBidangIlmu">
                <i class="fas fa-plus me-2"></i>Tambah Bidang Ilmu
            </button>
        </div>
    </div>

    <!-- Tabel Data -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center align-middle" id="bidangIlmuTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Bidang</th>
                    <th>Nama Bidang Ilmu</th>
                    <th style="width:150px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bidangIlmu as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->id_bidang_ilmu }}</td>
                        <td>{{ $item->nama_bidang_ilmu }}</td>
                        <td>
                            <button class="btn btn-sm-1" data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $item->id_bidang_ilmu }}">Edit</button>
                            <form action="{{ route('bidang-ilmu.destroy', $item->id_bidang_ilmu) }}" method="POST"
                                class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm-2"
                                    onclick="return confirm('Yakin hapus bidang ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Modal Edit -->
                    <div class="modal fade" id="editModal{{ $item->id_bidang_ilmu }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Bidang Ilmu</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('bidang-ilmu.update', $item->id_bidang_ilmu) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Nama Bidang Ilmu</label>
                                            <input type="text" name="nama_bidang_ilmu" class="form-control"
                                                value="{{ $item->nama_bidang_ilmu }}" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-add w-100">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="4">Belum ada data bidang ilmu.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="modalBidangIlmu" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('bidang-ilmu.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Bidang Ilmu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Bidang Ilmu</label>
                        <input type="text" name="nama_bidang_ilmu" class="form-control"
                            placeholder="Masukkan nama bidang ilmu" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-add w-100">Simpan</button>
                </div>
            </form>
        </div>
    </div>


    <script>
        function filterTable() {
            const input = document.getElementById("searchInput").value.toLowerCase();
            document.querySelectorAll("#bidangIlmuTable tbody tr").forEach(row => {
                const text = row.cells[2]?.textContent.toLowerCase() || "";
                row.style.display = text.includes(input) ? "" : "none";
            });
        }
    </script>
@endsection
