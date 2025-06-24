-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 24 juin 2025 à 13:45
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bookcycle`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `email_admin_ID` varchar(255) NOT NULL COMMENT 'admin''s email',
  `password` varchar(255) NOT NULL COMMENT 'admin''s acc pw'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `email_client_ID` varchar(255) NOT NULL COMMENT 'unique client ID',
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `preferred_contact_method` enum('Calls','Whatsapp messages','Emails','') NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` enum('Tangier','Tetouan','Rabat','Casablanca','Marrakesh','Agadir','Fez','Meknes','Oujda') NOT NULL,
  `password` varchar(255) NOT NULL COMMENT 'client''s acc pw'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `partners`
--

CREATE TABLE `partners` (
  `email_partner_ID` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `preferred_contact_method` enum('Calls','WhatsApp messages','Emails') NOT NULL,
  `city` enum('Tangier','Tetouan','Rabat','Casablanca','Agadir','Essaouira','Fez','Meknes','Oujda') NOT NULL,
  `type_of_collaboration` enum('Partnership','Sponsorship','Volunteering') NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `field_of_activity` varchar(255) NOT NULL,
  `uploaded_file` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `request_form`
--

CREATE TABLE `request_form` (
  `request_ID` int(11) NOT NULL,
  `email_client_ID` varchar(255) NOT NULL,
  `submission_date` datetime NOT NULL,
  `category` enum('Books only','Notebooks only','Both') NOT NULL,
  `quantity` int(11) NOT NULL,
  `pickup_address` varchar(255) NOT NULL,
  `pickup_date` date NOT NULL,
  `additional_remarks` text DEFAULT NULL,
  `status` enum('Recieved','Scheduled','On the way','Collected','Canceled') NOT NULL,
  `books_price` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `volunteers`
--

CREATE TABLE `volunteers` (
  `email_volunteer_ID` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `preferred_contact_method` enum('Calls','WhatsApp messages','Emails') NOT NULL,
  `city` enum('Tangier','Tetouan','Rabat','Casablanca','Agadir','Essaouira','Fez','Meknes','Oujda') NOT NULL,
  `type_of_collaboration` enum('Partnership','Sponsorship','Volunteering') NOT NULL,
  `desired_role` enum('Books collection','Books sorting','Selling to companies','Branding and Community outreach','administrative 																			assistance') NOT NULL,
  `how_often_can_you_volunteer` enum('Occasionally','Once a week','Several times a week','Weekends only','Flexible') NOT NULL,
  `uploaded_file` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`email_admin_ID`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`email_client_ID`);

--
-- Index pour la table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`email_partner_ID`);

--
-- Index pour la table `request_form`
--
ALTER TABLE `request_form`
  ADD PRIMARY KEY (`request_ID`),
  ADD KEY `email_client_ID` (`email_client_ID`);

--
-- Index pour la table `volunteers`
--
ALTER TABLE `volunteers`
  ADD PRIMARY KEY (`email_volunteer_ID`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `request_form`
--
ALTER TABLE `request_form`
  MODIFY `request_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `request_form`
--
ALTER TABLE `request_form`
  ADD CONSTRAINT `request_form_ibfk_1` FOREIGN KEY (`email_client_ID`) REFERENCES `client` (`email_client_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
