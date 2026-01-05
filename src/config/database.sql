-- Active: 1764803914860@@127.0.0.1@3306@gestioncommandes
CREATE DATABASE gestioncommandes;
Use  gestioncommandes;

CREATE TABLE utilisateurs(
      id INT PRIMARY KEY AUTO_INCREMENT,
      nom_complet VARCHAR(150) NOT NULL,
      email VARCHAR(150) NOT NULL UNIQUE,
      password VARCHAR(255) NOT NULL,
      role ENUM("admin", "client", "livreur") NOT NULL,
      active BOOLEAN DEFAULT FALSE
)ENGINE=INNODB;

CREATE TABLE clients (
      id INT PRIMARY KEY AUTO_INCREMENT,
      utilisateur_id INT UNIQUE NOT NULL,
      FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE
)ENGINE=INNODB;

CREATE TABLE livreurs (
      id INT PRIMARY KEY AUTO_INCREMENT,
      note_moyenne FLOAT DEFAULT 0,
      utilisateur_id INT UNIQUE NOT NULL UNIQUE,
      FOREIGN KEY (utilisateur_id )REFERENCES utilisateurs(id) ON DELETE CASCADE
)ENGINE=INNODB;

CREATE TABLE admins (
      id INT PRIMARY KEY AUTO_INCREMENT,
      utilisateur_id INT UNIQUE NOT NULL,
      FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE
)ENGINE=INNODB;

CREATE TABLE commandes (
      id INT PRIMARY KEY AUTO_INCREMENT,
      description VARCHAR(150),
      etat VARCHAR(50) NOT NULL,
      client_id INT NOT NULL,
      FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE
)ENGINE=INNODB;

CREATE TABLE vehicules (
      id INT PRIMARY KEY AUTO_INCREMENT,
      type VARCHAR(150) NOT NULL,
      description VARCHAR(255),
      livreur_id INT UNIQUE NOT NULL,
      FOREIGN KEY (livreur_id) REFERENCES livreurs(id) ON DELETE CASCADE
)ENGINE=INNODB;

CREATE TABLE offres (
      id INT PRIMARY KEY AUTO_INCREMENT,
      prix FLOAT NOT NULL,
      dure_estime DATETIME,
      commande_id INT NOT NULL,
      livreur_id INT NOT NULL,
      vehicule_id INT,
      FOREIGN KEY (commande_id) REFERENCES commandes(id) ON DELETE CASCADE,
      FOREIGN KEY (livreur_id) REFERENCES livreurs(id) ON DELETE CASCADE,
      FOREIGN KEY (vehicule_id) REFERENCES vehicules(id)
)ENGINE=INNODB;

CREATE TABLE notifications (
      id INT PRIMARY KEY AUTO_INCREMENT,
      type VARCHAR(150) NOT NULL,
      message VARCHAR(255) NOT NULL,
      dure_envoi DATETIME,
      est_lue BOOLEAN DEFAULT FALSE,
      utilisateur_id INT NOT NULL,
      FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETe CASCADE
)ENGINE=INNODB;


