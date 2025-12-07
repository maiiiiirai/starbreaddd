<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "PHP Extensions Loaded:<br>";
echo "PDO: " . (extension_loaded('pdo') ? "✓ Yes" : "✗ No") . "<br>";
echo "PDO MySQL: " . (extension_loaded('pdo_mysql') ? "✓ Yes" : "✗ No") . "<br>";
echo "MySQLi: " . (extension_loaded('mysqli') ? "✓ Yes" : "✗ No") . "<br><br>";

echo "PDO Drivers:<br>";
$drivers = PDO::getAvailableDrivers();
foreach ($drivers as $driver) {
    echo "- $driver<br>";
}

echo "<br><br>Testing Database Connection:<br>";
$host = 'localhost';
$dbname = 'sweetbrid';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    echo "✓ Database connection successful!<br>";
    $pdo = null;
} catch (PDOException $e) {
    echo "✗ Database connection failed: " . $e->getMessage();
}
?>
