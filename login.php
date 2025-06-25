<?php
// login.php: User Login
session_start();

// Database configuration
require_once 'config.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($email && $password) {
        try {
            $stmt = $pdo->prepare('SELECT id, name, password FROM users WHERE email = ?');
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['login_time'] = date('Y-m-d H:i:s');
                header('Location: dashboard.php');
                exit;
            } else {
                $error = 'Invalid email or password.';
            }
        } catch (PDOException $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    } else {
        $error = 'All fields are required.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuthEncrypt - Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
        }
        .auth-container { 
            background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);
            padding: 2.5rem; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            width: 100%; max-width: 400px; border: 1px solid rgba(255,255,255,0.2);
        }
        .logo { text-align: center; margin-bottom: 2rem; }
        .logo i { font-size: 3rem; color: #667eea; margin-bottom: 0.5rem; }
        .logo h1 { color: #333; font-size: 1.8rem; font-weight: 300; }
        .form-group { margin-bottom: 1.5rem; position: relative; }
        .form-group i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #999; }
        input[type=email], input[type=password] { 
            width: 100%; padding: 15px 15px 15px 45px; border: 2px solid #e1e1e1; 
            border-radius: 10px; font-size: 1rem; transition: all 0.3s ease;
            background: rgba(255,255,255,0.9);
        }
        input:focus { border-color: #667eea; outline: none; box-shadow: 0 0 0 3px rgba(102,126,234,0.1); }
        .btn { 
            width: 100%; padding: 15px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white; border: none; border-radius: 10px; font-size: 1.1rem; 
            cursor: pointer; transition: all 0.3s ease; font-weight: 600;
        }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(102,126,234,0.3); }
        .alert { padding: 12px; border-radius: 8px; margin-bottom: 1rem; }
        .alert-error { background: #fee; border: 1px solid #fcc; color: #c33; }
        .alert-success { background: #efe; border: 1px solid #cfc; color: #3c3; }
        .auth-links { text-align: center; margin-top: 1.5rem; }
        .auth-links a { color: #667eea; text-decoration: none; font-weight: 500; }
        .auth-links a:hover { text-decoration: underline; }
    </style>
</head>
<body>
<div class="auth-container">
    <div class="logo">
        <i class="fas fa-shield-alt"></i>
        <h1>AuthEncrypt</h1>
    </div>
    
    <?php if (isset($_GET['registered'])): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> Registration successful! Please sign in.
        </div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-triangle"></i> <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>
    
    <form method="post" autocomplete="off">
        <div class="form-group">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" placeholder="Email Address" required>
        </div>
        
        <div class="form-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder="Password" required>
        </div>
        
        <button type="submit" class="btn">
            <i class="fas fa-sign-in-alt"></i> Sign In
        </button>
    </form>
    
    <div class="auth-links">
        Don't have an account? <a href="register.php">Create one here</a>
    </div>
</div>
</body>
</html>
