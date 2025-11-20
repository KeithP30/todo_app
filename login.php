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

        <form method="POST" id="loginForm">
            <input type="text" name="username" placeholder="Username" required autocomplete="username">
            <input type="password" name="password" placeholder="Password" required autocomplete="current-password">
            <button type="submit">LOGIN</button>
        </form>

        <p class="register-link">
            Belum punya akun? 
            <a href="#" id="registerLink">Daftar sekarang</a>
        </p>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            document.getElementById('loadingOverlay').style.display = 'flex';
            this.submit(); 
        });
        document.getElementById('registerLink').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('loadingOverlay').style.display = 'flex';
            setTimeout(() => {
                window.location.href = 'register.php';
            }, 800);
        });
    </script>
</body>
</html>