<?php
// Setup database for the application
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Setting up database</h1>";

// Load database configuration
$config_path = './application/config/database.php';
if (!file_exists($config_path)) {
    die("Database configuration file not found at $config_path");
}

require_once $config_path;

$host = $db['default']['hostname'];
$username = $db['default']['username'];
$password = $db['default']['password'];
$database = $db['default']['database'];

echo "<p>Connecting to: $host as $username</p>";
echo "<p>Creating database: $database</p>";

try {
    // Connect to MySQL server without selecting database
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p style='color: green;'>✓ Connected to MySQL server</p>";
    
    // Create database if it doesn't exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "<p style='color: green;'>✓ Database '$database' created or already exists</p>";
    
    // Select the database
    $pdo->exec("USE `$database`");
    
    // Read and execute the SQL file
    $sql_file = './mypos (1).sql';
    if (!file_exists($sql_file)) {
        die("<p style='color: red;'>SQL file not found: $sql_file</p>");
    }
    
    $sql_content = file_get_contents($sql_file);
    
    // Remove the initial parts that create the database
    $sql_content = preg_replace('/-- phpMyAdmin SQL Dump.*?--\n-- Database: `mypos` --\n--.*?\n/s', '', $sql_content);
    $sql_content = preg_replace('/SET SQL_MODE.*?COMMIT;/s', '', $sql_content);
    $sql_content = trim($sql_content);
    
    // Split and execute the statements
    $statements = array_filter(array_map('trim', explode(';', $sql_content)), function($line) {
        return !empty($line) && strpos($line, '--') !== 0;
    });
    
    $successful_statements = 0;
    $total_statements = count($statements);
    
    foreach ($statements as $statement) {
        if (!empty(trim($statement))) {
            try {
                $pdo->exec($statement);
                $successful_statements++;
            } catch (PDOException $e) {
                // Some statements might fail if elements already exist, which is OK
                echo "<p>Info: Could not execute: " . substr($statement, 0, 100) . "... Error: " . $e->getMessage() . "</p>";
            }
        }
    }
    
    echo "<p style='color: green;'>✓ Completed importing database schema. $successful_statements of $total_statements statements executed.</p>";
    
    // Verify important tables exist
    $tables = ['user', 'p_item', 'customer', 'supplier', 'p_category', 'p_unit'];
    echo "<h2>Table Verification:</h2>";
    foreach ($tables as $table) {
        $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
        if ($stmt->rowCount() > 0) {
            echo "<p style='color: green;'>✓ Table '$table' exists</p>";
        } else {
            echo "<p style='color: orange;'>? Table '$table' may not exist</p>";
        }
    }
    
    echo "<h2>Sample Data Check:</h2>";
    try {
        $user_count = $pdo->query("SELECT COUNT(*) FROM user")->fetchColumn();
        echo "<p>Users in database: $user_count</p>";
        
        if ($user_count > 0) {
            $users = $pdo->query("SELECT username, name, level FROM user LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
            echo "<h3>Sample Users:</h3><ul>";
            foreach ($users as $user) {
                $level_text = $user['level'] == 1 ? 'Admin' : 'Cashier';
                echo "<li>{$user['username']} ({$user['name']}) - Level: $level_text</li>";
            }
            echo "</ul>";
        }
    } catch (Exception $e) {
        echo "<p>Could not fetch sample data: " . $e->getMessage() . "</p>";
    }
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
}

echo "<h2><a href='index.php/auth/login'>Go to Login Page</a></h2>";
?>