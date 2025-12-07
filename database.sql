CREATE DATABASE fitmanager;
USE fitmanager;

CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE cours (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    categorie ENUM('Yoga', 'Musculation', 'Cardio', 'Pilates') NOT NULL,
    date_cours DATE NOT NULL,
    heure TIME NOT NULL,
    duree_minutes INT NOT NULL DEFAULT 60,
    max_participants INT NOT NULL DEFAULT 10,
    user_id INT NOT NULL,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES utilisateurs(id) ON DELETE CASCADE
);

CREATE TABLE equipements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    type ENUM('Tapis de course', 'Halteres', 'Ballons', 'Velo', 'Banc') NOT NULL,
    quantite INT NOT NULL DEFAULT 1,
    etat ENUM('Bon', 'Moyen', 'A remplacer') NOT NULL DEFAULT 'Bon',
    user_id INT NOT NULL,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES utilisateurs(id) ON DELETE CASCADE
);

CREATE TABLE cours_equipements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cours_id INT NOT NULL,
    equipement_id INT NOT NULL,
    quantite_utilisee INT NOT NULL DEFAULT 1,
    FOREIGN KEY (cours_id) REFERENCES cours(id) ON DELETE CASCADE,
    FOREIGN KEY (equipement_id) REFERENCES equipements(id) ON DELETE CASCADE,
    UNIQUE KEY unique_cours_equipement (cours_id, equipement_id)
);

INSERT INTO utilisateurs (nom, email, password) VALUES 
('Abdelghafour', 'abdelghafour@gmail.com', 'abdelghafour');

INSERT INTO cours (nom, categorie, date_cours, heure, duree_minutes, max_participants, user_id) VALUES
('Yoga du matin', 'Yoga', '2025-01-10', '08:00:00', 60, 15, 1),
('Cardio intense', 'Cardio', '2025-01-11', '18:00:00', 45, 20, 1),
('Musculation avancee', 'Musculation', '2025-01-12', '19:00:00', 90, 10, 1);

INSERT INTO equipements (nom, type, quantite, etat, user_id) VALUES
('Tapis Pro 3000', 'Tapis de course', 5, 'Bon', 1),
('Halteres 10kg', 'Halteres', 20, 'Bon', 1),
('Ballon gym', 'Ballons', 15, 'Moyen', 1),
('Velo spinning', 'Velo', 8, 'Bon', 1);