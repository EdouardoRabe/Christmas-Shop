create database noel;

use noel;


CREATE TABLE noel_genre (
    id_genre INT AUTO_INCREMENT PRIMARY KEY,
    nom_genre VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE noel_user_admin (
    id_admin INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL
);

CREATE TABLE noel_user (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL
);

CREATE TABLE noel_depot (
    id_depot INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    montant DECIMAL(10,2) NOT NULL,
    is_ckecked INT,
    date_depot DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES noel_user(id_user) ON DELETE CASCADE
);



CREATE TABLE noel_cadeaux (
    id_cadeau INT AUTO_INCREMENT PRIMARY KEY,
    image VARCHAR(255) NOT NULL,
    id_genre INT NOT NULL,
    prix_unite DECIMAL(10, 2) NOT NULL,
    nom VARCHAR(100) NOT NULL,
    description TEXT NOT NULL
);

CREATE TABLE noel_commande (
    id_commande INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    id_cadeau INT NOT NULL,
    genre INT NOT NULL,
    status INT, 
    date_commande DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES noel_user(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_cadeau) REFERENCES noel_cadeaux(id_cadeau) ON DELETE CASCADE
);


INSERT INTO noel_cadeaux (image, nom, id_genre, prix_unite, description) VALUES
-- GARCON
('assets/img/garcon/Avion.jpeg', 'Avion télécommandé', 1, 39.99, 'Avion télécommandé avec télécommande sans fil, parfait pour les débutants'),
('assets/img/garcon/Camera.jpeg', 'Caméra d''action enfant', 1, 45.99, 'Caméra numérique robuste adaptée aux enfants avec écran LCD'),
('assets/img/garcon/Camion_de_pompier.jpeg', 'Camion de pompier', 1, 29.99, 'Camion de pompier avec échelle mobile et effets sonores'),
('assets/img/garcon/circuit_de_train.jpeg', 'Circuit de train', 1, 59.99, 'Circuit de train en bois avec accessoires et personnages'),
('assets/img/garcon/Drone.jpeg', 'Drone', 1, 89.99, 'Drone avec caméra HD et télécommande'),
('assets/img/garcon/Figurines.jpeg', 'Set de figurines super-héros', 1, 24.99, 'Collection de figurines de super-héros articulées'),
('assets/img/garcon/Fusee.jpeg', 'Fusée Playmobil', 1, 49.99, 'Station spatiale Playmobil avec astronautes et accessoires'),
('assets/img/garcon/Kit_de_sciences.jpeg', 'Kit de sciences', 1, 34.99, 'Kit d''expériences scientifiques avec matériel de laboratoire'),
('assets/img/garcon/LEGO.jpeg', 'Set LEGO construction', 1, 39.99, 'Set de construction LEGO avec véhicules de chantier'),
('assets/img/garcon/Pistolet.jpeg', 'Pistolet à fléchettes', 1, 19.99, 'Pistolet à fléchettes en mousse avec cibles'),
('assets/img/garcon/Puzzle_3D.jpeg', 'Puzzle 3D voiture', 1, 29.99, 'Puzzle 3D Lamborghini, 160 pièces'),
('assets/img/garcon/robot.jpeg', 'Robot interactif', 1, 69.99, 'Robot programmable avec télécommande et fonctions intelligentes'),
('assets/img/garcon/roller.jpeg', 'Rollers ajustables', 1, 49.99, 'Rollers ajustables avec protection complète'),
('assets/img/garcon/Skateboard.jpeg', 'Skateboard', 1, 44.99, 'Skateboard complet pour débutant avec design urbain'),
('assets/img/garcon/Toupi_Beyblade.jpeg', 'Toupies Beyblade', 1, 24.99, 'Set de combat Beyblade avec lanceur et arène'),
('assets/img/garcon/Velo.jpeg', 'Vélo enfant', 1, 129.99, 'Vélo 20 pouces avec changement de vitesses'),
('assets/img/garcon/Voiture_télécommandée.jpeg', 'Voiture télécommandée', 1, 59.99, 'Voiture tout-terrain télécommandée avec suspension'),
-- FILLE
('assets/img/fille/Boite_musique.jpeg', 'Boîte à musique', 2, 34.99, 'Boîte à musique décorative avec danseuse et mélodie'),
('assets/img/fille/Cheval_a_bascule.jpeg', 'Cheval à bascule', 2, 79.99, 'Cheval à bascule rose peluche avec sons'),
('assets/img/fille/Cuisine.jpeg', 'Cuisine en bois', 2, 89.99, 'Cuisine enfant complète avec accessoires'),
('assets/img/fille/Dinette.jpeg', 'Service de dinette', 2, 29.99, 'Set complet de dinette avec vaisselle dorée'),
('assets/img/fille/Ensemble_de_the.jpeg', 'Service à thé', 2, 24.99, 'Service à thé avec plateau et gâteaux'),
('assets/img/fille/Figurines_Princesses.jpeg', 'Set de princesses', 2, 34.99, 'Collection de figurines de princesses'),
('assets/img/fille/Kit_couture.jpeg', 'Kit de couture', 2, 29.99, 'Kit créatif de couture avec accessoires'),
('assets/img/fille/Maison_de_poupees.jpeg', 'Maison de poupées', 2, 99.99, 'Grande maison de poupées avec meubles'),
('assets/img/fille/maquillage.jpeg', 'Kit de maquillage', 2, 19.99, 'Kit de maquillage enfant non toxique'),
('assets/img/fille/Peluche_licorne.jpeg', 'Peluche licorne', 2, 24.99, 'Grande peluche licorne rose douce'),
('assets/img/fille/perles.jpeg', 'Kit de perles', 2, 19.99, 'Set de création de bijoux avec perles'),
('assets/img/fille/poupee.jpeg', 'Poupée avec garde-robe', 2, 39.99, 'Poupée avec collection de vêtements'),
('assets/img/fille/Poupée_Barbie.jpeg', 'Poupée Barbie', 2, 29.99, 'Poupée Barbie avec accessoires'),
('assets/img/fille/Poupee_Mannequin.jpeg', 'Set de poupées mannequins', 2, 44.99, 'Collection de poupées mannequins diverses'),
('assets/img/fille/Poupée_reborn.jpeg', 'Poupée reborn', 2, 69.99, 'Poupée reborn réaliste avec accessoires'),
('assets/img/fille/Puzzle.jpeg', 'Puzzle licorne', 2, 14.99, 'Puzzle thème licorne 100 pièces'),
('assets/img/fille/Velo.jpeg', 'Vélo rose', 2, 129.99, 'Vélo enfant rose avec stabilisateurs'),
-- NEUTRE
('assets/img/neutre/Balle.jpeg', 'Balles multicolores', 3, 12.99, 'Set de balles colorées sensorielles'),
('assets/img/neutre/Boite_a_formes.jpeg', 'Boîte à formes', 3, 24.99, 'Boîte éducative avec formes géométriques'),
('assets/img/neutre/cabane.jpeg', 'Cabane de jardin', 3, 199.99, 'Cabane de jardin pour enfants'),
('assets/img/neutre/Camion.jpeg', 'Porteur camion', 3, 49.99, 'Porteur camion pour enfants'),
('assets/img/neutre/Jeu_construction.jpeg', 'Jeu de construction', 3, 34.99, 'Set de construction magnétique'),
('assets/img/neutre/Jeu_société_Clue.jpeg', 'Jeu Cluedo', 3, 29.99, 'Jeu de société enquête Cluedo'),
('assets/img/neutre/Jouet_de_sable.jpeg', 'Set de plage', 3, 19.99, 'Ensemble jouets de plage et sable'),
('assets/img/neutre/Kit_de_peinture.jpeg', 'Kit de peinture', 3, 39.99, 'Kit complet de peinture et dessin'),
('assets/img/neutre/Livre.jpeg', 'Livre pour enfants', 3, 14.99, 'Livre d''histoires illustré'),
('assets/img/neutre/Mini_guitare.jpeg', 'Mini guitare', 3, 29.99, 'Guitare adaptée aux enfants'),
('assets/img/neutre/monopoly.jpeg', 'Monopoly', 3, 34.99, 'Jeu de société Monopoly classique'),
('assets/img/neutre/Nintendo.jpeg', 'Console Nintendo Switch', 3, 299.99, 'Console de jeux Nintendo Switch'),
('assets/img/neutre/Peluches.jpeg', 'Peluche ours', 3, 24.99, 'Ours en peluche doux'),
('assets/img/neutre/pop_it.jpeg', 'Pop-it', 3, 9.99, 'Jouet anti-stress Pop-it'),
('assets/img/neutre/Puzzle.jpeg', 'Puzzle 3D', 3, 19.99, 'Puzzle 3D monuments'),
('assets/img/neutre/Tapis_de_jeu.jpeg', 'Tapis de jeu', 3, 39.99, 'Tapis de jeu éducatif'),
('assets/img/neutre/uno.jpeg', 'Jeu Uno', 3, 9.99, 'Jeu de cartes Uno Express');



INSERT INTO noel_user (nom, prenom, email, mot_de_passe) VALUES
('Durand', 'Alice', 'alice.durand@example.com', 'motdepasse1'),
('Lemoine', 'Pierre', 'pierre.lemoine@example.com', 'motdepasse2');

INSERT INTO noel_depot(id_user, montant, is_ckecked, date_depot) VALUES
(1, 50000, 0, '2025-01-01 08:00:00'),
(1, 2000, 1, '2025-01-02 09:00:00'),
(1, 500, 0, '2025-01-03 10:30:00'),
(2, 30000, 1, '2025-01-04 11:00:00'),
(2, 750, 1, '2025-01-05 12:15:00'),
(2, 60000, 0, '2025-01-06 13:45:00'),
(1, 8000, 0, '2025-01-07 14:30:00');


INSERT INTO noel_user_admin (nom, prenom, email, mot_de_passe) VALUES
('Admin', 'Super', 'admin.super@example.com', 'adminpassword'),
('Admin', 'Test', 'admin.test@example.com', 'adminpassword123');


