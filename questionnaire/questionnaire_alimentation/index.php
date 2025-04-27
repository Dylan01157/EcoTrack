<!DOCTYPE html>
<?php
session_start();
$id_utilisateur = isset($_SESSION['id_utilisateur']) ? $_SESSION['id_utilisateur'] : 'U_TEST';
?>
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
  <script>
    // Variable globale pour l'ID utilisateur
    var userId = "<?php echo $id_utilisateur; ?>";
  </script>
</head>
<div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

<body>
  <header>
    <div class="logo"><img src="/images/logo.png" alt="Logo"></div>
    <div>questionnaire</div>
    <div class="header-right">
        <div class="header-icons">
          <a href="" class="bi bi-bell"></a>
          <a href="" class="bi bi-gear-fill"></a>
          <a href="/connexion/index.html" class="bi bi-person-circle"></a>
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
      <a href="/dashboard/dashboard.html" class="menu-item"><i class="bi bi-house-door me-2"></i> Dashboard</a>
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
  
      <a href="/profil/index.html" class="menu-item"><i class="bi bi-person-circle me-2"></i> Profil</a>
  </div>
  </nav>

 
<html lang="fr">
    <main class="content">
        <div class="container"> <!-- AJOUTE cette ligne -->
          <div class="questionnaire-container">
            
            <!-- Bloc question -->
            <div class="question-block">
              <h2>Quel est votre mode de transport principal pour venir au travail ?</h2>
            </div>
      
            <!-- Bloc réponses + image -->
            <div class="answer-image-container">
      
              <!-- Colonne gauche : les 4 réponses -->
              <div class="answers-block">
                <button class="answer-button">A pied ! 🏃‍♂️</button>
                <button class="answer-button">A vélo ! 🚲</button>
                <button class="answer-button">En transport en commun ! 🚆</button>
                <button class="answer-button">En voiture... 🚗</button>
              </div>
      
              <!-- Colonne droite : l'image -->
              <div class="image-block">
                <img src="/images/foret.jpg" alt="Image illustrant la question">
              </div>
      
            </div>
            <div class="navigation-buttons">
              <button id="precedent-Btn" class="btn btn-secondary">Précédent</button>
              <button id="suivant-Btn" class="btn btn-primary">Suivant</button>
            </div>
      
          </div> <!-- FIN DU DIV container ajouté -->
        </div>
      </main>
<script src="script.js"></script>
</body>
</html>
    
    