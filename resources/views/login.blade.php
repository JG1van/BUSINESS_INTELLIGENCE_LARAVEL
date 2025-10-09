<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
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
            font-family: 'Times New Roman';
        }

        body {
            background: linear-gradient(135deg, var(--warna5), var(--warna6));
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            color: var(--warna1);
        }

        .login-container {
            width: 100%;
            max-width: 380px;
            padding: 30px 25px;
            background-color: var(--warna0);
            border: 2px solid var(--warna3);
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
            animation: fadeIn 0.6s ease-in-out;
        }

        .login-title {
            font-size: 1.8rem;
            color: var(--warna2);
            margin-bottom: 25px;
            text-align: center;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-size: 0.95rem;
            color: var(--warna3);
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            font-size: 1rem;
            border: 1.5px solid var(--warna4);
            border-radius: 6px;
            background-color: var(--warna6);
            color: var(--warna1);
            transition: 0.25s ease;
        }

        input:focus {
            border-color: var(--warna2);
            box-shadow: 0 0 5px rgba(62, 95, 68, 0.3);
            outline: none;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: var(--warna2);
            color: var(--warna0);
            font-size: 1rem;
            font-weight: 500;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s ease;
        }

        button:hover {
            background-color: var(--warna3);
            transform: scale(1.02);
        }

        .register-link {
            text-align: center;
            margin-top: 15px;
            font-size: 0.9rem;
        }

        .register-link a {
            color: var(--warna2);
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }

        .register-link a:hover {
            color: var(--warna3);
            text-decoration: underline;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h1 class="login-title">Login</h1>

        {{-- Form login --}}
        <form method="POST" action="{{ route('login.process') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Masukkan email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password" required>
            </div>

            <button type="submit">Masuk</button>
        </form>

        <div class="register-link">
            Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
        </div>
    </div>
</body>

</html>
