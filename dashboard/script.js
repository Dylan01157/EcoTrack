function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
  
    sidebar.classList.toggle('active');
    overlay.classList.toggle('active');
  }
  
  
  // Animation au scroll
  const faders = document.querySelectorAll('[data-animate]');
  
  const appearOnScroll = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if(entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  }, {
    threshold: 0.2,
  });
  
  faders.forEach(fader => {
    appearOnScroll.observe(fader);
  });
  async function chargerClassement() {
    const response = await fetch('dashboard.php'); // <- Toujours ton fichier PHP qui retourne du JSON
    const utilisateurs = await response.json(); // Transforme en objet JS
  
    const leaderboardContainer = document.getElementById('leaderboard');
    leaderboardContainer.innerHTML = ''; // On vide d'abord
  
    utilisateurs.forEach(user => {
      const userElement = document.createElement('div');
      userElement.className = 'd-flex align-items-center list-group-item list-group-item-action mb-2';
      userElement.innerHTML = `
        <div class="d-flex justify-content-center align-items-center bg-secondary text-white rounded me-3 classement-rank">
          ${user.semaine_iso}
        </div>
        <div class="flex-grow-1">
          <p class="mb-0 fw-semibold">${user.prenom} ${user.nom}</p>
          <small class="text-muted">${user.nom_categorie}</small>
        </div>
        <div class="me-3 fw-bold">
          ${user.score_total} pts
        </div>
        <button class="btn btn-success btn-sm">Voir score</button>
      `;
      leaderboardContainer.appendChild(userElement);
    });
  }
  
  // Très important : lancer la fonction quand la page est prête
  document.addEventListener('DOMContentLoaded', chargerClassement);

// Ajout d'un effet de survol pour agrandir la carte
const cards = document.querySelectorAll('.card');

cards.forEach(card => {
  card.addEventListener('mouseenter', () => {
    card.style.transform = 'scale(1.05)';
    card.style.transition = 'transform 0.3s ease-in-out';
  });

  card.addEventListener('mouseleave', () => {
    card.style.transform = 'scale(1)';
  });
});
