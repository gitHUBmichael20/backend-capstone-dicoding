<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SatoePinjam - Masuk</title>
  <link rel="stylesheet" href="{{ asset('css/login-singup.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
  <div class="auth-container">
    <!-- Left Panel (Login Form) -->
    <div class="auth-left-panel">
      <a href="index.html" class="back-link">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke SatoePinjam
      </a>

      <div class="logo-container">
        <h1 class="modena-logo">SatoePinjam</h1>
      </div>

      <!-- Sign In Form -->
      <div class="auth-form-container">
        <h2 class="auth-title">Masuk</h2>

        <form>
          <div class="input-group">
            <div class="input-container">
              <i class="fa-solid fa-user input-icon"></i>
              <input type="text" placeholder="Email atau No HP" class="input-field">
            </div>
          </div>

          <div class="input-group">
            <div class="input-container">
              <i class="fa-solid fa-lock input-icon"></i>
              <input type="password" placeholder="Kata Sandi" class="input-field">
              <button type="button" class="password-toggle">
                <i class="fa-solid fa-eye"></i>
              </button>
            </div>
          </div>

          <button type="submit" class="auth-button">Masuk</button>

          <!-- <div class="forgot-password">
            <a href="#">lupa kata sandi Anda?</a>
          </div>

          <div class="separator">
            <span>atau Masuk dengan</span>
          </div>

          <button type="button" class="social-button">
            <img src="assets/images/google-icon.png" alt="Google" class="social-icon">
            Google
          </button> -->

          <div class="auth-footer">
            Belum memiliki akun? <a href="{{ route('/signup') }}">Daftar</a>
          </div>
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
