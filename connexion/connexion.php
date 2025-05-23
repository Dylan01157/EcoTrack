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
?>

<!DOCTYPE html>
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

<script src="login.js"></script>

<body>
    <header>
        <div class="logo"><img src="../images/logo.png" alt="Logo"></div>
        <div>Connexion</div>
        <div class="header-right">
            <div class="header-icons">
                <a href="" class="bi bi-bell"></a>
                <a href="" class="bi bi-gear-fill"></a>
                <a href="../connexion/connexion.php" class="bi bi-person-circle"></a>
            </div>
            <div class="menu-toggle" onclick="toggleSidebar()">☰</div>
        </div>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <link rel="icon" href="/logo.png" type="image/png">
    </header>

    <nav class="sidebar" id="sidebar">
        <form class="search-form" action="/recherche" method="get">
            <input class="form-control" type="text" name="q" placeholder="Rechercher...">
        </form>

        <div class="buton">
            <a href="/EcoTrack/dashboard/dashboard.php" class="menu-item"><i class="bi bi-house-door me-2"></i> Dashboard</a>
            <a href="../questionnaire/index.html" class="menu-item"><i class="bi bi-ui-checks me-2"></i> Questionnaire</a>
            <a href="../classement/index.html" class="menu-item"><i class="bi bi-bar-chart-line me-2"></i> Classement</a>

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

            <a href="../profil/index.html" class="menu-item"><i class="bi bi-person-circle me-2"></i> Profil</a>
        </div>
    </nav>
    <div class="score-card">
        <div class="score-content">
            <div class="score-text">Score dans une catégorie</div>
            <div class="score-icon">
                <i class="bi bi-box"></i> <!-- Exemple d'icône bootstrap -->
            </div>
        </div>
        <div class="score-footer"></div>
    </div>
    <main class="content">

        <!-- ici votre code perso   -->
        <div class="connexion-container">
            <div class="connexion-card">
                <div class="connexion-banner-block" style="background-image: url('../images/banner_profil_block.png');">
                    <div class="connexion-banner-content">
                        <div class="connexion-left">
                            <div class="connexion-photo">
                                <img src="../images/photo_de_profil_eco_track.png" alt="Photo de profil">
                            </div>
                            <div class="connexion-title">Connexion à EcoTrack</div>
                        </div>
                        <div class="connexion-right">
                        </div>
                    </div>
                </div>

                <div class="connexion-form-section">
                    <div class="connexion-form-block">
                        <form action="connexion.php" method="POST" id="connexion-form">
                            <div class="connexion-form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" placeholder="Votre email" required>
                            </div>

                            <div class="connexion-form-group">
                                <label for="password">Mot de passe</label>
                                <input type="password" id="password" name="password" placeholder="Votre mot de passe" required>
                            </div>

                            <div class="connexion-form-group">
                                <button type="submit" class="connexion-button">Se connecter</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="connexion-bottom-section">
                    <div class="connexion-options-block">
                        <a href="/forgot-password">Mot de passe oublié ?</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Popup modale (invisible par défaut) -->
        <div id="popup" class="popup">
            <div class="popup-content">
                <span class="popup-close" id="popup-close">&times;</span>
                <p id="popup-message"></p>
            </div>
        </div>


        <!-- Popup success message -->
        <div id="success-popup" class="popup" style="display: none;">
            <div class="popup-content">
                <p>Connexion réussie !</p>
                <button onclick="closePopup()">Fermer</button>
            </div>
        </div>



    </main>


</body>

</html>