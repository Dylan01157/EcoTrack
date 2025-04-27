<?php
// Connexion à la base de données
$host = "localhost";
$dbname = "ecotrackDB"; // Nom de la base de données
$username = "root";
$password = ""; // Mot de passe de la base de données

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
?>
