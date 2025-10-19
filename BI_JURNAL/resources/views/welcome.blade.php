<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Halaman Depan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --warna0: white;
            --warna1: black;
            --warna2: #37353E;
            --warna3: #44444E;
            --warna4: #715A5A;
            --warna6: #D3DAD9;
            --warna5: #eaefee;
        }

        body {
            font-family: 'Times New Roman';
            background-color: var(--warna5);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            text-align: center;
            padding: 20px;
            background-color: var(--warna0);
            border: 2px solid var(--warna3);
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 800px;
            width: 100%;
        }

        .logo {
            width: 150px;
            margin-bottom: 20px;
            transition: opacity 0.5s ease-in-out;
        }

        .btn-group button {
            background-color: var(--warna2);
            color: white;
            border: none;
            border-radius: 6px;
            padding: 10px;
            margin: 5px;
            width: 50%;
        }

        .btn-group button:hover {
            background-color: var(--warna3);
        }
    </style>
</head>

<body>
    <main>
        <div class="login-container">
            <!-- Logo tunggal -->
            <img id="logo" src="{{ asset('images/logo-1.png') }}" alt="Logo" class="logo" />

            <div class="btn-group w-100" role="group">
                <button onclick="window.location.href='{{ url('/login') }}'">Sign In</button>
                <button onclick="window.location.href='{{ url('/beranda') }}'">Home</button>
                <button onclick="window.location.href='{{ url('/register') }}'">Sign Up</button>
            </div>
        </div>
    </main>

    <script>
        // Daftar logo yang akan ditampilkan bergantian
        const logos = [
            "{{ asset('images/logo-1.png') }}",
            "{{ asset('images/logo-2.png') }}",
            "{{ asset('images/logo-3.png') }}"
        ];

        let index = 0;
        const logoEl = document.getElementById("logo");

        setInterval(() => {
            logoEl.style.opacity = 0; // efek fade-out
            setTimeout(() => {
                index = (index + 1) % logos.length; // ganti gambar
                logoEl.src = logos[index];
                logoEl.style.opacity = 1; // efek fade-in
            }, 500); // setengah detik transisi
        }, 5000); // ganti tiap 1 detik
    </script>
</body>

</html>
