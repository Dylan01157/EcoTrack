<?php
// Connexion à ta base de données
$host = 'localhost';
$db   = 'ecotrackDB';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    // Récupérer les scores hebdo
    $stmt = $pdo->query("
        SELECT u.nom, u.prenom, c.nom_categorie, sh.semaine_iso, sh.score_total
        FROM Score_Hebdomadaire sh
        JOIN Utilisateur u ON sh.id_utilisateur = u.id_utilisateur
        JOIN Categorie c ON sh.id_categorie = c.id_categorie
        ORDER BY sh.semaine_iso DESC, sh.score_total DESC
    ");

    $scores = $stmt->fetchAll();

    // Générer du JSON
    header('Content-Type: application/json');
    echo json_encode($scores);

} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>