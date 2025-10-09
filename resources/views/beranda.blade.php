<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JurnalKita</title>

    @auth
        @if (Auth::user()->role === 'admin')
            <link href="{{ asset('css/admin.css') }}" rel="stylesheet" />
        @else
            <link href="{{ asset('css/user.css') }}" rel="stylesheet" />
        @endif
    @else
        <link href="{{ asset('css/pengunjung.css') }}" rel="stylesheet" />
    @endauth

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        html {
            overflow-y: scroll;
        }

        body {
            font-family: 'Times New Roman';
            background-color: #f8f9fa;
        }

        .card-hover-effect {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .card-hover-effect:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, .175) !important;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm sticky-top py-3">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('beranda') }}">
                <span class="text-uppercase fs-3">JurnalKita</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <!-- Menu Jurnal di kanan -->
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('jurnal.index') }}">Daftar Jurnal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('pengaturan.index') }}">Upload Jurnal</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- Banner -->
    <div class="text-light p-5 text-center"
        style="background-image: url('{{ asset('images/banner2026.jpg') }}'); background-size: cover; background-position: center; background-attachment: fixed;">
        <div class="container">
            <h1 class="display-4 fw-bold">Temukan Jurnal Ilmiah Terbaik</h1>
            <p class="lead col-lg-8 mx-auto" style="height: 200px">Gerbang utama Anda untuk mengakses ribuan penelitian
                dan publikasi ilmiah
                dari seluruh Indonesia.</p>
            <div class="row justify-content-center mt-5">
                <div class="col-lg-8">
                    <div class="row justify-content-center mt-5">
                        <div class="col-lg-8">
                            <!-- Tombol arahkan ke halaman Jurnal -->
                            <a href="{{ route('jurnal.index') }}" class="btn btn-primary btn-lg w-100">
                                Cari Jurnal
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Statistik -->
    {{-- <div class="py-5 bg-light">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 col-6 mb-4">
                    <h2 class="fw-bold">3,450+</h2>
                    <p class="text-muted">Jurnal Terindeks</p>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <h2 class="fw-bold">650+</h2>
                    <p class="text-muted">Penerbit Bergabung</p>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <h2 class="fw-bold">1.2M+</h2>
                    <p class="text-muted">Kutipan Tercatat</p>
                </div> 
                 <div class="col-md-3 col-6 mb-4">
                    <h2 class="fw-bold">Gratis</h2>
                    <p class="text-muted">Akses Terbuka</p>
                </div>
            </div>
        </div>
    </div> --}}




    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4 mt-auto">
        <div class="container">
            <p class="mb-0 small">© 2025 JurnalKita—Semua Hak Dilindungi</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
