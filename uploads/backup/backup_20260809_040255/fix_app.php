<?php
// Comprehensive fix for the MyPOS application
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Comprehensive MyPOS Application Fix</h1>";

// Check essential directories
$dirs = [
    'system' => './system/',
    'application' => './application/',
    'assets' => './assets/',
    'vendor' => './vendor/'
];

foreach ($dirs as $name => $path) {
    if (is_dir($path)) {
        echo "<p style='color: green;'>✓ $name directory exists</p>";
    } else {
        echo "<p style='color: red;'>✗ $name directory MISSING at $path</p>";
    }
}

// Check essential files
$files = [
    'CodeIgniter Core' => './system/core/CodeIgniter.php',
    'Auth Controller' => './application/controllers/Auth.php',
    'Login View' => './application/views/login.php',
    'Database Config' => './application/config/database.php',
    'Routes Config' => './application/config/routes.php',
    'Autoload Config' => './application/config/autoload.php',
    'Main Index' => './index.php'
];

foreach ($files as $name => $path) {
    if (file_exists($path)) {
        echo "<p style='color: green;'>✓ $name file exists</p>";
    } else {
        echo "<p style='color: red;'>✗ $name file MISSING at $path</p>";
    }
}

// Check and fix database configuration
echo "<h2>Checking Database Configuration</h2>";
if (file_exists('./application/config/database.php')) {
    $db_config_content = file_get_contents('./application/config/database.php');
    
    // Check if it contains the right database name
    if (strpos($db_config_content, "'database' => 'mypos'") !== false) {
        echo "<p style='color: green;'>✓ Database configuration is correct</p>";
    } else {
        echo "<p style='color: red;'>✗ Database configuration might be incorrect</p>";
        
        // Show current database name
        if (preg_match("/'database' => '([^']+)'/", $db_config_content, $matches)) {
            echo "<p>Current database name: {$matches[1]}</p>";
        }
    }
} else {
    echo "<p style='color: red;'>✗ Database configuration file not found</p>";
}

// Check and fix routes configuration
echo "<h2>Checking Routes Configuration</h2>";
if (file_exists('./application/config/routes.php')) {
    $routes_content = file_get_contents('./application/config/routes.php');
    
    if (strpos($routes_content, "'default_controller' = 'auth'") !== false || 
        strpos($routes_content, "'default_controller' => 'auth'") !== false) {
        echo "<p style='color: green;'>✓ Default controller is set to auth</p>";
    } else {
        echo "<p style='color: orange;'>? Default controller might not be set to auth</p>";
        
        // Try to update the default controller
        $routes_content = preg_replace(
            "/('default_controller'\s*=>\s*')[^']+/",
            "$1auth",
            $routes_content
        );
        
        if (strpos($routes_content, "'default_controller' => 'auth'") === false) {
            // If it doesn't exist, add it
            $routes_content = str_replace(
                '$route[\'translate_uri_dashes\'] = FALSE;',
                '$route[\'translate_uri_dashes\'] = FALSE;' . "\n" . '$route[\'default_controller\'] = \'auth\';',
                $routes_content
            );
        }
        
        file_put_contents('./application/config/routes.php', $routes_content);
        echo "<p style='color: blue;'>✓ Updated routes.php to set default controller to auth</p>";
    }
} else {
    echo "<p style='color: red;'>✗ Routes configuration file not found</p>";
}

// Check and fix autoload configuration
echo "<h2>Checking Autoload Configuration</h2>";
if (file_exists('./application/config/autoload.php')) {
    $autoload_content = file_get_contents('./application/config/autoload.php');
    
    if (strpos($autoload_content, '"template", "database", "session", "fungsi"') !== false ||
        strpos($autoload_content, '\'template\', \'database\', \'session\', \'fungsi\'') !== false) {
        echo "<p style='color: green;'>✓ Essential libraries are autoloaded</p>";
    } else {
        echo "<p style='color: orange;'>? Essential libraries might not be autoloaded</p>";
    }
} else {
    echo "<p style='color: red;'>✗ Autoload configuration file not found</p>";
}

// Check for Composer dependencies
echo "<h2>Checking Composer Dependencies</h2>";
if (file_exists('./vendor/autoload.php')) {
    require_once './vendor/autoload.php';
    echo "<p style='color: green;'>✓ Composer autoloader loaded</p>";
    
    if (class_exists('Dompdf\Dompdf')) {
        echo "<p style='color: green;'>✓ Dompdf library is available</p>";
    } else {
        echo "<p style='color: orange;'>? Dompdf library is NOT available</p>";
    }
    
    if (class_exists('Endroid\QrCode\QrCode')) {
        echo "<p style='color: green;'>✓ QR Code library is available</p>";
    } else {
        echo "<p style='color: orange;'>? QR Code library is NOT available</p>";
    }
} else {
    echo "<p style='color: red;'>✗ Composer autoloader not found</p>";
}

// Summary and next steps
echo "<h2>Summary and Next Steps</h2>";
echo "<ul>";
echo "<li>If database configuration is incorrect, please verify your database server is running</li>";
echo "<li>If directories or files are missing, restore them from your backup</li>";
echo "<li>Try running: composer install (if you have composer)</li>";
echo "<li>Make sure your database 'mypos' exists and tables are imported</li>";
echo "</ul>";

echo "<h3><a href='index.php/auth/login'>Try accessing login page</a></h3>";
echo "<h3><a href='setup_db.php'>Run database setup again</a></h3>";
?>