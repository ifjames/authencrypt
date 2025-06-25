<?php
// config/database.php: Database configuration for Laragon MySQL

class Database {
    // Laragon MySQL default settings
    private $host = 'localhost';
    private $port = '3306';
    private $db_name = 'authencrypt';  // Change this to your desired database name
    private $username = 'root';        // Laragon default MySQL username
    private $password = '';            // Laragon default MySQL password (empty)
    private $charset = 'utf8mb4';
    
    public $conn;
    
    public function getConnection() {
        $this->conn = null;
        
        try {
            $dsn = "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name . ";charset=" . $this->charset;
            
            $this->conn = new PDO($dsn, $this->username, $this->password);
            
            // Set PDO attributes for better error handling and security
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
            die();
        }
        
        return $this->conn;
    }
    
    // Method to test connection
    public function testConnection() {
        try {
            $conn = $this->getConnection();
            if ($conn) {
                return "✅ Successfully connected to MySQL database: " . $this->db_name;
            }
        } catch(Exception $e) {
            return "❌ Connection failed: " . $e->getMessage();
        }
    }
}

// Alternative function-based approach for simple connections
function getMySQLConnection() {
    $host = 'localhost';
    $port = '3306';
    $dbname = 'authencrypt';
    $username = 'root';
    $password = '';
    $charset = 'utf8mb4';
    
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";
    
    try {
        $pdo = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
        return $pdo;
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
}
?>
