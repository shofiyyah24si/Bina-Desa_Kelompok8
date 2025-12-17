<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Sistem Tanggap Darurat</title>
    
    <!-- Bootstrap 5.3.0 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <style>
        body {
            background-color: #ffffff; /* Diubah dari gradient ke putih penuh */
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
        }
        
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            width: 100%;
        }
        
        .login-card {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            border: none;
            width: 100%;
            max-width: 420px;
        }
        
        .login-header {
            background: linear-gradient(135deg, #0069d9 0%, #004a99 100%);
            border-radius: 15px 15px 0 0;
            padding: 2rem;
        }
        
        .login-body {
            padding: 2rem;
            background-color: white;
            border-radius: 0 0 15px 15px;
        }
        
        .input-group-text {
            border-right: none;
            background-color: #f8f9fa;
        }
        
        .form-control {
            border-left: none;
        }
        
        .form-control:focus {
            box-shadow: none;
            border-color: #0069d9;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #0069d9 0%, #0056b3 100%);
            border: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            padding: 12px;
            font-weight: 600;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 105, 217, 0.4);
        }
        
        .back-link {
            color: #6c757d;
            text-decoration: none;
            transition: color 0.2s;
        }
        
        .back-link:hover {
            color: #0069d9;
        }
        
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }
        
        .input-group {
            margin-bottom: 1.5rem;
        }
        
        .remember-me {
            margin-bottom: 1.5rem;
        }
        
        .login-title {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .login-subtitle {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-bottom: 0;
        }
        
        .icon-large {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <!-- Header dengan Gradient -->
            <div class="login-header text-center text-white">
                <div class="icon-large">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h1 class="login-title">Login ke Sistem</h1>
                <p class="login-subtitle">Masukkan kredensial Anda</p>
            </div>
            
            <!-- Form Login -->
            <div class="login-body">
                <form method="POST" action="{{ route('login.submit') }}">
                    @csrf
                    
                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <!-- Email/Username Field -->
                    <div class="mb-4">
                        <label for="email" class="form-label">
                            <i class="bi bi-person-circle me-1"></i>
                            Username atau Email
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-envelope"></i>
                            </span>
                            <input type="text" 
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email" 
                                   name="email"
                                   placeholder="admin@example.com"
                                   value="{{ old('email') }}"
                                   required
                                   autofocus>
                            @error('email')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="mb-4">
                        <label for="password" class="form-label">
                            <i class="bi bi-key me-1"></i>
                            Password
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror"
                                   id="password" 
                                   name="password"
                                   placeholder="••••••••"
                                   required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="bi bi-eye"></i>
                            </button>
                            @error('password')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="remember-me">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember">
                            <label class="form-check-label" for="remember">
                                Ingat saya
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mb-4">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-box-arrow-in-right me-2"></i>
                            Masuk ke Sistem
                        </button>
                    </div>

                    <!-- Back to Home -->
                    <div class="text-center pt-3 border-top">
                        <a href="{{ route('landing') }}" class="back-link">
                            <i class="bi bi-arrow-left me-1"></i>
                            Kembali ke Halaman Utama
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Toggle Password Visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });

        // Auto focus pada input email
        document.getElementById('email').focus();
    </script>
</body>
</html>