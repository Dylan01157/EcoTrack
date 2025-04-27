<?php
require_once __DIR__ . '/../example_dbconnect.php';

try {
    $pdo = new PDO("mysql:host=localhost;dbname=ecotrackdb", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête pour récupérer tous les utilisateurs (en supposant qu'il y en a plusieurs)
    $stmt = $pdo->prepare("SELECT * FROM Utilisateur");
    $stmt->execute();

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Convertir les données des utilisateurs en JSON
    $json_data = json_encode($users, JSON_PRETTY_PRINT);

    // Enregistrer le JSON dans un fichier
    file_put_contents('user_data.json', $json_data);

    echo "Les données des utilisateurs ont été enregistrées dans le fichier JSON.";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
