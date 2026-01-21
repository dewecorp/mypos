<?php
// Check database connection
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load database configuration
$config_path = './application/config/database.php';
if (!file_exists($config_path)) {
    die("Database configuration file not found at $config_path");
}

require_once $config_path;

echo "<h1>Database Connection Test</h1>";

$host = $db['default']['hostname'];
$username = $db['default']['username'];
$password = $db['default']['password'];
$database = $db['default']['database'];

echo "<p>Attempting to connect to: $host</p>";
echo "<p>Database: $database</p>";
echo "<p>Username: $username</p>";

try {
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p style='color: green;'>✓ Successfully connected to MySQL server</p>";
    
    // Check if database exists
    $stmt = $pdo->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$database'");
    if ($stmt->rowCount() > 0) {
        echo "<p style='color: green;'>✓ Database '$database' exists</p>";
        
        // Switch to the database
        $pdo->query("USE $database");
        
        // Check for critical tables
        $tables = ['user', 'p_item', 'customer', 'supplier', 'p_category', 'p_unit'];
        foreach ($tables as $table) {
            $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
            if ($stmt->rowCount() > 0) {
                echo "<p style='color: green;'>✓ Table '$table' exists</p>";
            } else {
                echo "<p style='color: red;'>✗ Table '$table' does NOT exist</p>";
            }
        }
    } else {
        echo "<p style='color: red;'>✗ Database '$database' does NOT exist</p>";
        echo "<p>You need to create the database and import the SQL file.</p>";
    }
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>✗ Connection failed: " . $e->getMessage() . "</p>";
    echo "<p>Please check your database credentials in application/config/database.php</p>";
}

echo "<h2>Database Configuration:</h2>";
echo "<pre>";
print_r($db['default']);
echo "</pre>";
?>