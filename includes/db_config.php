<?php
$hostname = 'localhost';         // Replace with your DB host
$dbname   = 'ticket_booking';    // Replace with your DB name
$username = 'root';              // Replace with your DB username
$password = '';                  // Replace with your DB password
$charset = 'utf8mb4';

$dsn = "mysql:host=$hostname;dbname=$dbname;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,  // Enable exceptions
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,        // Fetch as associative array
    PDO::ATTR_EMULATE_PREPARES   => false,                   // Using real prepared statements
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (\PDOException $e) {
    die('Database Connection Failed: ' . $e->getMessage());
}
?>
