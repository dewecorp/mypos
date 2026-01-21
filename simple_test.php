<?php
// Simple test to check if CodeIgniter can be loaded
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Simple CodeIgniter Test</h1>";

// Check if system directory exists
if (!is_dir('./system')) {
    die('<p style="color: red;">ERROR: System directory not found!</p>');
} else {
    echo '<p style="color: green;">✓ System directory found</p>';
}

// Check if application directory exists
if (!is_dir('./application')) {
    die('<p style="color: red;">ERROR: Application directory not found!</p>');
} else {
    echo '<p style="color: green;">✓ Application directory found</p>';
}

// Check if vendor directory exists and has packages
if (is_dir('./vendor')) {
    echo '<p style="color: green;">✓ Vendor directory found</p>';
    
    if (file_exists('./vendor/autoload.php')) {
        require_once './vendor/autoload.php';
        echo '<p style="color: green;">✓ Composer autoloader loaded</p>';
        
        // Check for required packages
        if (class_exists('Dompdf\Dompdf')) {
            echo '<p style="color: green;">✓ Dompdf class available</p>';
        } else {
            echo '<p style="color: orange;">⚠ Dompdf class NOT available</p>';
        }
        
        if (class_exists('Endroid\QrCode\QrCode')) {
            echo '<p style="color: green;">✓ QR Code class available</p>';
        } else {
            echo '<p style="color: orange;">⚠ QR Code class NOT available</p>';
        }
    } else {
        echo '<p style="color: orange;">⚠ Composer autoloader NOT found</p>';
    }
} else {
    echo '<p style="color: red;">✗ Vendor directory NOT found</p>';
}

// Try to load CodeIgniter manually
echo "<h2>Trying to load CodeIgniter...</h2>";
if (file_exists('./system/core/CodeIgniter.php')) {
    echo '<p style="color: green;">✓ CodeIgniter core file found</p>';
} else {
    echo '<p style="color: red;">✗ CodeIgniter core file NOT found</p>';
}

echo "<h2><a href='index.php/auth/login'>Try Login Again</a></h2>";
?>