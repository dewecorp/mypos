<?php
// Debug file to check basic PHP functionality and configuration
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Debug Information</h1>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Current directory: " . getcwd() . "</p>";

// Check if CodeIgniter files exist
$ci_exists = file_exists('./system/core/CodeIgniter.php');
echo "<p>CodeIgniter exists: " . ($ci_exists ? 'YES' : 'NO') . "</p>";

// Check critical directories
echo "<p>Application directory exists: " . (is_dir('./application') ? 'YES' : 'NO') . "</p>";
echo "<p>System directory exists: " . (is_dir('./system') ? 'YES' : 'NO') . "</p>";
echo "<p>Vendor directory exists: " . (is_dir('./vendor') ? 'YES' : 'NO') . "</p>";

// Check for composer autoload
$autoload_exists = file_exists('./vendor/autoload.php');
echo "<p>Composer autoload exists: " . ($autoload_exists ? 'YES' : 'NO') . "</p>";

if ($autoload_exists) {
    require_once './vendor/autoload.php';
    echo "<p>Composer autoload loaded successfully</p>";
    
    // Check if libraries are available
    $dompdf_class = class_exists('Dompdf\Dompdf');
    $qr_class = class_exists('Endroid\QrCode\QrCode');
    echo "<p>Dompdf class exists: " . ($dompdf_class ? 'YES' : 'NO') . "</p>";
    echo "<p>QR Code class exists: " . ($qr_class ? 'YES' : 'NO') . "</p>";
}

// Check if database config exists
$db_config_exists = file_exists('./application/config/database.php');
echo "<p>Database config exists: " . ($db_config_exists ? 'YES' : 'NO') . "</p>";

if ($db_config_exists) {
    include './application/config/database.php';
    echo "<p>Database config loaded, host: {$db['default']['hostname']}</p>";
    echo "<p>Database: {$db['default']['database']}</p>";
}
?>