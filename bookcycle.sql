-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 30 juin 2025 à 12:19
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
  `password` varchar(255) NOT NULL COMMENT 'admin''s acc pw',
  `admin_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`email_admin_ID`, `password`, `admin_name`) VALUES
('admin@bookcycle.com', '$2y$10$iHiEZC5ZZckZir8s4mVU1uP21H9ECX1W4StUONPU2kizJG/o9NVXi', 'Tasnim');

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
('sghiar555@gmail.com', 'omar', 'sghiar', '0612345678', 'calls', 'tantan', '$2y$10$WGHEM7iBr/Ybe3L98kd0ueySE9dYcaD0zk961NMOJCryzP3bWDP6.'),
('tasnijbueldi@gmail.com', 'lala', 'lolo', '0612345678', 'emails', 'bvhvhb', '$2y$10$IxJtEEShuwlv048a5A2wKOrAadkBKO/z0gYjJMxET4vrCtiEtU9eG'),
('tasnimmezgueldi@gmail.com', 'Tasnimm', 'Meezgueldi', '0612345678', 'calls', 'Tanger', '$2y$10$xSOISprYOSxvcZ3cfazD5.ENV.6dEwZaotLjY7yUh5a.PhxpfwQrO');

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
('aminabkl@gmail.com', 'amina bakkali', '0512345678', 'emails', 'tetouan', 'partnership', 'charika osf', 'kolchi', 'collaborate_form_uploaded_files/685e75930a9aa-artworks-A6nuK9vln4RVXzEw-EoifQA-t500x500.jpg', 'ana bghit n collabori m3akom'),
('email@gmail.com', 'zoubir', 'allal', 'calls', 'zagora', 'partnership', 'man3raf', 'ma3arfachi', 'collaborate_form_uploaded_files/685d92d76ed24-IMG_20241214_212308_994.jpg', 'wasiro b7alkooooooooooooooooooom'),
('lalalolo@gmail.com', 'lala lolo', '0612345678', 'whatsapp', 'bvhvhb', 'partnership', 'as', 'ss', 'uploads/685b32539c1e8-why.png', 'ésésés'),
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
  `status` enum('processing','scheduled','in transit','collected','canceled') NOT NULL,
  `books_price` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `request_form`
--

INSERT INTO `request_form` (`request_ID`, `email_client_ID`, `submission_date`, `category`, `quantity`, `pickup_address`, `pickup_date`, `additional_remarks`, `status`, `books_price`) VALUES
(13, 'tasnimmezgueldi@gmail.com', '2025-06-27 02:38:29', 'notebooks', '5 - 10 book', 'frdsdsfre', '2025-06-27', 'fscdecdf', 'in transit', 0.00),
(14, 'sghiar555@gmail.com', '2025-06-27 11:51:50', 'both', '50+ book', 'chi 7awma osf', '2025-06-28', '', 'canceled', 0.00),
(15, 'sghiar555@gmail.com', '2025-06-27 11:58:41', 'notebooks', '5 - 10 book', 'nn', '2025-06-29', 'nn', 'processing', 0.00);

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
('mama88@gmail.com', 'maryam', 'kholti', 'emails', 'merzouga', 'volunteering', 'communication', 'once a week', 'collaborate_form_uploaded_files/685e77909cdef-ae7f662d-2497-47d8-92e3-4ba817826d06.jpeg', 'sbguygwsbyuQBGTSYUTAZVSYTG'),
('samadi18@gmail.com', 'mohsin samadi', '0605040302', 'calls', 'rabat', 'volunteering', 'logistics', 'weekends only', 'collaborate_form_uploaded_files/685e761bcd915-53d7b5e0223f687c82a8a964cfcb434a.jpg', 'ana bghit nettowwa3 m3akom'),
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
  MODIFY `request_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
