<?php
$host = "localhost";
$dbname = "ecotrackDB";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Connexion réussie à la base de données ecotrackDB !"; // AJOUTE ÇA pour voir si ça marche
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
