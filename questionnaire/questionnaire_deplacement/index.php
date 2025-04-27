<?php
session_start();
// Si l'utilisateur n'est pas connecté, récupérer son ID depuis la session ou utiliser une valeur par défaut
$userId = isset($_SESSION['id_utilisateur']) ? $_SESSION['id_utilisateur'] : 'U_TEST';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questionnaire Déplacement - EcoTrack</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="icon" href="/icon.png" type="image/png">
</head>

<body>
    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

    <header>
        <div class="logo"><img src="../../images/logo.png" alt="Logo"></div>
        <div class="header-title">Questionnaire Déplacement</div>
        <div class="header-right">
            <div class="header-icons">
                <a href="" class="bi bi-bell"></a>
                <a href="" class="bi bi-gear-fill"></a>
                <a href="../../connexion/index.html" class="bi bi-person-circle"></a>
            </div>
            <div class="menu-toggle" onclick="toggleSidebar()">☰</div>
        </div>
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
        <div class="questionnaire-container" data-animate="fade-in">
            <div class="questionnaire-header">
                <h1>Évaluez votre impact en déplacement 🚗</h1>
                <p>Répondez aux questions ci-dessous pour mesurer votre empreinte écologique liée à vos déplacements.</p>
            </div>

            <div class="question-block">
                <h2>Chargement des questions...</h2>
                <div class="answer-options">
                    <button class="answer-button">Option 1</button>
                    <button class="answer-button">Option 2</button>
                    <button class="answer-button">Option 3</button>
                    <button class="answer-button">Option 4</button>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Transmet l'ID utilisateur au script JS
        window.userId = "<?php echo $userId; ?>";
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>

</html>