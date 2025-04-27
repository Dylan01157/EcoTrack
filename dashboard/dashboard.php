<?php
require_once __DIR__ . '/../example_dbconnect.php';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
  die("La connexion a échoué : " . $conn->connect_error);
}

$sql = "
    SELECT c.nom_categorie, SUM(sh.score_total) as score_total
    FROM Score_Hebdomadaire sh
    JOIN Categorie c ON sh.id_categorie = c.id_categorie
    WHERE sh.id_utilisateur = 'U001'
    GROUP BY c.id_categorie
";

$result = $conn->query($sql);

// Stocker les résultats dans un tableau
$categories = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
  }
} else {
  $categories = [];
}



$conn->close();
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

<script src="script.js"></script>


<body>
  <header>
    <div class="logo"><img src="../images/logo.png" alt="Logo"></div>
    <div>Dashboard</div>
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
    <link rel="icon" href="/icon.png" type="image/png">
  </header>

  <nav class="sidebar" id="sidebar">
    <form class="search-form" action="/recherche" method="get">
      <input class="form-control" type="text" name="q" placeholder="Rechercher...">
    </form>

    <div class="buton">
      <a href="/EcoTrack/dashboard/dashboard.php" class="menu-item"><i class="bi bi-house-door me-2"></i> Dashboard</a>
      <a href="../questionnaire/questionnaire.html" class="menu-item"><i class="bi bi-ui-checks me-2"></i> Questionnaire</a>
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
  <main class="content">
    <div class="cards-container">
      <?php
      $cardIndex = 1;
      if (!empty($categories)) {
        foreach ($categories as $categorie) {
          echo '
            <div class="card" id="card' . $cardIndex . '" style="width: 18rem; margin: 10px;">
                <div class="card-body">
                    <h5 class="card-title">' . htmlspecialchars($categorie['nom_categorie']) . '</h5>
                    <p class="card-text">Score: ' . htmlspecialchars($categorie['score_total']) . '</p>
                </div>
            </div>';
          $cardIndex++;
        }
      } else {
        echo "Aucun score trouvé pour Pierre.";
      }
      ?>
    </div>
  </main>

  <script src="script.js"></script>

</body>

</html>