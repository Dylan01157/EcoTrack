<?php
// 1. Connexion à ta base de données
$host = 'localhost'; 
$dbname = 'ecotrackDB'; 
$username = 'root'; 
$password = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Pour avoir les erreurs PDO propres
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// 2. Récupérer le score de chaque catégorie pour Pierre
$sql = "
    SELECT c.nom_categorie, sh.score_total
    FROM Score_Hebdomadaire sh
    JOIN Categorie c ON sh.id_categorie = c.id_categorie
    WHERE sh.id_utilisateur = 'U001'
";

$stmt = $pdo->query($sql);
$scores = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 3. Encoder les résultats en JSON
$jsonData = json_encode($scores, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

// 4. Écrire dans index.json
file_put_contents('index.json', $jsonData);

// 5. Fin
echo "Fichier index.json généré avec succès !";
?>
