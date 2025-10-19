@extends('layouts.app')

@section('title', 'Daftar Jurnal')

@section('content')

    <div class="header d-flex justify-content-center align-items-center mb-4 position-relative">
        <div class="d-md-none position-absolute start-0">
            <button class="btn btn-outline-dark" data-bs-toggle="offcanvas" data-bs-target="#sidebarMobile">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        <h1 class="m-0 text-center">Daftar Jurnal</h1>
    </div>

    <!-- Filter -->
    <div class="row g-2 align-items-end mb-2 alas p-1">
        <div class="col-md-7">
            <label class="form-label">Pencarian</label>
            <input id="searchInput" type="text" class="form-control" placeholder="Cari nama, atau singkatan...">
        </div>
        <div class="col-md-2">
            <label class="form-label">Bidang</label>
            <select id="bidangFilter" class="form-select">
                <option value="">Semua</option>
                @php
                    $bidangs = $jurnals->pluck('bidang')->filter()->unique()->sort();
                @endphp
                @foreach ($bidangs as $bid)
                    <option value="{{ strtolower($bid) }}">{{ $bid }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">Bidang Ilmu</label>
            <select id="bidangIlmuFilter" class="form-select">
                <option value="">Semua</option>
                @foreach ($bidangIlmus as $kategori)
                    <option value="{{ strtolower($kategori->nama_bidang_ilmu) }}">{{ $kategori->nama_bidang_ilmu }}</option>
                @endforeach
            </select>
        </div>

        <!-- Checkbox Sinta -->
        <div class="col-md-7">
            <label class="form-label d-block">Sinta</label>
            <div id="sintaCheckboxes" class="d-flex flex-wrap gap-2">
                @foreach (['Blm_akreditasi', 'S1', 'S2', 'S3', 'S4', 'S5', 'S6'] as $sinta)
                    <div class="form-check form-check-inline">
                        <input class="form-check-input sintaCheck" type="checkbox" value="{{ strtolower($sinta) }}"
                            id="sinta_{{ str_replace(' ', '_', $sinta) }}">
                        <label class="form-check-label small"
                            for="sinta_{{ str_replace(' ', '_', $sinta) }}">{{ ucfirst($sinta) }}</label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="col-md-5">
            <label class="form-label d-block">Scopus</label>
            <div id="scopusCheckboxes" class="d-flex flex-wrap gap-2">
                @foreach (['Blm_scopus', 'Q1', 'Q2', 'Q3', 'Q4'] as $q)
                    <div class="form-check form-check-inline">
                        <input class="form-check-input scopusCheck" type="checkbox" value="{{ strtolower($q) }}"
                            id="scopus_{{ $q }}">
                        <label class="form-check-label small" for="scopus_{{ $q }}">{{ ucfirst($q) }}</label>
                    </div>
                @endforeach
            </div>
        </div>


    </div>

    <!-- Tabel Jurnal -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center align-middle" id="jurnalTable"
            style="width: 100%; table-layout: fixed; word-wrap: break-word;">

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
                    <th>Masa Aktif Scopus</th>
                    <th>Penerbit</th>
                    <th>Aksi</th>
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
                        <td>{{ $jurnal->masa_aktif_scopus ?? '-' }}</td>
                        <td>{{ $jurnal->penerbit ?? '-' }}</td>
                        </td>
                        <td>
                            <button class="btn btn-add w-100 p-1 mb-1" data-bs-toggle="modal"
                                data-bs-target="#detailModal{{ $jurnal->id_jurnal }}">
                                Detail
                            </button>
                        </td>
                    </tr>

                    <!-- Modal Detail -->
                    <div class="modal fade" id="detailModal{{ $jurnal->id_jurnal }}" tabindex="-1"
                        aria-labelledby="detailModalLabel{{ $jurnal->id_jurnal }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light">
                                    <h5 class="modal-title" id="detailModalLabel{{ $jurnal->id_jurnal }}">
                                        Detail Jurnal: {{ $jurnal->nama_jurnal }}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Nama Jurnal</label>
                                            <input type="text" class="form-control" value="{{ $jurnal->nama_jurnal }}"
                                                readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Singkatan</label>
                                            <input type="text" class="form-control" value="{{ $jurnal->singkatan }}"
                                                readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Link Jurnal</label>
                                            <input type="text" class="form-control" value="{{ $jurnal->link }}"
                                                readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">ISSN</label>
                                            <input type="text" class="form-control" value="{{ $jurnal->issn }}"
                                                readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">E-ISSN</label>
                                            <input type="text" class="form-control" value="{{ $jurnal->e_issn }}"
                                                readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Bidang</label>
                                            <input type="text" class="form-control" value="{{ $jurnal->bidang }}"
                                                readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Bidang Ilmu</label>
                                            <input type="text" class="form-control"
                                                value="{{ $jurnal->bidangIlmu->nama_bidang_ilmu ?? '-' }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Akreditasi Sinta</label>
                                            <input type="text" class="form-control"
                                                value="{{ $jurnal->akreditasi_sinta }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Masa Aktif Sinta</label>
                                            <input type="text" class="form-control"
                                                value="{{ $jurnal->masa_aktif_sinta }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Scopus Index</label>
                                            <input type="text" class="form-control"
                                                value="{{ $jurnal->scopus_index }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Masa Aktif Scopus</label>
                                            <input type="text" class="form-control"
                                                value="{{ $jurnal->masa_aktif_scopus }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">penerbit</label>
                                            <input type="text" class="form-control" value="{{ $jurnal->penerbit }}"
                                                readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Kota Terbit</label>
                                            <input type="text" class="form-control"
                                                value="{{ $jurnal->kota_terbit }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    @if ($jurnal->link)
                                        <a href="{{ $jurnal->link }}" target="_blank"
                                            class="btn btn-add w-100">Kunjungi</a>
                                    @else
                                        <button class="btn btn-secondary w-100" disabled>Tidak Ada Link</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="11" class="text-center text-muted">Belum ada data jurnal.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="11"></th>
                </tr>
                <tr>
                    <th colspan="11"></th>
                </tr>
            </tfoot>
        </table>
    </div>

    <style>
        #jurnalTable th,
        #jurnalTable td {
            vertical-align: middle;
            white-space: normal;
            overflow-wrap: break-word;
            word-break: break-word;
            text-align: center;
            padding: 6px;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("searchInput");
            const bidangFilter = document.getElementById("bidangFilter");
            const bidangIlmuFilter = document.getElementById("bidangIlmuFilter");
            const sintaChecks = document.querySelectorAll(".sintaCheck");
            const scopusChecks = document.querySelectorAll(".scopusCheck");
            const tableRows = document.querySelectorAll("#jurnalTable tbody tr");

            function filterTable() {
                const searchText = searchInput.value.toLowerCase();
                const bidang = bidangFilter.value.toLowerCase();
                const bidangIlmu = bidangIlmuFilter.value.toLowerCase();

                const sintaSelected = Array.from(sintaChecks).filter(cb => cb.checked).map(cb => cb.value);
                const scopusSelected = Array.from(scopusChecks).filter(cb => cb.checked).map(cb => cb.value);

                tableRows.forEach((row) => {
                    const text = row.textContent.toLowerCase();
                    const bidangText = row.querySelector("td:nth-child(4)")?.textContent.toLowerCase() ||
                        "";
                    const bidangIlmuText = row.querySelector("td:nth-child(5)")?.textContent
                        .toLowerCase() || "";
                    const sintaText = row.querySelector("td:nth-child(6)")?.textContent.toLowerCase() || "";
                    const scopusText = row.querySelector("td:nth-child(8)")?.textContent.toLowerCase() ||
                        "";

                    const matchSearch = text.includes(searchText);
                    const matchBidang = bidang === "" || bidangText === bidang;
                    const matchBidangIlmu = bidangIlmu === "" || bidangIlmuText === bidangIlmu;
                    const matchSinta = sintaSelected.length === 0 || sintaSelected.some(s => sintaText
                        .includes(s));
                    const matchScopus = scopusSelected.length === 0 || scopusSelected.some(s => scopusText
                        .includes(s));

                    row.style.display = (matchSearch && matchBidang && matchBidangIlmu && matchSinta &&
                        matchScopus) ? "" : "none";
                });
            }

            [searchInput, bidangFilter, bidangIlmuFilter].forEach(el => {
                el.addEventListener("input", filterTable);
                el.addEventListener("change", filterTable);
            });
            [...sintaChecks, ...scopusChecks].forEach(cb => cb.addEventListener("change", filterTable));
        });
    </script>

@endsection
