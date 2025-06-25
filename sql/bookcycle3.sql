-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 25 juin 2025 à 12:47
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

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`email_admin_ID`, `password`) VALUES
('admin@bookcycle.com', '$2y$10$StkCWn2zpgZpfboiWG2Ul.dj41LUWBQaM9NCSN5FqvBNruhRAoGv2');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `email_client_ID` varchar(255) NOT NULL COMMENT 'unique client ID',
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `preferred_contact_method` enum('calls','whatsapp','emails','') NOT NULL,
  `city` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL COMMENT 'client''s acc pw'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`email_client_ID`, `first_name`, `last_name`, `phone_number`, `preferred_contact_method`, `city`, `password`) VALUES
('medsaid@gmail.com', 'med', 'said', '0612345678', 'calls', 'Tanger', '$2y$10$lcVnLBYyczk2oKj0xLndHOWoKstD7wmuIt5S5mnN0cdK5DzdpcAHm'),
('olgabulga@gmail.com', 'human', 'being', '0612345678', 'whatsapp', 'Atlantis', '$2y$10$BTUNEhgCI4fyutVAhd7jG.U5Bx0GThi7Lsby0TOx7L0c8Au1HMD7a'),
('tasnijbjhbhjmmezgueldi@gmail.com', 'lala', 'lolo', '0612345678', 'whatsapp', 'bvhvhb', '$2y$10$y7pApXQ7gvsP6H9tiPdG0eo9k6uaHoE27Y4EPebN/5RzJtnIlWgvi'),
('tasnijbueldi@gmail.com', 'lala', 'lolo', '0612345678', 'emails', 'bvhvhb', '$2y$10$IxJtEEShuwlv048a5A2wKOrAadkBKO/z0gYjJMxET4vrCtiEtU9eG'),
('tasnimmezgueldi@gmail.com', 'Tasnim', 'Mezgueldi', '0612345678', 'calls', 'Tanger', '$2y$10$xSOISprYOSxvcZ3cfazD5.ENV.6dEwZaotLjY7yUh5a.PhxpfwQrO');

-- --------------------------------------------------------

--
-- Structure de la table `partners`
--

CREATE TABLE `partners` (
  `email_partner_ID` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `preferred_contact_method` enum('calls','whatsapp','emails') NOT NULL,
  `city` varchar(255) NOT NULL,
  `type_of_collaboration` enum('partnership','volunteering') NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `field_of_activity` varchar(255) NOT NULL,
  `uploaded_file` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `partners`
--

INSERT INTO `partners` (`email_partner_ID`, `full_name`, `phone_number`, `preferred_contact_method`, `city`, `type_of_collaboration`, `company_name`, `field_of_activity`, `uploaded_file`, `message`) VALUES
('lalalolo@gmail.com', 'lala lolo', '0612345678', 'whatsapp', 'bvhvhb', 'partnership', 'as', 'ss', 'uploads/685b32539c1e8-why.png', 'ésésés'),
('tasnijbueldi@gmail.com', 'lala lolo', '0612345678', 'calls', 'bvhvhb', 'partnership', 'nn,', 'nnn', 'uploads/685b31fc53e91-BROCHURE_GENIE_INDUSTRIEL.pdf', 'nnn'),
('tasnijdsqsdbueldi@gmail.com', 'lala lolo', '0612345678', 'emails', 'bvhvhb', 'partnership', 'ds', 'sd', 'uploads/685b33dfbaef3-Tiësto - Lethal Industry (Official Video).mp3', 'bjh'),
('tasnimmezgueldi@gmail.com', 'lala lolo', '0612345678', 'whatsapp', 'bvhvhb', 'partnership', 'ghhb', 'jbhj', 'uploads/685b2c3e14e5e-business.png', 'bguhjbjghb');

-- --------------------------------------------------------

--
-- Structure de la table `request_form`
--

CREATE TABLE `request_form` (
  `request_ID` int(11) NOT NULL,
  `email_client_ID` varchar(255) NOT NULL,
  `submission_date` datetime NOT NULL,
  `category` enum('books','notebooks','both') NOT NULL,
  `quantity` enum('5 - 10 book','10 - 50 book','50+ book') NOT NULL,
  `pickup_address` varchar(255) NOT NULL,
  `pickup_date` date NOT NULL,
  `additional_remarks` text DEFAULT NULL,
  `status` enum('Recieved','Scheduled','On the way','Collected','Canceled') NOT NULL,
  `books_price` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `request_form`
--

INSERT INTO `request_form` (`request_ID`, `email_client_ID`, `submission_date`, `category`, `quantity`, `pickup_address`, `pickup_date`, `additional_remarks`, `status`, `books_price`) VALUES
(1, 'tasnimmezgueldi@gmail.com', '2025-06-24 22:18:33', 'books', '5 - 10 book', 'aabhjbszjhedbsvzhedgbvhzbv', '2025-06-20', 'xdrfvgbsxqhsqjjiqz', '', 0.00),
(2, 'tasnimmezgueldi@gmail.com', '2025-06-24 22:20:33', 'books', '5 - 10 book', 'aabhjbszjhedbsvzhedgbvhzbv', '2025-06-20', 'xdrfvgbsxqhsqjjiqz', '', 0.00),
(3, 'tasnimmezgueldi@gmail.com', '2025-06-24 22:21:02', 'notebooks', '5 - 10 book', 'edbjhhbjezbjhe', '2026-03-25', 'ezjnkenjkenkje', '', 0.00),
(4, 'tasnimmezgueldi@gmail.com', '2025-06-24 22:22:22', 'notebooks', '5 - 10 book', 'edbjhhbjezbjhe', '2026-03-25', 'ezjnkenjkenkje', '', 0.00),
(5, 'tasnimmezgueldi@gmail.com', '2025-06-24 22:22:41', 'notebooks', '10 - 50 book', 'dezvgezydevz', '2025-02-02', 'zehubdenhjejunde', '', 0.00),
(6, 'tasnimmezgueldi@gmail.com', '2025-06-24 22:32:08', 'notebooks', '10 - 50 book', 'szgv', '2003-02-02', 'zev gje', '', 0.00),
(7, 'tasnimmezgueldi@gmail.com', '2025-06-24 22:42:42', 'notebooks', '5 - 10 book', 'dezed', '2054-04-04', 'eedezdx', '', 0.00),
(8, 'tasnimmezgueldi@gmail.com', '2025-06-25 01:37:26', 'both', '10 - 50 book', 'hggg', '2025-02-02', 'hbugbuyg', '', 0.00);

-- --------------------------------------------------------

--
-- Structure de la table `volunteers`
--

CREATE TABLE `volunteers` (
  `email_volunteer_ID` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `preferred_contact_method` enum('calls','whatsapp','emails') NOT NULL,
  `city` varchar(255) NOT NULL,
  `type_of_collaboration` enum('partnership','volunteering') NOT NULL,
  `desired_role` enum('logistics','sorting','communication','admin_assistance') NOT NULL,
  `how_often_can_you_volunteer` enum('occasionally','once a week','several times a week','weekends only','flexible') NOT NULL,
  `uploaded_file` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `volunteers`
--

INSERT INTO `volunteers` (`email_volunteer_ID`, `full_name`, `phone_number`, `preferred_contact_method`, `city`, `type_of_collaboration`, `desired_role`, `how_often_can_you_volunteer`, `uploaded_file`, `message`) VALUES
('lalalnjbolo@gmail.com', 'lala lolo', '0612345678', 'emails', 'bvhvhb', 'volunteering', 'admin_assistance', 'once a week', 'uploads/685b33882928a-David Guetta vs Benny Benassi - Satisfaction (Hardwell & Maddix Remix) [Official Music Video].mp3', 'vgh'),
('ta555snijbueldi@gmail.com', 'lala lolo', '0612345678', 'emails', 'bvhvhb', 'volunteering', 'communication', 'once a week', 'uploads/685b343f898eb-Brain_Code game soundtrack.mp3', 'hhh'),
('tasnijbueldi@gmail.com', 'lala lolo', '0612345678', 'whatsapp', 'bvhvhb', 'volunteering', 'sorting', 'weekends only', 'uploads/685b2cbf78214-Profile (1).png', 'bhjbvhjnszkjzk'),
('tasnijbufgcgfcgcgeldi@gmail.com', 'lala lolo', '0612345678', 'whatsapp', 'bvhvhb', 'volunteering', 'communication', 'occasionally', NULL, 'vhgvhgcgfc');

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
  MODIFY `request_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
