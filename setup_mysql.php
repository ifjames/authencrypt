<?php
// setup_mysql.php: Setup script for MySQL database and tables

echo "<h2>🚀 AuthEncrypt MySQL Setup</h2>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{color:green;} .error{color:red;} .info{color:blue;}</style>";

// Step 1: Create database
try {
    echo "<h3>Step 1: Creating Database</h3>";
    
    // Connect to MySQL without specifying database to create it
    $host = 'localhost';
    $port = '3306';
    $username = 'root';
    $password = '';
    $dbname = 'authencrypt';
    
    $dsn = "mysql:host=$host;port=$port;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    
    // Create database if it doesn't exist
    $sql = "CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    $pdo->exec($sql);
    echo "<p class='success'>✅ Database '$dbname' created successfully (or already exists)</p>";
    
} catch (PDOException $e) {
    echo "<p class='error'>❌ Error creating database: " . $e->getMessage() . "</p>";
    die();
}

// Step 2: Connect to the specific database and create tables
try {
    echo "<h3>Step 2: Creating Tables</h3>";
    
    // Now connect to the specific database
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
    
    // Create users table
    $createUsersTable = "
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ";
    
    $pdo->exec($createUsersTable);
    echo "<p class='success'>✅ Users table created successfully (or already exists)</p>";
    
} catch (PDOException $e) {
    echo "<p class='error'>❌ Error creating tables: " . $e->getMessage() . "</p>";
    die();
}

// Step 3: Test the connection using our Database class
try {
    echo "<h3>Step 3: Testing Connection</h3>";
    
    require_once 'config/database.php';
    $database = new Database();
    $result = $database->testConnection();
    echo "<p class='success'>$result</p>";
    
    // Test a simple query
    $conn = $database->getConnection();
    $stmt = $conn->query("SELECT COUNT(*) as user_count FROM users");
    $result = $stmt->fetch();
    echo "<p class='info'>📊 Current users in database: " . $result['user_count'] . "</p>";
    
} catch (Exception $e) {
    echo "<p class='error'>❌ Connection test failed: " . $e->getMessage() . "</p>";
}

// Step 4: Show connection details
echo "<h3>Step 4: Connection Details</h3>";
echo "<div style='background:#f5f5f5;padding:15px;border-radius:5px;'>";
echo "<strong>Database Configuration:</strong><br>";
echo "• Host: localhost<br>";
echo "• Port: 3306<br>";
echo "• Database: authencrypt<br>";
echo "• Username: root<br>";
echo "• Password: (empty)<br>";
echo "</div>";

echo "<h3>🎉 Setup Complete!</h3>";
echo "<p>Your AuthEncrypt application is now configured to use Laragon's MySQL database.</p>";
echo "<p><a href='index.php' style='background:#667eea;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>Go to Application</a></p>";
?>
