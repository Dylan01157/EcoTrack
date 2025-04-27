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
  
// === Ton ancien code sidebar / animation reste inchangé ===

// Variables globales
let questions = []; 
let currentQuestionIndex = 0;
let userAnswers = []; // <-- NOUVEAU : tableau pour stocker les réponses de l'utilisateur

// Fonction pour charger les questions depuis le JSON
async function loadQuestions() {
  const response = await fetch('questions.json');
  questions = await response.json();
  showQuestion();
}

// Fonction pour afficher une question
function showQuestion() {
  const question = questions[currentQuestionIndex];

  // Modifier la question
  const questionTitle = document.querySelector('.question-block h2');
  questionTitle.textContent = question.question;

  // Modifier les réponses
  const answerButtons = document.querySelectorAll('.answer-button');
  question.reponses.forEach((reponse, index) => {
    if (answerButtons[index]) {
      answerButtons[index].textContent = reponse.texte;
    }
  });
}

// Fonction pour gérer le clic sur une réponse
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

function afficherReponses() {
  const container = document.querySelector('.questionnaire-container');
  container.innerHTML = `
    <h2>Merci d'avoir complété le questionnaire ! 🎉</h2>
    <p>Voici un récapitulatif de vos réponses :</p>
  `;

  const listeReponses = document.createElement('ul');

  userAnswers.forEach((reponse, index) => {
    const item = document.createElement('li');
    item.textContent = `${index + 1}. ${reponse.question} ➔ ${reponse.reponse}`;
    listeReponses.appendChild(item);
  });

  container.appendChild(listeReponses);
}

// Fonction pour afficher un message de fin
function showEndMessage() {
  const container = document.querySelector('.questionnaire-container');
  
  const recapHtml = userAnswers.map(answer => `
    <li><strong>Question :</strong> ${answer.question}<br><strong>Réponse :</strong> ${answer.reponseTexte}</li>
  `).join('');

  const totalScore = userAnswers.reduce((acc, curr) => acc + curr.points, 0);

  container.innerHTML = `
    <h2>Merci d'avoir complété le questionnaire ! 🎉</h2>
    <div class="recapitulatif">
      <h3>Voici vos réponses :</h3>
      <ul>${recapHtml}</ul>
    </div>
    <div class="score-final">
      <h3>Votre Score 🌱</h3>
      <p>${totalScore} / 70 points</p>
      <p>Ne vous découragez pas, chaque geste compte ! 🌍</p>
    </div>
  `;
}

// Lancer l'initialisation au chargement de la page
document.addEventListener('DOMContentLoaded', () => {
  loadQuestions();

  // Ajouter un écouteur sur TOUS les boutons réponse
  const answerButtons = document.querySelectorAll('.answer-button');
  answerButtons.forEach(button => {
    button.addEventListener('click', handleAnswerClick);
  });
});

console.log("Réponses de l'utilisateur :", userAnswers);