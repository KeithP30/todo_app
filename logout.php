<?php
session_start();
session_destroy();

header("Refresh: 0.5; url=login.php");
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="loading-overlay" style="display:flex;">
        <div class="cyber-loader">
            <div class="glitch">DISCONNECTING...</div>
            <div class="scan-line"></div>
        </div>
    </div>
</body>
</html>