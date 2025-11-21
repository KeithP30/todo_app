<?php
require 'config.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $password]);
    header("Location: loading.php?redirect=login.php");
    exit;
    } catch (PDOException $e) {
        $error = "Username sudah digunakan.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - To-Do List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="auth-page">
    <div class="auth-container">
        <h2>Daftar</h2>
        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <div class="password-wrapper">
    <input 
        id="regPassword" 
        type="password" 
        name="password" 
        placeholder="Password" 
        required 
        autocomplete="new-password"
    >
    <button 
        id="toggleRegPassword" 
        type="button" 
        class="eye-btn" 
        aria-label="Tampilkan kata sandi"
        data-state="hidden"
    >
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
            <button type="submit">Daftar</button>
        </form>
        <p>Sudah punya akun? <a href="login.php">Login</a></p>
    </div>

    <script>
const regPwd = document.getElementById('regPassword');
const toggleRegPwd = document.getElementById('toggleRegPassword');

toggleRegPwd.addEventListener('click', () => {
    const isHidden = regPwd.type === 'password';

    if (isHidden) {
        regPwd.type = 'text';
        toggleRegPwd.setAttribute('data-state', 'shown');
        toggleRegPwd.setAttribute('aria-label', 'Sembunyikan kata sandi');
    } else {
        regPwd.type = 'password';
        toggleRegPwd.setAttribute('data-state', 'hidden');
        toggleRegPwd.setAttribute('aria-label', 'Tampilkan kata sandi');
    }

    regPwd.focus();
});
</script>
</body>
</html>