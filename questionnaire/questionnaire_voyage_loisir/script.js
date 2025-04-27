function toggleSidebar() {
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  sidebar.classList.toggle('active');
  overlay.classList.toggle('active');
}


const faders = document.querySelectorAll('[data-animate]');
const appearOnScroll = new IntersectionObserver((entries, observer) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('visible');
      observer.unobserve(entry.target);
    }
  });
}, { threshold: 0.2 });
faders.forEach(fader => {
  appearOnScroll.observe(fader);
});




let questions = [];
let currentQuestionIndex = 0;
let userAnswers = [];


async function loadQuestions() {
  const response = await fetch('questions.json');
  questions = await response.json();
  showQuestion();
}


function showQuestion() {
  const question = questions[currentQuestionIndex];
  const questionTitle = document.querySelector('.question-block h2');
  questionTitle.textContent = question.question;

  const answerButtons = document.querySelectorAll('.answer-button');
  question.reponses.forEach((reponse, index) => {
    if (answerButtons[index]) {
      answerButtons[index].textContent = reponse.texte;
    }
  });
}


function handleAnswerClick(event) {
  const reponseChoisieText = event.target.textContent;
  const currentQuestion = questions[currentQuestionIndex];
  const selectedReponse = currentQuestion.reponses.find(r => r.texte === reponseChoisieText);

  userAnswers.push({
    question: currentQuestion.question,
    reponseTexte: selectedReponse.texte,
    points: selectedReponse.points
  });

  currentQuestionIndex++;

  if (currentQuestionIndex < questions.length) {
    showQuestion();
  } else {
    showEndMessage();
  }
}


function showEndMessage() {
  const container = document.querySelector('.questionnaire-container');

  const recapHtml = userAnswers.map(answer => `
    <li><strong>Question :</strong> ${answer.question}<br><strong>Réponse :</strong> ${answer.reponseTexte}</li>
  `).join('');

  const totalScore = userAnswers.reduce((acc, curr) => acc + curr.points, 0);
  
  // Calcul de la consommation en fonction des réponses
  let consommation = 0;
  
  userAnswers.forEach(answer => {
    // Calcul en fonction de la question et de la réponse
    // Plus le score est bas, plus la consommation est élevée
    const questionId = questions.find(q => q.question === answer.question).id;
    
    switch(questionId) {
      case "question_voyage_1": // Nombre de voyages
        consommation += (10 - answer.points) * 3.5; // Plus de voyages = plus de consommation
        break;
      case "question_voyage_2": // Moyen de transport
        consommation += (10 - answer.points) * 3.2; // Avion = plus de consommation
        break;
      case "question_voyage_3": // Type de destination
        consommation += (10 - answer.points) * 2.8; // Plus lointain = plus de consommation
        break;
      case "question_voyage_4": // Type d'hébergement
        consommation += (10 - answer.points) * 1.7; // Hôtel de luxe = plus de consommation
        break;
      case "question_voyage_5": // Souvenirs et shopping
        consommation += (10 - answer.points) * 1.4; // Plus d'achats = plus de consommation
        break;
      case "question_voyage_6": // Activités de loisirs
        consommation += (10 - answer.points) * 1.8; // Activités à forte empreinte = plus de consommation
        break;
      case "question_voyage_7": // Volonté de changement
        consommation += (10 - answer.points) * 1.0; // Moins de volonté = plus de consommation future
        break;
    }
  });
  
  // Normalisation de la consommation (valeur arrondie)
  consommation = Math.round(consommation);
  
  // Conversion du score en équivalent CO2 (approximatif)
  // Plus le score est élevé, moins il y a d'émission de CO2
  // On suppose qu'un score de 70 représente ~0 kg CO2 et un score de 0 représente ~1000 kg CO2
  const scoreCO2 = Math.round((70 - totalScore) * (1000 / 70));

  container.innerHTML = `
    <h2>Merci d'avoir complété le questionnaire ! 🎉</h2>
    <div class="recapitulatif">
      <h3>Voici vos réponses :</h3>
      <ul>${recapHtml}</ul>
    </div>
    <div class="score-final">
      <h3>Votre Score 🌱</h3>
      <p>${totalScore} / 70 points</p>
      <p>Votre empreinte carbone estimée : <strong>${scoreCO2} kg CO2</strong></p>
      <p>Votre consommation liée aux voyages et loisirs : <strong>${consommation} unités</strong></p>
      <p>Ne vous découragez pas, chaque geste compte ! 🌍</p>
    </div>
    <a href="/EcoTrack/dashboard/dashboard.php" class="btn btn-primary mt-3">Retour au Dashboard</a>
  `;


  envoyerReponsesEnBDD(totalScore, consommation);
}


function envoyerReponsesEnBDD(totalScore, consommation) {
  const dataToSend = {
    id_utilisateur: window.userId || 'U_TEST', // Utilise l'ID de l'utilisateur de la session ou U_TEST par défaut
    reponses: userAnswers,
    score_total: totalScore,
    consommation: consommation
  };

  fetch('envoyer_reponses.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(dataToSend)
  })
  .then(response => response.text())
  .then(data => {
    console.log('✅ Données envoyées avec succès:', data);
  })
  .catch(error => {
    console.error('❌ Erreur lors de l\'envoi des données:', error);
  });
}


document.addEventListener('DOMContentLoaded', () => {
  loadQuestions();
  const answerButtons = document.querySelectorAll('.answer-button');
  answerButtons.forEach(button => {
    button.addEventListener('click', handleAnswerClick);
  });
}); 