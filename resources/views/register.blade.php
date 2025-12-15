<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Kebencanaan & Tanggap Darurat — Register</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets-admin/images/logos/logoTD.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8"></script>

    <style>
        /* ======================================================
   BACKGROUND GRADIENT + CENTER LAYOUT
====================================================== */
        body {
            margin: 0;
            font-family: "Poppins", sans-serif;
            min-height: 100vh;

            /* FIX: supaya card benar-benar di tengah */
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
   CARD GLASS EFFECT
====================================================== */
        .card {
            width: 560px;
            padding: 48px;
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(18px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 12px 45px rgba(0, 0, 0, 0.45);
            animation: fadeUp 0.9s ease;
            text-align: center;
            /* FIX: teks judul tetap center */
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
        }

        .subtitle {
            color: rgba(255, 255, 255, 0.85);
            margin-bottom: 28px;
        }

        /* ======================================================
   INPUT FORM
====================================================== */
        .input-group {
            margin-bottom: 22px;
            text-align: left;
        }

        label {
            color: #F6CFB5;
            margin-bottom: 6px;
            display: block;
        }

        .input-box {
            width: 100%;
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.28);
            position: relative;
            transition: all .25s;
        }

        .input-box:focus-within {
            border-color: #F6CFB5;
            box-shadow: 0 0 10px rgba(246, 207, 181, 0.45);
            transform: translateY(-2px);
        }

        .input-box input,
        .input-box select {
            width: 100%;
            padding: 14px 18px;
            background: transparent;
            border: none;
            outline: none;
            color: #fff;
            font-size: 15px;
        }

        .input-box input::placeholder {
            color: rgba(255, 255, 255, 0.75);
        }

        /* FIX Autofill Chrome */
        input:-webkit-autofill {
            -webkit-text-fill-color: #fff !important;
            -webkit-box-shadow: 0 0 0px 1000px rgba(255, 255, 255, 0.12) inset !important;
            transition: background-color 9999s ease-in-out 0s;
        }

        /* Dropdown */
        .input-box select {
            appearance: none;
            background-image: url("data:image/svg+xml;utf8,<svg fill='%23f6cfb5' height='20' viewBox='0 0 24 24' width='20' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5'/></svg>");
            background-repeat: no-repeat;
            background-position: right 18px center;
            background-size: 18px;
        }

        .input-box select option {
            background: #2A2D66;
            color: #fff;
        }

        /* Eye icon */
        .eye {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #F6CFB5;
            font-size: 22px;
            cursor: pointer;
        }

        /* Foto Preview */
        .preview-img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            margin-top: 10px;
            display: none;
            border: 2px solid #F6CFB5;
        }

        /* Button */
        .btn-register {
            width: 100%;
            padding: 14px;
            background: #F6CFB5;
            border: none;
            border-radius: 16px;
            font-weight: 600;
            color: #191B47;
            font-size: 16px;
            transition: .25s;
        }

        .btn-register:hover {
            background: #ffe3cf;
        }

        /* Error text */
        .error-text {
            color: #ffb6b6;
            font-size: 13px;
            margin-top: 6px;
        }

        /* Login text */
        .login-text {
            margin-top: 18px;
            color: rgba(255, 255, 255, 0.88);
        }

        .login-text a {
            color: #F6CFB5;
            font-weight: 600;
        }

        .tagline {
            color: #ffffff;
            font-size: 18px;
            font-weight: 600;
            margin-top: -5px;
            margin-bottom: 22px;
            text-shadow: 0 0 6px rgba(246, 207, 181, 0.3);
        }
    </style>
</head>

<body>

    <div class="card">

        <img src="{{ asset('assets-admin/images/logos/logoDe.png') }}" width="230"
            style="margin-bottom:12px; opacity:1;">

        <h3 class="tagline">" Siaga Bersama, Tanggap Bencana" </h3>
        <h2>Register</h2>
        <div class="subtitle">Buat akun baru untuk mengakses sistem</div>

        <form action="{{ route('register.post') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- NAMA --}}
            <div class="input-group">
                <label>Nama Lengkap</label>
                <div class="input-box">
                    <input type="text" name="name" placeholder="Masukkan nama" value="{{ old('name') }}">
                </div>
                @error('name')
                    <div class="error-text">
                        {{ str_replace(['The name field is required.', 'The name must not be greater than 255 characters.'], ['Nama wajib diisi.', 'Nama maksimal 255 karakter.'], $message) }}
                    </div>
                @enderror
            </div>

            {{-- EMAIL --}}
            <div class="input-group">
                <label>Email</label>
                <div class="input-box">
                    <input type="email" name="email" placeholder="Masukkan email" value="{{ old('email') }}">
                </div>
                @error('email')
                    <div class="error-text">
                        {{ str_replace(['The email field is required.', 'The email must be a valid email address.', 'The email has already been taken.'], ['Email wajib diisi.', 'Format email tidak valid.', 'Email sudah digunakan.'], $message) }}
                    </div>
                @enderror
            </div>

            {{-- PASSWORD --}}
            <div class="input-group">
                <label>Password</label>
                <div class="input-box">
                    <input type="password" name="password" id="password" placeholder="Buat password">
                    <iconify-icon icon="mdi:eye-outline" id="togglePassword" class="eye"></iconify-icon>
                </div>
                @error('password')
                    <div class="error-text">
                        {{ str_replace(['The password field is required.', 'The password must be at least 6 characters.'], ['Password wajib diisi.', 'Password minimal 6 karakter.'], $message) }}
                    </div>
                @enderror
            </div>

            {{-- ROLE --}}
            <div class="input-group">
                <label>Role</label>
                <div class="input-box">
                    <select name="role">
                        <option value="">-- Pilih Role --</option>
                        <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                        <option value="Warga" {{ old('role') == 'Warga' ? 'selected' : '' }}>Warga</option>
                        <option value="Mitra" {{ old('role') == 'Mitra' ? 'selected' : '' }}>Mitra</option>
                    </select>
                </div>
                @error('role')
                    <div class="error-text">Role wajib dipilih.</div>
                @enderror
            </div>

            {{-- FOTO --}}
            <div class="input-group">
                <label>Foto Profil</label>
                <div class="input-box">
                    <input type="file" name="foto_profil" accept="image/*" onchange="previewFoto(event)">
                </div>
                @error('foto_profil')
                    <div class="error-text">
                        {{ str_replace(
                            [
                                'The foto profil must be an image.',
                                'The foto profil must be a file of type: jpg, jpeg, png, gif.',
                                'The foto profil must not be greater than 2048 kilobytes.',
                            ],
                            ['File harus berupa gambar.', 'Format harus JPG, JPEG, PNG, GIF.', 'Ukuran maksimal 2MB.'],
                            $message,
                        ) }}
                    </div>
                @enderror

                <img id="preview-gambar" class="preview-img">
            </div>

            <button class="btn-register">Buat Akun</button>
        </form>

        <div class="login-text">
            Sudah punya akun? <a href="{{ route('login') }}">Login</a>
        </div>
    </div>

    <script>
        /* Show password */
        document.getElementById("togglePassword").addEventListener("click", function() {
            const pw = document.getElementById("password");
            const hidden = pw.type === "password";
            pw.type = hidden ? "text" : "password";
            this.setAttribute("icon", hidden ? "mdi:eye-off-outline" : "mdi:eye-outline");
        });

        /* Preview Foto */
        function previewFoto(event) {
            const img = document.getElementById("preview-gambar");
            img.src = URL.createObjectURL(event.target.files[0]);
            img.style.display = "block";
        }
    </script>

</body>

</html>
