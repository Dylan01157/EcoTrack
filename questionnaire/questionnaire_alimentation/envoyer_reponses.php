<?php
// Inclure la connexion à la base de données
require_once '../../example_dbconnect.php'; // <-- adapte bien ce chemin si besoin

// Activer l'affichage des erreurs PDO
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Récupérer les données envoyées
$data = json_decode(file_get_contents('php://input'), true);

if ($data && isset($data['id_utilisateur']) && isset($data['reponses']) && isset($data['score_total'])) {
    $id_utilisateur = $data['id_utilisateur'];
    $reponses = $data['reponses'];
    $score_total = $data['score_total'];

    foreach ($reponses as $index => $reponse) {
        $id_reponse = uniqid('R');
        $id_question = 'Q_ALIM_' . ($index + 1); // Exemple : Q_ALIM_1, Q_ALIM_2, etc.
        $texte_reponse = $reponse['reponseTexte'];
        $date_reponse = date('Y-m-d H:i:s');
        $en_cours = 0; // FALSE (questionnaire terminé)

        try {
            $stmt = $pdo->prepare("
                INSERT INTO Reponse (id_reponse, id_question, id_utilisateur, texte_reponse, date_reponse, en_cours)
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([$id_reponse, $id_question, $id_utilisateur, $texte_reponse, $date_reponse, $en_cours]);
        } catch (PDOException $e) {
            echo "❌ Erreur d'insertion à la question " . ($index + 1) . " : " . $e->getMessage();
            exit;
        }
    }

    echo "✅ Réponses enregistrées avec succès !";
} else {
    echo "❌ Données invalides reçues.";
}
