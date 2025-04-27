<?php
// Récupération des scores de consommation depuis la BDD
require_once '../../example_dbconnect.php';

// Initialisation des scores de consommation par défaut
$consommation_q1 = 0;
$consommation_q2 = 0;
$consommation_q3 = 0;
$consommation_q4 = 0;

// ID utilisateur (à remplacer par la session active si nécessaire)
$id_utilisateur = isset($_SESSION['id_utilisateur']) ? $_SESSION['id_utilisateur'] : 'U_TEST';

try {
    // Récupérer les dernières réponses de l'utilisateur
    $stmt = $pdo->prepare("
            SELECT r.id_question, r.texte_reponse, r.date_reponse 
            FROM Reponse r
            WHERE r.id_utilisateur = ? 
            AND r.id_question IN ('Q_NUM_1', 'Q_NUM_2', 'Q_NUM_3', 'Q_NUM_4')
            ORDER BY r.date_reponse DESC
            LIMIT 4
        ");
    $stmt->execute([$id_utilisateur]);
    $reponses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Calculer les consommations en fonction des réponses
    foreach ($reponses as $reponse) {
        $points = 0;

        // Déterminer les points en fonction de la réponse
        switch ($reponse['id_question']) {
            case 'Q_NUM_1':
                // Heures d'écran
                if ($reponse['texte_reponse'] == 'Moins de 2 heures') {
                    $points = 10;
                } elseif ($reponse['texte_reponse'] == 'Entre 2 et 4 heures') {
                    $points = 7;
                } elseif ($reponse['texte_reponse'] == 'Entre 4 et 6 heures') {
                    $points = 4;
                } elseif ($reponse['texte_reponse'] == 'Plus de 6 heures') {
                    $points = 1;
                }
                $consommation_q1 = (10 - $points) * 2.3;
                break;

            case 'Q_NUM_2':
                // Renouvellement appareils
                if ($reponse['texte_reponse'] == 'Tous les 5 ans ou plus') {
                    $points = 10;
                } elseif ($reponse['texte_reponse'] == 'Tous les 3-4 ans') {
                    $points = 7;
                } elseif ($reponse['texte_reponse'] == 'Tous les 2 ans') {
                    $points = 4;
                } elseif ($reponse['texte_reponse'] == 'Chaque année') {
                    $points = 1;
                }
                $consommation_q2 = (10 - $points) * 2.5;
                break;

            case 'Q_NUM_3':
                // Extinction appareils
                if ($reponse['texte_reponse'] == 'Oui, tous systématiquement') {
                    $points = 10;
                } elseif ($reponse['texte_reponse'] == 'Oui, la plupart') {
                    $points = 7;
                } elseif ($reponse['texte_reponse'] == 'Seulement quelques-uns') {
                    $points = 4;
                } elseif ($reponse['texte_reponse'] == 'Non, jamais') {
                    $points = 1;
                }
                $consommation_q3 = (10 - $points) * 1.7;
                break;

            case 'Q_NUM_4':
                // Stockage cloud
                if ($reponse['texte_reponse'] == 'Rarement ou jamais') {
                    $points = 10;
                } elseif ($reponse['texte_reponse'] == 'Occasionnellement') {
                    $points = 7;
                } elseif ($reponse['texte_reponse'] == 'Régulièrement') {
                    $points = 4;
                } elseif ($reponse['texte_reponse'] == 'Très fréquemment') {
                    $points = 1;
                }
                $consommation_q4 = (10 - $points) * 1.8;
                break;
        }
    }

    // Arrondir les scores
    $consommation_q1 = round($consommation_q1);
    $consommation_q2 = round($consommation_q2);
    $consommation_q3 = round($consommation_q3);
    $consommation_q4 = round($consommation_q4);
} catch (PDOException $e) {
    // En cas d'erreur, laisser les valeurs par défaut
    // On pourrait ajouter un message d'erreur ici si nécessaire
}
?>

<!DOCTYPE html>
<!-- Si besoin pour récupérer le header et la sidebar il suffit de prendre le code d'ici à...() -->
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Consommation Numérique</title>
    <link rel="stylesheet" href="styles.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

<body>
    <header>
        <div class="logo"><img src="../../images/logo.png" alt="Logo"></div>
        <div>Consommation Numérique</div>
        <div class="header-right">
            <div class="header-icons">
                <a href="" class="bi bi-bell"></a>
                <a href="" class="bi bi-gear-fill"></a>
                <a href="../../connexion/index.html" class="bi bi-person-circle"></a>
            </div>
            <div class="menu-toggle" onclick="toggleSidebar()">☰</div>
        </div>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <link rel="icon" href="/icon.png" type="image/png">
    </header>

    <nav class="sidebar" id="sidebar">
        <form class="search-form" action="/recherche" method="get">
            <input class="form-control" type="text" name="q" placeholder="Rechercher...">
        </form>

        <div class="buton">
            <a href="/EcoTrack/dashboard/dashboard.php" class="menu-item"><i class="bi bi-house-door me-2"></i> Dashboard</a>
            <a href="../../questionnaire/questionnaire.html" class="menu-item"><i class="bi bi-ui-checks me-2"></i> Questionnaire</a>
            <a href="../../classement/index.html" class="menu-item"><i class="bi bi-bar-chart-line me-2"></i> Classement</a>

            <div class="accordion" id="accordionSidebar">
                <div class="accordion-item bg-transparent border-0">
                    <div class="accordion-header">
                        <a href="#collapsePage2" class="menu-item" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapsePage2">
                            <i class="bi bi-folder me-2"></i> Catégories
                        </a>
                    </div>

                    <div id="collapsePage2" class="accordion-collapse collapse">
                        <div class="accordion-body p-0 ps-4">
                            <a class="dropdown-item menu-item" href="../../categories/categorie_alimentation/">Alimentation</a>
                            <a class="dropdown-item menu-item" href="../../categories/categorie_consommation_numérique/">Numérique</a>
                            <a class="dropdown-item menu-item" href="../../categories/categorie_deplacement/index.html">Déplacement</a>
                            <a class="dropdown-item menu-item" href="../../categories/categorie_voyage_loisir/">Voyage/Loisir</a>
                        </div>
                    </div>
                </div>
            </div>

            <a href="../../profil/index.html" class="menu-item"><i class="bi bi-person-circle me-2"></i> Profil</a>
        </div>
    </nav>

    <main class="content">
        <div class="categorie-container">
            <h2 class="categorie-title">Catégories Consommation Numérique</h2>

            <div class="categorie-layout">
                <div class="categorie-left">
                    <div class="categorie-item">
                        <h3>Temps d'écran</h3>
                        <div class="score-container">
                            <div class="score"><?php echo $consommation_q1; ?></div>
                            <p>unités de consommation</p>
                        </div>
                    </div>
                    <div class="categorie-item">
                        <h3>Renouvellement des appareils</h3>
                        <div class="score-container">
                            <div class="score"><?php echo $consommation_q2; ?></div>
                            <p>unités de consommation</p>
                        </div>
                    </div>
                    <div class="categorie-item">
                        <h3>Extinction des appareils</h3>
                        <div class="score-container">
                            <div class="score"><?php echo $consommation_q3; ?></div>
                            <p>unités de consommation</p>
                        </div>
                    </div>
                    <div class="categorie-item">
                        <h3>Utilisation du cloud</h3>
                        <div class="score-container">
                            <div class="score"><?php echo $consommation_q4; ?></div>
                            <p>unités de consommation</p>
                        </div>
                    </div>
                </div>

                <div class="categorie-right">
                    <div class="categorie-content">
                        <h3>Résumé de votre consommation numérique</h3>
                        <p>Total: <?php echo $consommation_q1 + $consommation_q2 + $consommation_q3 + $consommation_q4; ?> unités</p>
                        <p>Plus le score est bas, meilleure est votre empreinte écologique numérique.</p>
                    </div>
                </div>
            </div>
            <div class="categorie-graphique-block">
                <h3>Évolution de votre consommation</h3>
                <p>Votre graphique sera affiché ici.</p>
            </div>

            <div class="categorie-defi-block">
                <h3>Défi de la semaine</h3>
                <p>Réduisez votre temps d'écran de 30 minutes par jour cette semaine.</p>
            </div>
        </div>
    </main>
    <script src="script.js"></script>
</body>

</html>