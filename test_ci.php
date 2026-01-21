<?php
// Enable all error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load CodeIgniter
define('BASEPATH', dirname(__FILE__) . '/system/');
define('APPPATH', dirname(__FILE__) . '/application/');

// Try to initialize CodeIgniter
echo "Attempting to load CodeIgniter...<br>";

// Check if system directory exists
if (!file_exists(BASEPATH . 'core/CodeIgniter.php')) {
    echo "Error: CodeIgniter core not found at " . BASEPATH . "core/CodeIgniter.php<br>";
    exit;
}

echo "CodeIgniter system path: " . BASEPATH . "<br>";
echo "Application path: " . APPPATH . "<br>";

// Try to include CodeIgniter
include_once BASEPATH . 'core/CodeIgniter.php';

echo "CodeIgniter loaded successfully!<br>";
?>