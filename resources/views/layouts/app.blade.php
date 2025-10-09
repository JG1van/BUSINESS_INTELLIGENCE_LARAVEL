<!DOCTYPE html>
<html lang="id">


<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Sistem Jurnal')</title>

    <!-- Kondisional CSS berdasarkan role -->
    @if (Auth::check())
        @if (Auth::user()->role === 'admin')
            <link href="{{ asset('css/admin.css') }}" rel="stylesheet" />
        @else
            <link href="{{ asset('css/user.css') }}" rel="stylesheet" />
        @endif
    @else
        <link href="{{ asset('css/pengunjung.css') }}" rel="stylesheet" />
    @endif

    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>



<body>
    <nav>
        <!-- Sidebar Offcanvas (Mobile) -->
        <div class="offcanvas offcanvas-start text-white" tabindex="-1" id="sidebarMobile">
            <div class="offcanvas-header flex-column">
                <div class="logo-container mb-2 w-20 text-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo" />
                </div>
                <div class="d-flex justify-content-between w-100 align-items-center">
                    <h5 class="offcanvas-title mb-0">Menu</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
            </div>

            <div class="offcanvas-body p-0">
                <ul class="list-unstyled ps-3">
                    <li><a href="{{ route('beranda') }}" class="text-white d-block py-2"><i
                                class="fas fa-home me-2"></i>Beranda</a></li>
                    <li><a href="{{ route('dashboard') }}" class="text-white d-block py-2"><i
                                class="fas fa-home me-2"></i>Dashboard</a></li>
                    <li><a href="{{ route('jurnal.index') }}" class="text-white d-block py-2"><i
                                class="fas fa-book me-2"></i>Jurnal</a></li>
                    <li><a href="{{ route('pengaturan.index') }}" class="text-white d-block py-2"><i
                                class="fas fa-cog me-2"></i>Pengaturan</a></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-link text-white d-block py-2"><i
                                    class="fas fa-sign-out-alt me-2"></i>Keluar</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Sidebar Desktop -->
        <div class="sidebar d-none d-md-block p-3 position-fixed">

            <div class="logo-container mb-2 w-20 text-center">
                @if (Auth::check())
                    @if (Auth::user()->role === 'admin')
                        <img src="{{ asset('images/logo-3.png') }}" alt="Logo Admin" class="logo" />
                    @else
                        <img src="{{ asset('images/logo-2.png') }}" alt="Logo User" class="logo" />
                    @endif
                @else
                    <img src="{{ asset('images/logo-1.png') }}" alt="Logo Pengunjung" class="logo" />
                @endif
            </div>

            <ul class="list-unstyled">
                <li><a href="{{ route('beranda') }}" class="text-white d-block py-2"><i
                            class="fas fa-home me-2"></i>Beranda</a></li>
                <li><a href="{{ route('dashboard') }}" class="text-white d-block py-2"><i
                            class="fas fa-chart-line me-2"></i>Dashboard</a></li>
                <li><a href="{{ route('jurnal.index') }}" class="text-white d-block py-2"><i
                            class="fas fa-book me-2"></i>Jurnal</a></li>
                <li><a href="{{ route('pengaturan.index') }}" class="text-white d-block py-2"><i
                            class="fas fa-cog me-2"></i>Pengaturan</a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-link text-white d-block py-2 w-100 text-start"
                            style="text-decoration: none;
"><i class="fas fa-sign-out-alt me-2"></i>Keluar</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>
    <main class="main-content p-3">

        @if (session('success'))
            <div class="alert alert-success mt-2">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger mt-2">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @yield('content')
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
