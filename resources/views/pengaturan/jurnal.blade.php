@extends('layouts.app')

@section('content')
    <div class="header d-flex justify-content-center align-items-center mb-4 position-relative">
        <div class="d-md-none position-absolute start-0">
            <button class="btn btn-outline-dark" data-bs-toggle="offcanvas" data-bs-target="#sidebarMobile">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        <h1 class="m-0 text-center">Manajemen Jurnal</h1>
    </div>

    <!-- Search & Add -->
    <div class="row g-2 align-items-end mb-3">
        <div class="col-md-8">
            <label class="form-label">Pencarian</label>
            <input id="searchInput" type="text" class="form-control" placeholder="Cari Jurnal..."
                onkeyup="filterTable()" />
        </div>
        <div class="col-md-4 text-end">
            <button class="btn btn-add w-100" data-bs-toggle="modal" data-bs-target="#modalJurnal">
                <i class="fas fa-plus me-2"></i>Tambah Jurnal
            </button>
        </div>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center align-middle" id="jurnalTable"
            style="width: 100%; table-layout: fixed; word-wrap: break-word;">

            <colgroup>
                <col style="width: 4%;">
                <col style="width: 20%;">
                <col style="width: 10%;">
                <col style="width: 10%;">
                <col style="width: 12%;">
                <col style="width: 12%;">
                <col style="width: 10%;">
                <col style="width: 10%;">
                <col style="width: 12%;">
            </colgroup>

            <thead class="align-middle">
                <tr>
                    <th>No</th>
                    <th>Nama Jurnal</th>
                    <th>Singkatan</th>
                    <th>Bidang</th>
                    <th>Bidang Ilmu</th>
                    <th>SINTA</th>
                    <th>Masa Aktif SINTA</th>
                    <th>Scopus</th>
                    <th>Link</th>
                </tr>
            </thead>

            <tbody>
                @forelse($jurnals as $index => $jurnal)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $jurnal->nama_jurnal }}</td>
                        <td>{{ $jurnal->singkatan ?? '-' }}</td>
                        <td>{{ $jurnal->bidang ?? '-' }}</td>
                        <td>{{ $jurnal->bidangIlmu->nama_bidang_ilmu ?? '-' }}</td>
                        <td>{{ $jurnal->akreditasi_sinta ?? '-' }}</td>
                        <td>{{ $jurnal->masa_aktif_sinta ?? '-' }}</td>
                        <td>{{ $jurnal->scopus_index ?? '-' }}</td>
                        <td>
                            <a href="{{ $jurnal->link }}" target="_blank" class="btn btn-add w-100 mb-1">Link</a>
                            <button class="btn btn-sm-1 w-100 mb-1" data-bs-toggle="modal"
                                data-bs-target="#editJurnal{{ $jurnal->id_jurnal }}">
                                Edit
                            </button>
                            <form action="{{ route('pengaturan.jurnal.destroy', $jurnal->id_jurnal) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus jurnal ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm-2 w-100">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">Belum ada data jurnal.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="9"></th>
                </tr>
                <tr>
                    <th colspan="9"></th>
                </tr>
            </tfoot>
        </table>
    </div>


    <style>
        #tabelUser th,
        #tabelUser td {
            vertical-align: middle;
            white-space: normal;
            /* biar teks panjang turun ke bawah */
            overflow-wrap: break-word;
            word-break: break-word;
            text-align: center;
        }
    </style>




    <!-- Modal Tambah Jurnal -->
    <div class="modal fade" id="modalJurnal" tabindex="-1" aria-labelledby="modalJurnalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header text-black">
                    <h5 class="modal-title" id="modalJurnalLabel">Tambah Jurnal</h5>
                    <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal"
                        aria-label="Tutup"></button>
                </div>

                <form action="{{ route('pengaturan.jurnal.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Jurnal</label>
                                <input type="text" name="nama_jurnal" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Singkatan</label>
                                <input type="text" name="singkatan" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Link Jurnal</label>
                                <input type="url" name="link" class="form-control" placeholder="https://contoh.com">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">ISSN</label>
                                <input type="text" name="issn" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">E-ISSN</label>
                                <input type="text" name="e_issn" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Bidang</label>
                                <select name="bidang" class="form-select" required>
                                    <option value="">-- Pilih Bidang --</option>
                                    <option value="Penelitian">Penelitian</option>
                                    <option value="Pengabdian">Pengabdian</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Bidang Ilmu</label>
                                <select name="id_bidang_ilmu" class="form-select" required>
                                    <option value="">-- Pilih Bidang Ilmu --</option>
                                    @foreach ($bidangIlmus as $bi)
                                        <option value="{{ $bi->id_bidang_ilmu }}">{{ $bi->nama_bidang_ilmu }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Akreditasi Sinta</label>
                                <select name="akreditasi_sinta" class="form-select">
                                    <option value="Non_Sinta">-- Pilih --</option>
                                    @for ($i = 1; $i <= 6; $i++)
                                        <option value="Sinta {{ $i }}">Sinta {{ $i }}</option>
                                    @endfor
                                    <option value="Non_Sinta">Non_Sinta</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Masa Aktif Sinta</label>
                                <input type="text" name="masa_aktif_sinta" class="form-control"
                                    placeholder="2020-2025">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Scopus Index</label>
                                <select name="scopus_index" class="form-select">
                                    <option value="Non_Scopus">-- Pilih --</option>
                                    @foreach (['Q1', 'Q2', 'Q3', 'Q4'] as $q)
                                        <option value="{{ $q }}">{{ $q }}</option>
                                    @endforeach
                                    <option value="Non_Scopus">Non_Scopus</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Masa Aktif Scopus</label>
                                <input type="text" name="masa_aktif_scopus" class="form-control"
                                    placeholder="2020-2025">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Penerbit</label>
                                <input type="text" name="penerbit" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Kota Terbit</label>
                                <input type="text" name="kota_terbit" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success w-100">Simpan Data Jurnal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Edit Jurnal -->
    @foreach ($jurnals as $jurnal)
        <div class="modal fade" id="editJurnal{{ $jurnal->id_jurnal }}" tabindex="-1"
            aria-labelledby="editJurnalLabel{{ $jurnal->id_jurnal }}" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header  text-black">
                        <h5 class="modal-title" id="editJurnalLabel{{ $jurnal->id_jurnal }}">Edit Jurnal</h5>
                        <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal"
                            aria-label="Tutup"></button>
                    </div>

                    <form action="{{ route('pengaturan.jurnal.update', $jurnal->id_jurnal) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Jurnal</label>
                                    <input type="text" name="nama_jurnal" class="form-control"
                                        value="{{ $jurnal->nama_jurnal }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Singkatan</label>
                                    <input type="text" name="singkatan" class="form-control"
                                        value="{{ $jurnal->singkatan }}">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Link Jurnal</label>
                                    <input type="url" name="link" class="form-control"
                                        value="{{ $jurnal->link }}" placeholder="https://contoh.com">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">ISSN</label>
                                    <input type="text" name="issn" class="form-control"
                                        value="{{ $jurnal->issn }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">E-ISSN</label>
                                    <input type="text" name="e_issn" class="form-control"
                                        value="{{ $jurnal->e_issn }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Bidang</label>
                                    <select name="bidang" class="form-select" required>
                                        <option value="">-- Pilih Bidang --</option>
                                        <option value="Penelitian"
                                            {{ $jurnal->bidang == 'Penelitian' ? 'selected' : '' }}>Penelitian</option>
                                        <option value="Pengabdian"
                                            {{ $jurnal->bidang == 'Pengabdian' ? 'selected' : '' }}>Pengabdian</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Bidang Ilmu</label>
                                    <select name="id_bidang_ilmu" class="form-select" required>
                                        <option value="">-- Pilih Bidang Ilmu --</option>
                                        @foreach ($bidangIlmus as $bi)
                                            <option value="{{ $bi->id_bidang_ilmu }}"
                                                {{ $bi->id_bidang_ilmu == $jurnal->id_bidang_ilmu ? 'selected' : '' }}>
                                                {{ $bi->nama_bidang_ilmu }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Akreditasi Sinta</label>
                                    <select name="akreditasi_sinta" class="form-select">
                                        <option value="Non_Sinta">-- Pilih --</option>
                                        @for ($i = 1; $i <= 6; $i++)
                                            <option value="Sinta {{ $i }}">Sinta {{ $i }}</option>
                                        @endfor
                                        <option value="Non_Sinta">Non_Sinta</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Masa Aktif Sinta</label>
                                    <input type="text" name="masa_aktif_sinta" class="form-control"
                                        value="{{ $jurnal->masa_aktif_sinta }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Scopus Index</label>
                                    <select name="scopus_index" class="form-select">
                                        <option value="Non_Scopus">-- Pilih --</option>
                                        @foreach (['Q1', 'Q2', 'Q3', 'Q4'] as $q)
                                            <option value="{{ $q }}">{{ $q }}</option>
                                        @endforeach
                                        <option value="Non_Scopus">Non_Scopus</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Masa Aktif Scopus</label>
                                    <input type="text" name="masa_aktif_scopus" class="form-control"
                                        value="{{ $jurnal->masa_aktif_scopus }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Penerbit</label>
                                    <input type="text" name="penerbit" class="form-control"
                                        value="{{ $jurnal->penerbit }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Kota Terbit</label>
                                    <input type="text" name="kota_terbit" class="form-control"
                                        value="{{ $jurnal->kota_terbit }}">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-add w-100">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        function filterTable() {
            const filter = document.getElementById("searchInput").value.toLowerCase();
            document.querySelectorAll("#jurnalTable tbody tr").forEach(row => {
                const text = row.cells[1]?.textContent.toLowerCase() || "";
                row.style.display = text.includes(filter) ? "" : "none";
            });
        }
    </script>
@endsection
