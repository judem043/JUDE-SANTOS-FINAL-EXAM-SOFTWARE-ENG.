<?php 

$host = "localhost";
$user = "root";
$password = "";
$SANTOS = "SANTOS"; 
$dsn = "mysql:host={$host};dbname={$SANTOS}";

try {
    // Create a single PDO instance
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Set time zone (optional, comment out if unnecessary)
    $pdo->exec("SET time_zone = '+08:00';");
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

?>
