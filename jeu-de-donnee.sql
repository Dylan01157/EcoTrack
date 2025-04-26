-- Insertion de données dans la table Entreprise
INSERT INTO Entreprise (id_entreprise, nom_entreprise, secteur_activite, taille) VALUES
('E001', 'EcoSolutions', 'Énergie', 'Grande'),
('E002', 'GreenTech', 'Technologies écologiques', 'Moyenne'),
('E003', 'BioCorp', 'Industrie bio', 'Petite');

-- Insertion de données dans la table Utilisateur
INSERT INTO Utilisateur (id_utilisateur, id_entreprise, nom, prenom, mail) VALUES
('U001', 'E001', 'Durand', 'Pierre', 'pierre.durand@ecosolutions.com'),
('U002', 'E002', 'Lemoine', 'Sophie', 'sophie.lemoine@greentech.com'),
('U003', 'E003', 'Meyer', 'Julien', 'julien.meyer@biocorp.com');

-- Insertion de données dans la table Badge
INSERT INTO Badge (id_badge, nom_badge, description) VALUES
('B001', 'Éco Champion', 'Atteindre un score de 1000 points dans la catégorie énergie'),
('B002', 'Green Innovator', 'Mettre en œuvre une solution écologique innovante'),
('B003', 'Zero Waste', 'Réduire les déchets au minimum');

-- Insertion de données dans la table Badge_Utilisateur
INSERT INTO Badge_Utilisateur (id_badge_utilisateur, id_utilisateur, id_badge, date_obtention) VALUES
('BU001', 'U001', 'B001', '2025-04-01 10:00:00'),
('BU002', 'U002', 'B002', '2025-04-05 14:00:00'),
('BU003', 'U003', 'B003', '2025-04-10 09:30:00');

-- Insertion de données dans la table Empreinte_Carbone
INSERT INTO Empreinte_Carbone (id_empreinte, id_utilisateur, valeur_carbone, date_empreinte) VALUES
('EC001', 'U001', 45.67, '2025-04-01 12:00:00'),
('EC002', 'U002', 30.12, '2025-04-03 13:30:00'),
('EC003', 'U003', 23.45, '2025-04-05 14:00:00');

-- Insertion de données dans la table Calculer
INSERT INTO Calculer (id_calcul, id_utilisateur, id_empreinte) VALUES
('C001', 'U001', 'EC001'),
('C002', 'U002', 'EC002'),
('C003', 'U003', 'EC003');

-- Insertion de données dans la table Classement
INSERT INTO Classement (id_classement, id_utilisateur, id_entreprise, rang, score, date_classement) VALUES
('CL001', 'U001', 'E001', 1, 500, '2025-04-01 10:00:00'),
('CL002', 'U002', 'E002', 2, 450, '2025-04-01 11:00:00'),
('CL003', 'U003', 'E003', 3, 300, '2025-04-01 12:00:00');

-- Insertion de données dans la table Categorie
INSERT INTO Categorie (id_categorie, nom_categorie, description_categorie, score_categorie) VALUES
('C001', 'Énergie', 'Catégorie liée à la consommation d’énergie et aux réductions', 100.0),
('C002', 'Recyclage', 'Catégorie liée à la gestion des déchets et au recyclage', 50.0),
('C003', 'Transport', 'Catégorie liée à l’impact écologique des moyens de transport', 75.0);

-- Insertion de données dans la table Questionnaire
INSERT INTO Questionnaire (id_questionnaire, nom_questionnaire, date_debut, date_fin) VALUES
('Q001', 'Questionnaire Énergie', '2025-04-01 00:00:00', '2025-04-07 23:59:59'),
('Q002', 'Questionnaire Recyclage', '2025-04-08 00:00:00', '2025-04-14 23:59:59');

-- Insertion de données dans la table Question
INSERT INTO Question (id_question, id_questionnaire, id_categorie, texte_question, type_question, frequence, score_question) VALUES
('Q001_1', 'Q001', 'C001', 'Avez-vous réduit votre consommation d’énergie ce mois-ci?', 'Oui/Non', 'Mensuelle', 10.0),
('Q001_2', 'Q001', 'C001', 'Utilisez-vous des sources d’énergie renouvelables?', 'Oui/Non', 'Mensuelle', 15.0),
('Q002_1', 'Q002', 'C002', 'Triez-vous vos déchets?', 'Oui/Non', 'Mensuelle', 5.0);

-- Insertion de données dans la table Bonne_Reponse
INSERT INTO Bonne_Reponse (id_bonne_reponse, id_question, texte_bonne_reponse) VALUES
(1, 'Q001_1', 'Oui'),
(2, 'Q001_2', 'Oui'),
(3, 'Q002_1', 'Oui');

-- Insertion de données dans la table Reponse
INSERT INTO Reponse (id_reponse, id_question, id_utilisateur, texte_reponse, date_reponse, en_cours) VALUES
('R001', 'Q001_1', 'U001', 'Oui', '2025-04-01 12:00:00', TRUE),
('R002', 'Q001_2', 'U001', 'Oui', '2025-04-01 12:10:00', TRUE),
('R003', 'Q002_1', 'U001', 'Oui', '2025-04-01 12:15:00', FALSE);

-- Insertion de données dans la table Defi
INSERT INTO Defi (id_defi, nom_defi, description, statut, date_debut, date_fin) VALUES
('D001', 'Défi Énergie', 'Réduire la consommation d’énergie de 10% en 30 jours', 'Actif', '2025-04-01 00:00:00', '2025-04-30 23:59:59'),
('D002', 'Défi Recyclage', 'Augmenter le taux de recyclage de 20% en 30 jours', 'Actif', '2025-04-01 00:00:00', '2025-04-30 23:59:59');

-- Insertion de données dans la table Utilisateur_Defi
INSERT INTO Utilisateur_Defi (id_utilisateur_defi, id_utilisateur, id_defi, en_cours, score_defi) VALUES
('UD001', 'U001', 'D001', TRUE, 50.0),
('UD002', 'U002', 'D002', TRUE, 30.0);

-- Insertion de données dans la table Suivi_Quotidien
INSERT INTO Suivi_Quotidien (id_suivi, id_utilisateur, id_questionnaire, date_jour, statut) VALUES
(1, 'U001', 'Q001', '2025-04-01', 'valide'),
(2, 'U002', 'Q002', '2025-04-02', 'en_attente');

-- Insertion de données dans la table Score_Hebdomadaire
INSERT INTO Score_Hebdomadaire (id_score, id_utilisateur, id_categorie, semaine_iso, score_total) VALUES
(1, 'U001', 'C001', '2025-W13', 100),
(2, 'U002', 'C002', '2025-W13', 60);



