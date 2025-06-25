<?php
// dashboard.php: Modern user dashboard
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Database configuration
require_once 'config.php';

$name = $_SESSION['user_name'] ?? 'User';
$user_id = $_SESSION['user_id'];

// Get user info and stats
try {
    $stmt = $pdo->prepare('SELECT name, email FROM users WHERE id = ?');
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Count total users (for demo stats)
    $stmt = $pdo->prepare('SELECT COUNT(*) as total_users FROM users');
    $stmt->execute();
    $stats = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $user = ['name' => $name, 'email' => 'N/A'];
    $stats = ['total_users' => 0];
}

$current_time = date('Y-m-d H:i:s');
$login_time = $_SESSION['login_time'] ?? $current_time;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuthEncrypt - Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        .sidebar {
            position: fixed; left: 0; top: 0; height: 100vh; width: 280px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white; padding: 2rem 0; z-index: 1000;
        }
        .sidebar .logo { text-align: center; margin-bottom: 3rem; }
        .sidebar .logo i { font-size: 2.5rem; margin-bottom: 0.5rem; }
        .sidebar .logo h2 { font-weight: 300; }
        .nav-menu { list-style: none; }
        .nav-item { margin: 0.5rem 0; }
        .nav-link { 
            display: flex; align-items: center; padding: 1rem 2rem; 
            color: rgba(255,255,255,0.8); text-decoration: none; 
            transition: all 0.3s ease;
        }
        .nav-link:hover, .nav-link.active { 
            background: rgba(255,255,255,0.1); color: white; 
        }
        .nav-link i { margin-right: 1rem; width: 20px; }
        .main-content { margin-left: 280px; padding: 2rem; }
        .header { 
            background: white; border-radius: 15px; padding: 1.5rem 2rem; 
            margin-bottom: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            display: flex; justify-content: between; align-items: center;
        }
        .welcome { flex: 1; }
        .welcome h1 { color: #333; margin-bottom: 0.5rem; }
        .welcome p { color: #666; }
        .logout-btn { 
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            color: white; border: none; padding: 12px 24px; border-radius: 8px;
            cursor: pointer; font-weight: 600; transition: all 0.3s ease;
        }
        .logout-btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(255,107,107,0.3); }
        .dashboard-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; }
        .card { 
            background: white; border-radius: 15px; padding: 2rem; 
            box-shadow: 0 5px 15px rgba(0,0,0,0.08); transition: transform 0.3s ease;
        }
        .card:hover { transform: translateY(-5px); }
        .card-header { display: flex; align-items: center; margin-bottom: 1.5rem; }
        .card-icon { 
            width: 50px; height: 50px; border-radius: 12px; 
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; margin-right: 1rem;
        }
        .card-title { font-size: 1.2rem; color: #333; }
        .stat-number { font-size: 2.5rem; font-weight: bold; color: #667eea; }
        .stat-label { color: #666; margin-top: 0.5rem; }
        .profile-info { }
        .info-row { display: flex; justify-content: space-between; padding: 1rem 0; border-bottom: 1px solid #eee; }
        .info-row:last-child { border-bottom: none; }
        .info-label { font-weight: 600; color: #666; }
        .info-value { color: #333; }
        .activity-item { display: flex; align-items: center; padding: 1rem 0; border-bottom: 1px solid #eee; }
        .activity-item:last-child { border-bottom: none; }
        .activity-icon { 
            width: 40px; height: 40px; border-radius: 10px; background: #667eea;
            color: white; display: flex; align-items: center; justify-content: center;
            margin-right: 1rem;
        }
        .activity-text { flex: 1; }
        .activity-time { color: #666; font-size: 0.9rem; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <i class="fas fa-shield-alt"></i>
            <h2>AuthEncrypt</h2>
        </div>
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="#" class="nav-link active">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <div class="welcome">
                <h1>Welcome back, <?php echo htmlspecialchars($user['name']); ?>!</h1>
                <p>Here's what's happening with your account today.</p>
            </div>
            <form action="logout.php" method="post" style="display: inline;">
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>

        <div class="dashboard-grid">
            <div class="card">
                <div class="card-header">
                    <div class="card-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="card-title">Total Users</div>
                </div>
                <div class="stat-number"><?php echo number_format($stats['total_users']); ?></div>
                <div class="stat-label">Registered users in system</div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <div class="card-title">Profile Information</div>
                </div>
                <div class="profile-info">
                    <div class="info-row">
                        <span class="info-label">Name:</span>
                        <span class="info-value"><?php echo htmlspecialchars($user['name']); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Email:</span>
                        <span class="info-value"><?php echo htmlspecialchars($user['email']); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">User ID:</span>
                        <span class="info-value">#<?php echo $user_id; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Login Time:</span>
                        <span class="info-value"><?php echo date('M j, Y g:i A'); ?></span>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white;">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div class="card-title">Recent Activity</div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-sign-in-alt"></i>
                    </div>
                    <div class="activity-text">
                        <div>Successful login</div>
                        <div class="activity-time"><?php echo date('M j, Y g:i A'); ?></div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="activity-text">
                        <div>Security check passed</div>
                        <div class="activity-time"><?php echo date('M j, Y g:i A'); ?></div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="activity-text">
                        <div>Profile accessed</div>
                        <div class="activity-time"><?php echo date('M j, Y g:i A'); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
