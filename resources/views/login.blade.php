<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <title>Kebencanaan & Tanggap Darurat — Login</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets-admin/images/logos/logoTD.png') }}">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8"></script>

    <style>
        /* ======================================================
   BACKGROUND & CENTER LAYOUT
====================================================== */
        body {
            margin: 0;
            font-family: "Poppins", sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;

            background: linear-gradient(135deg, #191B47, #3E4277, #191B47);
            background-size: 300% 300%;
            animation: gradientMove 10s ease infinite;
        }

        @keyframes gradientMove {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* ======================================================
   CARD (MATCH REGISTER)
====================================================== */
        .card {
            width: 480px;
            padding: 45px;
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(18px);
            text-align: center;
            box-shadow: 0 12px 45px rgba(0, 0, 0, 0.45);
            animation: fadeUp .9s ease;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2 {
            color: #F6CFB5;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .subtitle {
            color: rgba(255, 255, 255, 0.85);
            margin-bottom: 28px;
        }

        /* ======================================================
   INPUT STYLE (MATCH REGISTER)
====================================================== */
        .input-group {
            text-align: left;
            margin-bottom: 22px;
        }

        label {
            color: #F6CFB5;
            margin-left: 5px;
        }

        .input-box {
            width: 100%;
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.28);
            position: relative;
            transition: .25s ease;
        }

        .input-box:focus-within {
            border-color: #F6CFB5;
            box-shadow: 0 0 10px rgba(246, 207, 181, 0.45);
            transform: translateY(-2px);
        }

        .input-box input {
            width: 100%;
            padding: 14px 18px;
            background: transparent;
            border: none;
            outline: none;
            color: #ffffff;
            font-size: 16px; /* Prevent zoom on iOS */
            -webkit-appearance: none;
            border-radius: 0;
        }

        .input-box input::placeholder {
            color: rgba(255, 255, 255, 0.75);
        }

        /* FIX autofill Chrome */
        input:-webkit-autofill {
            -webkit-text-fill-color: #fff !important;
            -webkit-box-shadow: 0 0 0px 1000px rgba(255, 255, 255, 0.12) inset !important;
            transition: background-color 9999s ease-in-out 0s;
        }

        /* Eye Icon */
        .eye {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #F6CFB5;
            font-size: 22px;
        }

        /* ======================================================
   BUTTON
====================================================== */
        .btn-login {
            width: 100%;
            padding: 14px;
            background: #F6CFB5;
            border: none;
            border-radius: 16px;
            font-weight: 600;
            color: #191B47;
            font-size: 16px;
            margin-top: 10px;
            transition: .25s ease;
            cursor: pointer;
            min-height: 44px; /* Touch-friendly minimum */
        }

        .btn-login:hover {
            background: #ffe3cf;
        }

        .btn-login:active {
            transform: translateY(1px);
            background: #f0c4a0;
        }

        /* ======================================================
   SIGNUP TEXT
====================================================== */
        .signup-text {
            margin-top: 18px;
            color: rgba(255, 255, 255, 0.88);
        }

        .signup-text a {
            color: #F6CFB5;
            font-weight: 600;
            text-decoration: none;
        }

        /* Error alert */
        .alert {
            padding: 14px;
            border-radius: 14px;
            background: rgba(255, 110, 110, 0.25);
            border: 1px solid rgba(255, 110, 110, 0.45);
            color: white;
            margin-bottom: 18px;
        }

        .tagline {
            color: #ffffff;
            font-size: 18px;
            font-weight: 600;
            margin-top: -5px;
            margin-bottom: 22px;
            text-shadow: 0 0 6px rgba(246, 207, 181, 0.3);
        }

        /* ======================================================
   MOBILE RESPONSIVENESS
====================================================== */
        @media (max-width: 768px) {
            body {
                padding: 20px;
                align-items: flex-start;
                padding-top: 40px;
            }

            .card {
                width: 100%;
                max-width: 400px;
                padding: 30px 25px;
                margin: 0 auto;
            }

            .card img {
                width: 180px !important;
                margin-bottom: 15px !important;
            }

            h2 {
                font-size: 24px;
                margin-bottom: 8px;
            }

            .subtitle {
                font-size: 14px;
                margin-bottom: 25px;
            }

            .tagline {
                font-size: 16px;
                margin-bottom: 20px;
            }

            .input-group {
                margin-bottom: 18px;
            }

            label {
                font-size: 14px;
                margin-bottom: 8px;
            }

            .input-box input {
                padding: 12px 16px;
                font-size: 14px;
            }

            .btn-login {
                padding: 12px;
                font-size: 15px;
                margin-top: 15px;
            }

            .signup-text {
                font-size: 14px;
                margin-top: 20px;
            }

            .eye {
                font-size: 20px;
                right: 16px;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 15px;
                padding-top: 30px;
            }

            .card {
                padding: 25px 20px;
                border-radius: 20px;
            }

            .card img {
                width: 160px !important;
            }

            h2 {
                font-size: 22px;
            }

            .subtitle {
                font-size: 13px;
            }

            .tagline {
                font-size: 15px;
            }

            .input-box input {
                padding: 11px 14px;
                font-size: 14px;
            }

            .btn-login {
                padding: 11px;
                font-size: 14px;
            }

            .eye {
                font-size: 18px;
                right: 14px;
            }
        }

        @media (max-width: 360px) {
            .card {
                padding: 20px 15px;
            }

            .card img {
                width: 140px !important;
            }

            h2 {
                font-size: 20px;
            }

            .input-box input {
                padding: 10px 12px;
            }

            .btn-login {
                padding: 10px;
            }
        }

        /* Landscape mobile optimization */
        @media (max-height: 600px) and (orientation: landscape) {
            body {
                padding-top: 20px;
                padding-bottom: 20px;
            }

            .card {
                padding: 20px 25px;
            }

            .card img {
                width: 120px !important;
                margin-bottom: 10px !important;
            }

            .tagline {
                font-size: 14px;
                margin-bottom: 15px;
            }

            h2 {
                font-size: 20px;
                margin-bottom: 5px;
            }

            .subtitle {
                font-size: 12px;
                margin-bottom: 20px;
            }

            .input-group {
                margin-bottom: 15px;
            }
        }
    </style>
</head>

<body>

    <div class="card">

        {{-- ALERT ERROR --}}
        @if (session('error'))
            <div class="alert">{{ session('error') }}</div>
        @endif

        <img src="{{ asset('assets-admin/images/logos/logoDe.png') }}" width="230"
            style="margin-bottom:12px; opacity:1;">

       {{-- <h3 class="tagline">"Siaga Bersama, Tanggap Bencana"</h3> --}}

        <h2>Login</h2>
        <div class="subtitle">Silakan masuk untuk melanjutkan</div>

        <form action="{{ route('login.post') }}" method="POST">
            @csrf

            {{-- USERNAME --}}
            <div class="input-group">
                <label>Username / Email</label>
                <div class="input-box">
                    <input type="text" name="username" placeholder="Masukkan username atau email"
                        value="{{ old('username') }}" required>
                </div>
            </div>

            {{-- PASSWORD --}}
            <div class="input-group">
                <label>Password</label>
                <div class="input-box" style="position:relative;">
                    <input type="password" name="password" id="password" placeholder="Masukkan password" required>
                    <iconify-icon icon="mdi:eye-outline" id="togglePassword" class="eye"></iconify-icon>
                </div>
            </div>

            <button class="btn-login">Login</button>
        </form>

        <div class="signup-text">
            Belum punya akun? <a href="{{ route('register') }}">Daftar</a>
        </div>

    </div>

    <script>
        document.getElementById("togglePassword").addEventListener("click", function() {
            const pw = document.getElementById("password");
            const hidden = pw.type === "password";
            pw.type = hidden ? "text" : "password";
            this.setAttribute("icon", hidden ? "mdi:eye-off-outline" : "mdi:eye-outline");
        });
    </script>

</body>

</html>
