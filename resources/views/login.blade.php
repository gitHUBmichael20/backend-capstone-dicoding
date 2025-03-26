<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SatoePinjam - Masuk</title>
    <link rel="stylesheet" href="{{ asset('css/login-singup.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 2500
                });
            });
        </script>
    @endif

    @if (session('failed'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: "{{ session('failed') }}",
                    showConfirmButton: false,
                    timer: 2500
                });
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    html: `{!! implode('<br>', $errors->all()) !!}`,
                    showConfirmButton: false,
                    timer: 2500
                });
            });
        </script>
    @endif

    <div class="auth-container">
        <div class="auth-left-panel">
            <a href="/" class="back-link">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke SatoePinjam
            </a>

            <div class="logo-container">
                <h1 class="modena-logo">SatoePinjam</h1>
            </div>

            <div class="auth-form-container">
                <h2 class="auth-title">Masuk</h2>

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    <div class="input-group">
                        <div class="input-container">
                            <i class="fa-solid fa-user input-icon"></i>
                            <input type="text" placeholder="Email atau No HP" class="input-field" name="email" value="{{ old('email') }}">
                        </div>
                    </div>

                    <div class="input-group">
                        <div class="input-container">
                            <i class="fa-solid fa-lock input-icon"></i>
                            <input type="password" placeholder="Kata Sandi" class="input-field" name="password" id="password">
                            <button type="button" class="password-toggle">
                                <i class="fa-solid fa-eye" id="toggle-icon"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="auth-button">Masuk</button>

                    <div class="auth-footer">
                        Belum memiliki akun? <a href="{{ route('signup') }}">Daftar</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="auth-right-panel"></div>
    </div>

    <script>
        // Toggle password visibility
        const passwordToggle = document.querySelector('.password-toggle');
        const passwordInput = document.querySelector('#password');
        const toggleIcon = document.querySelector('#toggle-icon');

        passwordToggle.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            toggleIcon.classList.toggle('fa-eye');
            toggleIcon.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>