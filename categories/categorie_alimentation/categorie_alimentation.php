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
            AND r.id_question IN ('Q_ALIM_1', 'Q_ALIM_2', 'Q_ALIM_3', 'Q_ALIM_4')
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
            case 'Q_ALIM_1':
                // Viande ou poisson
                if ($reponse['texte_reponse'] == 'Non') {
                    $points = 10;
                } elseif ($reponse['texte_reponse'] == 'Oui, en petite quantité') {
                    $points = 7;
                } elseif ($reponse['texte_reponse'] == 'Oui, en quantité moyenne') {
                    $points = 4;
                } elseif ($reponse['texte_reponse'] == 'Oui, en grande quantité') {
                    $points = 1;
                }
                $consommation_q1 = (10 - $points) * 2;
                break;

            case 'Q_ALIM_2':
                // Produits locaux
                if ($reponse['texte_reponse'] == 'Oui, uniquement local') {
                    $points = 10;
                } elseif ($reponse['texte_reponse'] == 'Oui, en majorité local') {
                    $points = 7;
                } elseif ($reponse['texte_reponse'] == 'Un peu, sans faire attention') {
                    $points = 4;
                } elseif ($reponse['texte_reponse'] == 'Pas du tout') {
                    $points = 1;
                }
                $consommation_q2 = (10 - $points) * 1.5;
                break;

            case 'Q_ALIM_3':
                // Produits frais
                if ($reponse['texte_reponse'] == 'Oui, 100% frais') {
                    $points = 10;
                } elseif ($reponse['texte_reponse'] == 'Majoritairement frais') {
                    $points = 7;
                } elseif ($reponse['texte_reponse'] == 'Un peu de frais, beaucoup de préparé') {
                    $points = 4;
                } elseif ($reponse['texte_reponse'] == 'Uniquement des plats préparés') {
                    $points = 1;
                }
                $consommation_q3 = (10 - $points) * 1.2;
                break;

            case 'Q_ALIM_4':
                // Gaspillage
                if ($reponse['texte_reponse'] == 'Pas du tout') {
                    $points = 10;
                } elseif ($reponse['texte_reponse'] == 'Un peu') {
                    $points = 7;
                } elseif ($reponse['texte_reponse'] == 'Beaucoup') {
                    $points = 4;
                } elseif ($reponse['texte_reponse'] == 'Énormément') {
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
    <title>Ma Page d'acceuil</title>
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
        <div>Alimentation</div>
        <div class="header-right">
            <div class="header-icons">
                <a href="" class="bi bi-bell"></a>
                <a href="" class="bi bi-gear-fill"></a>
                <a href="../connexion/index.html" class="bi bi-person-circle"></a>
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
                            <a class="dropdown-item menu-item" href="../categories/categorie_alimentation/">alimentation</a>
                            <a class="dropdown-item menu-item" href="../categories/categorie_consommation_numérique/">numérique</a>
                            <a class="dropdown-item menu-item" href="../categories/categorie_deplacement/index.html">déplacement</a>
                            <a class="dropdown-item menu-item" href="../categories/categorie_voyage_loisir/">voyage/loisir</a>
                            <a class="dropdown-item menu-item" href="#">Sous-page</a>
                            <a class="dropdown-item menu-item" href="#">Sous-page</a>
                        </div>
                    </div>
                </div>
            </div>

            <a href="../../profil/index.html" class="menu-item"><i class="bi bi-person-circle me-2"></i> Profil</a>
        </div>
    </nav>



    <html lang="fr">
    <main class="content">

        <!-- ici votre code perso   -->
        <div class="categorie-container">
            <!-- Ici tu vas ajouter tous tes futurs blocs catégorie -->
            <h2 class="categorie-title">Catégories nourriture</h2>

            <div class="categorie-layout">
                <div class="categorie-left">
                    <div class="categorie-item">
                        <h3>Consommation de viande/poisson</h3>
                        <div class="score-container">
                            <div class="score"><?php echo $consommation_q1; ?></div>
                            <p>unités de consommation</p>
                        </div>
                    </div>
                    <div class="categorie-item">
                        <h3>Produits locaux et de saison</h3>
                        <div class="score-container">
                            <div class="score"><?php echo $consommation_q2; ?></div>
                            <p>unités de consommation</p>
                        </div>
                    </div>
                    <div class="categorie-item">
                        <h3>Cuisine produits frais</h3>
                        <div class="score-container">
                            <div class="score"><?php echo $consommation_q3; ?></div>
                            <p>unités de consommation</p>
                        </div>
                    </div>
                    <div class="categorie-item">
                        <h3>Gaspillage alimentaire</h3>
                        <div class="score-container">
                            <div class="score"><?php echo $consommation_q4; ?></div>
                            <p>unités de consommation</p>
                        </div>
                    </div>
                </div>

                <div class="categorie-right">
                    <div class="categorie-content">
                        <!-- Ici tu mettras ton image ou autre contenu -->
                    </div>
                </div>
            </div>
            <div class="categorie-graphique-block">
                <!-- Ici ton graphique ou autre contenu -->
            </div>

            <div class="categorie-defi-block">
                <!-- Ici ton défi ou autre contenu -->
            </div>
        </div>

    </main>
    <script src="script.js"></script>
</body>

</html>