<?php
session_start();
session_destroy();
header("Location: loading.php?redirect=login.php");
exit;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connecting to Night City...</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --bg: #0a0a14;
            --neon-blue: #00f0ff;
            --gold: #ffd700;
            --text: #e0e0ff;
        }

        body {
            background-color: var(--bg);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: 'Orbitron', sans-serif;
            overflow: hidden;
            color: var(--text);
        }

        .cyber-loader-container {
            text-align: center;
            position: relative;
        }

        .logo-text {
            font-size: 2.8rem;
            margin-bottom: 2rem;
            background: linear-gradient(to right, var(--neon-blue), var(--gold));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            letter-spacing: 2px;
            text-shadow: 0 0 10px rgba(0, 240, 255, 0.4);
        }

        .glitch-msg {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 2rem;
            color: var(--neon-blue);
            position: relative;
            animation: glitch-pulse 2s infinite;
        }

        @keyframes glitch-pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        .scan-line {
            position: absolute;
            top: 0;
            left: -20px;
            width: calc(100% + 40px);
            height: 4px;
            background: rgba(0, 240, 255, 0.7);
            box-shadow: 0 0 12px var(--neon-blue);
            animation: scan 2.5s linear infinite;
            z-index: 2;
        }

        @keyframes scan {
            0% { top: 0%; }
            100% { top: 100%; }
        }

        .dots {
            display: flex;
            justify-content: center;
            gap: 6px;
            margin-top: 1.5rem;
        }

        .dot {
            width: 10px;
            height: 10px;
            background: var(--neon-blue);
            border-radius: 50%;
            animation: pulse 1.4s infinite both;
        }

        .dot:nth-child(2) { animation-delay: 0.2s; }
        .dot:nth-child(3) { animation-delay: 0.4s; }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.2); opacity: 0.4; }
        }

        /* Efek glitch tambahan (opsional) */
        .glitch-msg::before,
        .glitch-msg::after {
            content: attr(data-text);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .glitch-msg::before {
            color: var(--gold);
            animation: glitch-1 3s infinite;
            clip-path: polygon(0 0, 100% 0, 100% 45%, 0 45%);
            opacity: 0.2;
        }

        .glitch-msg::after {
            color: #ff00ff;
            animation: glitch-2 3.5s infinite;
            clip-path: polygon(0 55%, 100% 55%, 100% 100%, 0 100%);
            opacity: 0.2;
        }

        @keyframes glitch-1 {
            0%, 100% { transform: translate(0); }
            20% { transform: translate(-3px, 0); }
            40% { transform: translate(2px, 0); }
            60% { transform: translate(-1px, 0); }
            80% { transform: translate(1px, 0); }
        }

        @keyframes glitch-2 {
            0%, 100% { transform: translate(0); }
            20% { transform: translate(3px, 0); }
            40% { transform: translate(-2px, 0); }
            60% { transform: translate(1px, 0); }
            80% { transform: translate(-1px, 0); }
        }
    </style>
</head>
<body>
    <div class="cyber-loader-container">
        <div class="logo-text">NIGHT<span style="color:var(--gold); -webkit-text-fill-color:var(--gold);">TASK</span></div>
        <div class="glitch-msg" data-text="ACCESSING NETWORK...">ACCESSING NETWORK...</div>
        <div class="scan-line"></div>
        <div class="dots">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
    </div>

    <script>
        // Redirect otomatis setelah loading
        const redirectUrl = new URLSearchParams(window.location.search).get('redirect') || 'index.php';
        setTimeout(() => {
            window.location.href = redirectUrl;
        }, <?php echo $delay; ?>);
    </script>
</body>
</html>