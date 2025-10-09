@extends('layouts.app')

@section('title', 'Dashboard Jurnal')

@section('content')
    <div class="header text-center mb-4 position-relative">
        <h1 class="m-0">Dashboard Jurnal</h1>
    </div>

    <!-- RINGKASAN -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card p-3 text-center shadow-sm">
                <h6>Total Jurnal</h6>
                <h4>{{ $totalJurnal }}</h4>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-3 text-center shadow-sm">
                <h6>Kategori Bidang Ilmu</h6>
                <h4>{{ count($bidangIlmuLabels) }}</h4>
            </div>
        </div>
    </div>

    <!-- GRAFIK -->
    <div class="row">
        <div class="col-md-8 mb-4">
            <div class="card p-3 h-100">
                <h6 class="text-center mb-3">Distribusi Jurnal Berdasarkan Akreditasi SINTA</h6>
                <div class="chart-container" style="position: relative; height: 400px;">
                    <canvas id="sintaChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card p-3 h-100">
                <h6 class="text-center mb-3">Distribusi Scopus Index</h6>
                <div class="chart-container" style="position: relative; height: 400px;">
                    <canvas id="scopusChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Pastikan kedua card sejajar dan sama tinggi */
        .row {
            display: flex;
            align-items: stretch;
        }

        .card {
            height: 100%;
        }

        .chart-container {
            height: 300px !important;
            /* tinggi grafik seragam */
        }
    </style>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // === Grafik Batang SINTA ===
        new Chart(document.getElementById('sintaChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($sintaLabels) !!},
                datasets: [{
                    label: 'Jumlah Jurnal',
                    data: {!! json_encode($sintaData) !!},
                    backgroundColor: '#3498db',
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // === Grafik Donat Scopus ===
        new Chart(document.getElementById('scopusChart'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($scopusLabels) !!},
                datasets: [{
                    data: {!! json_encode($scopusData) !!},
                    backgroundColor: [
                        '#FF0000', // Q0 - Merah
                        '#0000FF', // Q1 - Biru
                        '#FFFF00', // Q2 - Kuning
                        '#FFA500', // Q3 - Oranye
                        '#008000', // Q4 - Hijau
                        '#BDC3C7' // Tidak Terindeks - Abu-abu
                    ],
                    borderWidth: 3,
                    borderColor: '#FFFFFF',
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: ctx => `${ctx.label}: ${ctx.parsed}`
                        }
                    }
                }
            }
        });
    </script>
@endsection
