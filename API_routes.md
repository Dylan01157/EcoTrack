1. Authentification:
   - POST /connexion/connexion.php
   - POST /auth/logout : Déconnexion
   - GET /auth/user : Récupération profil utilisateur
   - PUT /auth/user : Mise à jour profil
   
2. Questionnaires:
   - GET /questionnaire/*/questions.json
   - POST /questionnaire/*/envoyer_reponses.php
   - GET /questionnaires/{id} : Détails d'un questionnaire
   - GET /questionnaires/{id}/questions : Questions d'un questionnaire
   - POST /questionnaires/{id}/reponses : Soumission des réponses
   
3. Calcul Scores:
   - Traitement dans categories/*/*.php
   - Mise à jour Score_Hebdomadaire
   - GET /scores/categories : Scores par catégorie
   