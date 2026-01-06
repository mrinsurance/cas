<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Just a moment...</title>
    <link rel="icon" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/svg/cloudflare.svg" type="image/svg+xml">
    <style>
        :root {
            --cf-blue: #f38020;
            --cf-orange: #f38020;
            --text: #2c2e33;
            --bg: #f8f9fa;
            --card: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 20px;
        }

        .container {
            background: var(--card);
            border-radius: 12px;
            box-shadow: 
                0 10px 30px rgba(0,0,0,0.08),
                0 0 0 1px rgba(0,0,0,0.03);
            max-width: 480px;
            width: 100%;
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #f38020 0%, #ff9d5c 100%);
            color: white;
            padding: 28px 32px;
            text-align: center;
        }

        .logo {
            font-size: 42px;
            font-weight: bold;
            letter-spacing: -1px;
            margin-bottom: 8px;
        }

        .status {
            font-size: 18px;
            opacity: 0.95;
            margin-top: 12px;
        }

        .content {
            padding: 32px;
            text-align: center;
        }

        .spinner {
            width: 64px;
            height: 64px;
            margin: 0 auto 28px;
            position: relative;
        }

        .spinner::before,
        .spinner::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            inset: 0;
        }

        .spinner::before {
            border: 4px solid #f38020;
            border-top-color: transparent;
            animation: spin 1.1s linear infinite;
        }

        .spinner::after {
            border: 3px solid rgba(243,128,32,0.2);
            border-top-color: rgba(243,128,32,0.7);
            animation: spin 1.4s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        h1 {
            font-size: 26px;
            margin-bottom: 16px;
            color: #1a1a1a;
        }

        .message {
            color: #555;
            line-height: 1.6;
            margin-bottom: 28px;
            font-size: 15px;
        }

        .footer {
            background: #f8f9fa;
            padding: 20px;
            font-size: 13px;
            color: #666;
            text-align: center;
            border-top: 1px solid #eee;
        }

        .small {
            font-size: 12px;
            opacity: 0.7;
            margin-top: 8px;
        }

        .ray-id {
            font-family: 'Courier New', Courier, monospace;
            background: #f0f0f0;
            padding: 4px 8px;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <div class="logo">cloudflare</div>
        <div class="status">Checking your browser before accessing...</div>
    </div>

    <div class="content">
        <div class="spinner"></div>
        
        <h1>One more step</h1>
        
        <p class="message">
            Please complete the security check to access <strong>example.com</strong>.<br>
            This process is automatic. Your browser will redirect to your requested content shortly.
        </p>

        <div class="message" style="margin-top: 24px;">
            Performing SSL/TLS handshake verification...
        </div>
    </div>

    <div class="footer">
        <div>Ray ID: <span class="ray-id">8a4b9c2d7e1f03k1</span></div>
        <div class="small">2026-01-02 14:37:22 UTC • Your IP: 172.67.142.XX • Performance & security by Cloudflare</div>
    </div>
</div>

<script>
    // Fake progress simulation
    setTimeout(() => {
        document.querySelector('.message:last-child').textContent = 
            "Almost there... establishing secure connection";
    }, 2200);

    setTimeout(() => {
        document.querySelector('.message:last-child').textContent = 
            "Connection secured ✓ Redirecting...";
    }, 4800);

    // You can uncomment this if you want auto-redirect simulation
    /*
    setTimeout(() => {
        document.body.innerHTML = '<h1 style="text-align:center;margin-top:40vh;color:#555">Redirecting...</h1>';
    }, 7200);
    */
</script>
</body>
</html>