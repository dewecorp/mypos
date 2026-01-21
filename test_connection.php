<?php
// Enable all error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load CodeIgniter
define('BASEPATH', dirname(__FILE__) . '/system/');
define('APPPATH', dirname(__FILE__) . '/application/');
define('ENVIRONMENT', 'development');

// Load the CodeIgniter framework
require_once BASEPATH . 'core/CodeIgniter.php';
?>