# Flux du Module Questionnaire

## 1. Affichage des Questions
- **Front :** `questionnaire/*.php`
- **Requête :** `GET questions.json`
- **Traitement :** Affichage dynamique via `script.js`

## 2. Soumission des Réponses
- **Front :** `script.js`
- **Requête :** `POST /questionnaire/*/envoyer_reponses.php`
- **Base de données :** Tables `Question`, `Reponse`
- **Réponse :** Statut en JSON
- **Résultat :** Affichage du score
