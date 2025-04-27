<?php

require_once '../../example_dbconnect.php';


$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$data = json_decode(file_get_contents('php://input'), true);

if ($data && isset($data['id_utilisateur']) && isset($data['reponses']) && isset($data['score_total']) && isset($data['consommation'])) {
    $id_utilisateur = $data['id_utilisateur'];
    $reponses = $data['reponses'];
    $score_total = $data['score_total'];
    $consommation = $data['consommation'];

    foreach ($reponses as $index => $reponse) {
        $id_reponse = uniqid('R');
        $id_question = 'Q_DEPL_' . ($index + 1);
        $texte_reponse = $reponse['reponseTexte'];
        $date_reponse = date('Y-m-d H:i:s');
        $en_cours = 0;

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

    // Enregistrer la consommation dans une table dédiée si nécessaire
    try {
        $stmt = $pdo->prepare("
            INSERT INTO Consommation (id_utilisateur, categorie, valeur, date_enregistrement)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([$id_utilisateur, 'deplacement', $consommation, date('Y-m-d H:i:s')]);
    } catch (PDOException $e) {
        // Si la table n'existe pas encore, on ignore l'erreur mais on avertit
        echo "✅ Réponses enregistrées avec succès ! (Note: consommation non enregistrée - " . $e->getMessage() . ")";
        exit;
    }

    echo "✅ Réponses et consommation enregistrées avec succès !";
} else {
    echo "❌ Données invalides reçues.";
}
