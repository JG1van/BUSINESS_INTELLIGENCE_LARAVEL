<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registrasi</title>
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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman';
            background-color: var(--warna5);
            color: var(--warna1);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .register-container {
            width: 100%;
            max-width: 450px;
            padding: 20px;
            background-color: var(--warna0);
            border: 2px solid var(--warna3);
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .register-title {
            font-size: 2rem;
            color: var(--warna2);
            margin-bottom: 20px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-size: 1rem;
            color: var(--warna3);
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            border: 1px solid var(--warna4);
            border-radius: 4px;
            background-color: var(--warna0);
            color: var(--warna1);
        }

        input:focus {
            border-color: var(--warna2);
            outline: none;
        }

        .btn-register {
            display: block;
            text-align: center;
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            color: var(--warna0);
            background-color: var(--warna2);
            border-radius: 4px;
            text-decoration: none;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        .btn-register:hover {
            background-color: var(--warna3);
        }

        .text-center {
            text-align: center;
            margin-top: 15px;
            font-size: 0.9rem;
        }

        .text-center a {
            color: var(--warna2);
            text-decoration: none;
        }

        .text-center a:hover {
            text-decoration: underline;
        }

        button {
            margin-top: 10px;
            width: 100%;
            padding: 10px;
            background-color: var(--warna2);
            color: white;
            border: none;
            border-radius: 4px;
        }

        button:hover {
            background-color: var(--warna3);
        }

        .text-center {
            text-align: center;
            margin-top: 10px;
        }

        .text-center a {
            color: var(--warna2);
            text-decoration: none;
        }

        .text-center a:hover {
            color: var(--warna3);
        }
    </style>
</head>

<body>
    <div class="register-container">
        <h1 class="register-title">Registrasi</h1>
        <form action="{{ route('register.process') }}" method="POST">
            @csrf
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Masukkan username" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Masukkan email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Masukkan password" required>

            <label for="confirm_password">Konfirmasi Password</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Ulangi password" required>

            <button type="submit">Daftar</button>
        </form>

        <div class="text-center">
            Sudah punya akun? <a href="{{ url('/login') }}">Login di sini</a>
        </div>
    </div>
</body>

</html>
