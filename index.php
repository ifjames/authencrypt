<?php
// index.php: Landing page
session_start();

// If user is already logged in, redirect to dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuthEncrypt - Secure Authentication System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh; color: white;
        }
        .hero { 
            display: flex; align-items: center; justify-content: center;
            min-height: 100vh; text-align: center; padding: 2rem;
        }
        .hero-content { max-width: 600px; }
        .logo { margin-bottom: 2rem; }
        .logo i { font-size: 4rem; margin-bottom: 1rem; opacity: 0.9; }
        .hero h1 { font-size: 3rem; margin-bottom: 1rem; font-weight: 300; }
        .hero p { font-size: 1.2rem; margin-bottom: 3rem; opacity: 0.9; line-height: 1.6; }
        .cta-buttons { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
        .btn { 
            padding: 15px 30px; border-radius: 10px; text-decoration: none;
            font-weight: 600; font-size: 1.1rem; transition: all 0.3s ease;
            display: inline-flex; align-items: center; gap: 0.5rem;
        }
        .btn-primary { 
            background: rgba(255,255,255,0.2); color: white; 
            border: 2px solid rgba(255,255,255,0.3);
        }
        .btn-secondary { 
            background: white; color: #667eea; 
            border: 2px solid white;
        }
        .btn:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(0,0,0,0.2); }
        .features { 
            position: absolute; bottom: 2rem; left: 50%; transform: translateX(-50%);
            display: flex; gap: 3rem; opacity: 0.8;
        }
        .feature { text-align: center; }
        .feature i { font-size: 1.5rem; margin-bottom: 0.5rem; }
        .feature span { font-size: 0.9rem; }
        @media (max-width: 768px) {
            .hero h1 { font-size: 2rem; }
            .hero p { font-size: 1rem; }
            .cta-buttons { flex-direction: column; align-items: center; }
            .features { position: static; transform: none; margin-top: 3rem; }
        }
    </style>
</head>
<body>
    <div class="hero">
        <div class="hero-content">
            <div class="logo">
                <i class="fas fa-shield-alt"></i>
            </div>
            <h1>AuthEncrypt</h1>
            <p>A modern, secure authentication system built with PHP and advanced security practices. Experience seamless user management with password hashing, session control, and elegant design.</p>
            
            <div class="cta-buttons">
                <a href="login.php" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i>
                    Sign In
                </a>
                <a href="register.php" class="btn btn-secondary">
                    <i class="fas fa-user-plus"></i>
                    Create Account
                </a>
            </div>
        </div>
    </div>
    
    <div class="features">
        <div class="feature">
            <i class="fas fa-lock"></i>
            <div><span>Secure Hashing</span></div>
        </div>
        <div class="feature">
            <i class="fas fa-database"></i>
            <div><span>SQLite Database</span></div>
        </div>
        <div class="feature">
            <i class="fas fa-shield-alt"></i>
            <div><span>Session Management</span></div>
        </div>
    </div>
</body>
</html>
