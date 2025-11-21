<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

require 'config.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $username;
        echo '<script>
            window.location.href = "index.php";
        </script>';
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login • NightTask</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
</head>
<body class="auth-page">
    
    <div id="loadingOverlay" class="loading-overlay">
        <div class="cyber-loader">
            <div class="scan-line"></div>
        </div>
    </div>

    <div class="auth-container">
        <div class="logo">
            <h1>NIGHT<span class="gold">TASK</span></h1>
        </div>

        <p class="welcome">Selamat datang di NightTask.<br>Log in untuk mengakses daftar tugas pribadimu di Night City.</p>

        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST" id="loginForm" class="auth-form">
    <input type="text" name="username" placeholder="Username" required autocomplete="username">
    <div class="password-wrapper">
  <input id="passwordInput" type="password" name="password" placeholder="Password" required>
  <button id="togglePassword" type="button" class="eye-btn" aria-label="Tampilkan kata sandi" data-state="hidden">
    <!-- icon eye (visible by default) -->
    <svg class="icon-eye" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
      <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
      <circle cx="12" cy="12" r="3" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>

    <!-- icon eye-slash (hidden by default) -->
    <svg class="icon-eye-slash" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
      <path d="M17.94 17.94A10.94 10.94 0 0 1 12 19c-7 0-11-7-11-7a16.36 16.36 0 0 1 5.06-4.94" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
      <path d="M1 1l22 22" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
  </button>
</div>
    <button type="submit">LOGIN</button>
</form>

        <p class="register-link">
            Belum punya akun? 
            <a href="#" id="registerLink">Daftar sekarang</a>
        </p>
    </div>

   <script>
    
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        document.getElementById('loadingOverlay').style.display = 'flex';
        this.submit();
    });
    document.getElementById('registerLink').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('loadingOverlay').style.display = 'flex';
        setTimeout(() => { window.location.href = 'register.php'; }, 800);
    });
    // toggle password visibility
    (function() {
        const pwd = document.getElementById('passwordInput');
        const toggle = document.getElementById('togglePassword');
        toggle.addEventListener('click', () => {
  const isHidden = pwd.type === 'password';
  if (isHidden) {
    pwd.type = 'text';
    toggle.setAttribute('data-state', 'shown');    // show slash
    toggle.setAttribute('aria-label', 'Sembunyikan kata sandi');
  } else {
    pwd.type = 'password';
    toggle.setAttribute('data-state', 'hidden');   // show eye
    toggle.setAttribute('aria-label', 'Tampilkan kata sandi');
  }
  pwd.focus();
        });

        // keyboard accessibility: toggle dengan Enter atau Space ketika button fokus
        toggle.addEventListener('keydown', function(e) {
            if (e.key === ' ' || e.key === 'Enter') {
                e.preventDefault();
                toggle.click();
            }
        });
    })();
</script>
</body>
</html>