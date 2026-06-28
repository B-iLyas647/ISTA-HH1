-- Base de données ISTA HH1
CREATE DATABASE IF NOT EXISTS ista
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE ista;

-- Table des étudiants
CREATE TABLE IF NOT EXISTS etudiants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Nom VARCHAR(50) NOT NULL,
    Prenom VARCHAR(50) NOT NULL,
    Email VARCHAR(100),
    Telephone VARCHAR(20),
    DateNaissance DATE,
    Filiere VARCHAR(100),
    Niveau VARCHAR(50),
    Moyenne DECIMAL(4,2)
);

-- Table des employés
CREATE TABLE IF NOT EXISTS employes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Nom VARCHAR(50) NOT NULL,
    Prenom VARCHAR(50) NOT NULL,
    Email VARCHAR(100),
    Telephone VARCHAR(20),
    Fonction VARCHAR(100),
    Salaire DECIMAL(10,2),
    DateEmbauche DATE
);
