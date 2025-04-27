document.getElementById('connexion-form').addEventListener('submit', function(event) {
  event.preventDefault(); // Empêche la soumission du formulaire et évite le rechargement de la page

  // Récupérer les données du formulaire
  const email = document.getElementById('email').value;
  const password = document.getElementById('password').value;

  // Vérification avec le fichier JSON
  fetch('user_data.json')
      .then(response => response.json())
      .then(data => {
          // Trouver l'utilisateur correspondant à l'email
          const user = data.find(u => u.mail === email);

          if (user && user.mot_de_passe === password) {
              // Si les identifiants sont corrects, afficher le popup
              const popup = document.getElementById('popup');
              const popupMessage = document.getElementById('popup-message');
              popupMessage.textContent = 'Connexion réussie ! Bienvenue ' + user.prenom + ' ' + user.nom;
              popup.style.display = 'flex'; // Afficher le popup
          } else {
              // Si les identifiants sont incorrects, afficher un message d'erreur
              alert('Email ou mot de passe incorrect');
          }
      })
      .catch(error => {
          console.error('Erreur de récupération du fichier JSON :', error);
      });
});

// Fermer le popup lorsque l'utilisateur clique sur "X"
document.getElementById('popup-close').addEventListener('click', function() {
  document.getElementById('popup').style.display = 'none';
});


