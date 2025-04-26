

-- Script de création de la base de données pour l'application EcoTrack
-- Ce script crée les tables nécessaires pour stocker les informations sur les utilisateurs, les entreprises, les badges, les empreintes carbone, etc.

CREATE TABLE Entreprise (
    id_entreprise VARCHAR(50) PRIMARY KEY,
    nom_entreprise VARCHAR(100) NOT NULL,
    secteur_activite VARCHAR(100) NOT NULL,
    taille VARCHAR(50)
); 

CREATE TABLE Utilisateur (
    id_utilisateur VARCHAR(50) PRIMARY KEY,
    id_entreprise VARCHAR(50),
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    mail VARCHAR(150) NOT NULL,
    FOREIGN KEY(id_entreprise) REFERENCES Entreprise(id_entreprise)
); 

CREATE TABLE Badge (
    id_badge VARCHAR(50) PRIMARY KEY,
    nom_badge VARCHAR(50) NOT NULL,
    description VARCHAR(250)
); 

CREATE TABLE Badge_Utilisateur (
    id_badge_utilisateur VARCHAR(50) PRIMARY KEY,
    id_utilisateur VARCHAR(50),
    id_badge VARCHAR(50),
    date_obtention DATETIME NOT NULL,
    FOREIGN KEY(id_utilisateur) REFERENCES Utilisateur(id_utilisateur),
    FOREIGN KEY(id_badge) REFERENCES Badge(id_badge)
); 

CREATE TABLE Empreinte_Carbone (
    id_empreinte VARCHAR(50) PRIMARY KEY,
    id_utilisateur VARCHAR(50),
    valeur_carbone DECIMAL(15,2) NOT NULL,
    date_empreinte   DATETIME NOT NULL,
    FOREIGN KEY(id_utilisateur) REFERENCES Utilisateur(id_utilisateur)
); 

CREATE TABLE Calculer (
    id_calcul VARCHAR(50) PRIMARY KEY,
    id_utilisateur VARCHAR(50),
    id_empreinte VARCHAR(50),
    FOREIGN KEY(id_utilisateur) REFERENCES Utilisateur(id_utilisateur),
    FOREIGN KEY(id_empreinte) REFERENCES Empreinte_Carbone(id_empreinte)
); 

CREATE TABLE Classement (
    id_classement VARCHAR(50) PRIMARY KEY,
    id_utilisateur VARCHAR(50),
    id_entreprise VARCHAR(50),
    rang INT NOT NULL,
    score INT,
    date_classement DATETIME NOT NULL,
    FOREIGN KEY(id_utilisateur) REFERENCES Utilisateur(id_utilisateur),
    FOREIGN KEY(id_entreprise) REFERENCES Entreprise(id_entreprise)
); 

CREATE TABLE Categorie (
    id_categorie VARCHAR(50) PRIMARY KEY,
    nom_categorie VARCHAR(50) NOT NULL,
    description_categorie VARCHAR(250),
    score_categorie DOUBLE NOT NULL
); 

CREATE TABLE Questionnaire (
    id_questionnaire VARCHAR(50) PRIMARY KEY,
    nom_questionnaire VARCHAR(100) NOT NULL,
    date_debut DATETIME,
    date_fin DATETIME
); 

CREATE TABLE Question (
    id_question VARCHAR(50) PRIMARY KEY,
    id_questionnaire VARCHAR(50),
    id_categorie VARCHAR(50),
    texte_question VARCHAR(250) NOT NULL,
    type_question VARCHAR(50) NOT NULL,
    frequence VARCHAR(50),
    score_question DOUBLE NOT NULL,
    FOREIGN KEY(id_questionnaire) REFERENCES Questionnaire(id_questionnaire),
    FOREIGN KEY(id_categorie) REFERENCES Categorie(id_categorie)
); 


/*-- Table pour les réponses correctes aux questions --*/
-- Cette table enregistre les réponses correctes pour chaque question   
-- Je l'ai créée pour faciliter la gestion des réponses correctes et éviter de les stocker dans la table Question, elle est modifiable si bhesoin
-- On peut aussi envisager de stocker les réponses correctes directement dans la table Question, mais cela pourrait rendre la gestion des réponses plus complexe
CREATE TABLE Bonne_Reponse (
    id_bonne_reponse INT AUTO_INCREMENT PRIMARY KEY,
    id_question VARCHAR(50) NOT NULL,
    texte_bonne_reponse VARCHAR(250) NOT NULL,
    FOREIGN KEY(id_question) REFERENCES Question(id_question)
);





CREATE TABLE Reponse (
    id_reponse VARCHAR(50) PRIMARY KEY,
    id_question VARCHAR(50),
    id_utilisateur VARCHAR(50),
    texte_reponse VARCHAR(250),
    date_reponse DATETIME NOT NULL,
    en_cours BOOLEAN,
    FOREIGN KEY(id_question) REFERENCES Question(id_question),
    FOREIGN KEY(id_utilisateur) REFERENCES Utilisateur(id_utilisateur)
);

CREATE TABLE Defi (
    id_defi VARCHAR(50) PRIMARY KEY,
    nom_defi VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    statut VARCHAR(50) NOT NULL,
    date_debut DATETIME NOT NULL,
    date_fin DATETIME NOT NULL
); 

CREATE TABLE Utilisateur_Defi (
    id_utilisateur_defi VARCHAR(50) PRIMARY KEY,
    id_utilisateur VARCHAR(50),
    id_defi VARCHAR(50),
    en_cours BOOLEAN,
    score_defi DOUBLE,
    FOREIGN KEY(id_utilisateur) REFERENCES Utilisateur(id_utilisateur),
    FOREIGN KEY(id_defi) REFERENCES Defi(id_defi)
);

CREATE TABLE Remplir (
    id_remplir VARCHAR(50) PRIMARY KEY,
    id_utilisateur VARCHAR(50),
    id_questionnaire VARCHAR(50),
    FOREIGN KEY(id_utilisateur) REFERENCES Utilisateur(id_utilisateur),
    FOREIGN KEY(id_questionnaire) REFERENCES Questionnaire(id_questionnaire)
);
 
/*-- Table pour le suivi quotidien des utilisateurs concernant les questionnaires --*/
-- Cette table enregistre l'état de chaque questionnaire pour chaque utilisateur à une date donnée  

CREATE TABLE Suivi_Quotidien (
    id_suivi INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur VARCHAR(50),
    id_questionnaire VARCHAR(50),
    date_jour DATE NOT NULL,
    statut ENUM('futur', 'en_attente', 'valide', 'rate') NOT NULL,
    FOREIGN KEY(id_utilisateur) REFERENCES Utilisateur(id_utilisateur),
    FOREIGN KEY(id_questionnaire) REFERENCES Questionnaire(id_questionnaire)
); 

/*-- Table pour le suivi hebdomadaire des utilisateurs concernant les questionnaires --*/
-- Cette table enregistre le score total de chaque utilisateur pour chaque catégorie à la fin de chaque semaine
-- Le score est calculé à partir des réponses aux questionnaires remplis par l'utilisateur durant la semaine


CREATE TABLE Score_Hebdomadaire (
    id_score INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur VARCHAR(50),
    id_categorie VARCHAR(50),
    semaine_iso VARCHAR(10),
    score_total INT DEFAULT 0,
    FOREIGN KEY(id_utilisateur) REFERENCES Utilisateur(id_utilisateur),
    FOREIGN KEY(id_categorie) REFERENCES Categorie(id_categorie)
);

 
/* Script d'insertion de données pour la base de données EcoTrack
-- Ce script insère des données d'exemple dans les tables créées ci-dessus pour tester l'application EcoTrack
 
 
 
 