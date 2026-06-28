<?php

// Copy this file to config.php and add your local database settings

$host = "localhost";
$dbname = "ista";
$user = "your_username";
$password = "your_password";

try {
    $connexion = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $user,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("<p style='color:red;font-family:sans-serif'>Erreur de connexion : " . $e->getMessage() . "</p>");
}
?>
