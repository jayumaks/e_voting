<?php
$host = 'localhost';
$db = 'aauekpo5_voting';
$user = 'aauekpo5_voting';
$pass = '=W4(Q=fedyjG';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>