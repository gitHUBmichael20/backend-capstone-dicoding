<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SatoePinjam - Masuk</title>
  <link rel="stylesheet" href="{{ asset('css/login-singup.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
  @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/login.js'])
</head>
<body>
    @if (session('failed'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: "{{ session('failed') }}",
                    showConfirmButton: false,
                    timer: 1500
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
              <input type="email" placeholder="Masukkan email anda" class="input-field" name="email">
            </div>
          </div>

          <div class="input-group">
            <div class="input-container">
              <i class="fa-solid fa-lock input-icon"></i>
              <input type="password" placeholder="Kata Sandi" class="input-field" name="password">
              <button type="button" class="password-toggle">
                <i class="fa-solid fa-eye"></i>
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
</body>
</html> 