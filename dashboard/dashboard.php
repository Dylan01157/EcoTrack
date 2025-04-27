<?php
// Connexion à la base de données
$host = 'localhost';
$user = 'ton_utilisateur';
$pass = 'ton_mot_de_passe';
$dbname = 'EcoTrack';  // Remplace par ton nom de base de données

$conn = new mysqli($host, $user, $pass, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Récupérer les scores hebdomadaires pour chaque utilisateur et chaque catégorie
$sql = "SELECT u.nom, u.prenom, c.nom_categorie, s.score_total 
        FROM Score_Hebdomadaire s
        JOIN Utilisateur u ON u.id_utilisateur = s.id_utilisateur
        JOIN Categorie c ON c.id_categorie = s.id_categorie";

$result = $conn->query($sql);

// Vérifier s'il y a des résultats
if ($result->num_rows > 0) {
    $data = [];

    // Parcourir les résultats
    while($row = $result->fetch_assoc()) {
        $data[] = [
            'nom_utilisateur' => $row['nom'] . ' ' . $row['prenom'],
            'categorie' => $row['nom_categorie'],
            'score' => $row['score_total']
        ];
    }

    // Convertir les données en JSON
    $jsonData = json_encode($data, JSON_PRETTY_PRINT);

    // Vérifier si la conversion en JSON a réussi
    if ($jsonData === false) {
        die("Erreur lors de la conversion en JSON : " . json_last_error_msg());
    }

    // Écrire le JSON dans le fichier index.json
    file_put_contents('index.json', $jsonData);
    echo "Données écrites dans index.json";
} else {
    echo "Aucun score trouvé";
}

// Fermer la connexion
$conn->close();
?>
