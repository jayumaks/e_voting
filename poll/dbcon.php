<?php
$host = 'localhost';
$db = 'aauekpo5_poll';
$user = 'aauekpo5_polldb';
$pass = 'H,KkUno&H#jf8u$(';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>