<?php
    $host = 'localhost';
    $dbname = 'sweetbrid_db';
    $username = 'root';
    $password = '';

    try {
        // Try PDO first
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        // If PDO MySQL driver is not available, provide helpful error message
        if (strpos($e->getMessage(), 'could not find driver') !== false) {
            die("Error: PDO MySQL driver not found. Please enable 'pdo_mysql' extension in php.ini or contact your server administrator.");
        }
        die("Database connection failed: " . $e->getMessage());
    }