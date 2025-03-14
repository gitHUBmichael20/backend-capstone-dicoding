<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SatoePinjam - Daftar</title>
  <link rel="stylesheet" href="{{ asset('css/login-singup.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    @if (session('failed'))
    <script>
        Swal.fire({
            icon: 'error',
            title: '{{ session('failed') }}',
            showConfirmButton: false,
            timer: 2500
        });
    </script>
    @endif

  <div class="auth-container">
    <!-- Left Panel (Sign Up Form) -->
    <div class="auth-left-panel">
      <a href="{{ route('login') }}" class="back-link">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke login page
      </a>

      <div class="logo-container">
        <h1 class="modena-logo">SatoePinjam</h1>
      </div>

      <!-- Sign Up Form -->
      <div class="auth-form-container">
        <h2 class="auth-title">Daftar</h2>

        <form method="POST" action="{{ url('/api/register') }}">
            {{-- @csrf --}}
          <div class="input-group">
            <div class="input-container">
              <i class="fa-solid fa-user input-icon"></i>
              <input type="text" placeholder="Nama" class="input-field" name="nama_pengguna">
            </div>
          </div>

          <div class="input-group">
            <div class="input-container phone-container">
              <div class="phone-prefix">
                <span>+62</span>
                <i class="fa-solid fa-caret-down"></i>
              </div>
              <input type="tel" placeholder="No HP" class="input-field phone-input" name="nomor_telepon">
            </div>
          </div>

          <div class="input-group">
            <div class="input-container">
              <i class="fa-solid fa-envelope input-icon"></i>
              <input type="email" placeholder="Email" class="input-field" name="email">
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

          {{-- <div class="input-group">
            <div class="input-container">
              <i class="fa-solid fa-lock input-icon"></i>
              <input type="password" placeholder="Konfirmasi Kata Sandi" class="input-field">
              <button type="button" class="password-toggle">
                <i class="fa-solid fa-eye"></i>
              </button>
            </div>
          </div> --}}

          <button type="submit" class="auth-button">Daftar</button>

          {{-- <div class="separator">
            <span>atau Masuk dengan</span>
          </div>

          <button type="button" class="social-button">
            <img src="google-icon.png" alt="Google" class="social-icon">
            Google
          </button>

          <div class="auth-footer">
            Sudah memiliki akun? <a href="index.html">Masuk</a>
          </div> --}}
        </form>
      </div>
    </div>

    <!-- Right Panel (Kitchen Image) -->
    <div class="auth-right-panel">
      <!-- Background image will be added via CSS -->
    </div>
  </div>
</body>
</html>
