-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 07 juil. 2024 à 09:49
-- Version du serveur : 8.2.0
-- Version de PHP : 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projetservices`
--

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb3_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb3_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `note`
--

DROP TABLE IF EXISTS `note`;
CREATE TABLE IF NOT EXISTS `note` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(30) COLLATE utf8mb3_unicode_ci NOT NULL,
  `text` longtext COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `reminder` tinyint(1) NOT NULL,
  `date` date DEFAULT NULL,
  `emailsend` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `datemodif` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_CFBDFA14A76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `service`
--

DROP TABLE IF EXISTS `service`;
CREATE TABLE IF NOT EXISTS `service` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb3_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `price_month` int DEFAULT NULL,
  `price_year` int DEFAULT NULL,
  `user_address_id` int DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E19D9AD252D06999` (`user_address_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1223 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `service`
--

INSERT INTO `service` (`id`, `name`, `link`, `price_month`, `price_year`, `user_address_id`, `type`) VALUES
(1203, 'Autre', 'https://www.Autre.fr', 703, 8436, 713, 'Autre'),
(1204, 'Gaz', 'https://www.Gaz.fr', 65, 780, 714, 'Gaz'),
(1205, 'Électricité', 'https://www.Électricité.fr', 61, 732, 713, 'Électricité'),
(1206, 'Eau', 'https://www.Eau.fr', 304, 3648, 715, 'Eau'),
(1207, 'Eau', 'https://www.Eau.fr', 703, 8436, 715, 'Eau'),
(1209, 'Assurance-véhicule', 'https://www.Assurance-véhicule.fr', 336, 4032, 714, 'Assurance-véhicule'),
(1210, 'Eau', 'https://www.Eau.fr', 639, 7668, 716, 'Eau'),
(1211, 'Eau', 'https://www.Eau.fr', 881, 10572, 716, 'Eau'),
(1212, 'Forfait-Box-internet', 'https://www.Forfait-Box-internet.fr', 879, 10548, 714, 'Forfait-Box-internet'),
(1213, 'Forfait-téléphonie', 'https://www.Forfait-téléphonie.fr', 968, 11616, 713, 'Forfait-téléphonie'),
(1214, 'Assurance-habitation', 'https://www.Assurance-habitation.fr', 587, 7044, 713, 'Assurance-habitation'),
(1215, 'Gaz', 'https://www.Gaz.fr', 808, 9696, 713, 'Gaz'),
(1216, 'Autre', 'https://www.Autre.fr', 345, 4140, 714, 'Autre'),
(1218, 'Gaz', 'https://www.Gaz.fr', 234, 2808, 715, 'Gaz'),
(1219, 'Gaz', 'https://www.Gaz.fr', 135, 1620, 713, 'Gaz'),
(1220, 'Forfait-Box-internet', 'https://www.Forfait-Box-internet.fr', 728, 8736, 714, 'Forfait-Box-internet'),
(1221, 'Forfait-téléphonie', 'https://www.Forfait-téléphonie.fr', 126, 1512, 713, 'Forfait-téléphonie'),
(1222, 'Assurance-véhicule', 'https://www.Assurance-véhicule.fr', 100, 1200, 714, 'Assurance-véhicule');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8mb3_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8mb3_unicode_ci NOT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `name` varchar(30) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `firstname` varchar(30) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `date_of_birth` date NOT NULL,
  `telephone` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_USERNAME` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=531 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `password`, `email`, `is_verified`, `name`, `firstname`, `date_of_birth`, `telephone`) VALUES
(526, 'username0', '[\"ROLE_USER\", \"ROLE_ADMIN\"]', '$2y$13$6W6204T.gkLXMb2VMJgmxOpnMTYCie4celVB/CtRmXemeAJPryRgC', 'utilisateur0@services.com', 1, 'Utilisateur Name', 'Firstname', '1971-07-07', 0),
(527, 'username1', '[\"ROLE_USER\"]', '$2y$13$E7OXPSVxDQ2qQT2hAmQ00OyWt7FOVDvaQu0o5K8lk0yfflKUw955a', 'utilisateur1@services.com', 1, 'Utilisateur Name', 'Firstname', '1956-07-07', 1),
(528, 'username2', '[\"ROLE_USER\"]', '$2y$13$pDlkGrSHL.s6fh51VbasfeB3p5A3NvmiJChYyTc7K9i3iCubbcs/y', 'utilisateur2@services.com', 1, 'Utilisateur Name', 'Firstname', '1957-07-07', 2),
(529, 'username3', '[\"ROLE_USER\"]', '$2y$13$JIGO3bYe5bc/Y2YCf0ZOX.fVDhGJM64cQV1n92eyin1OgxdealYQW', 'utilisateur3@services.com', 1, 'Utilisateur Name', 'Firstname', '1997-07-07', 3),
(530, 'username4', '[\"ROLE_USER\"]', '$2y$13$WKP/x7pKN6uwCJgKIBKO4.h2v2O25sAi/5A7Cm7Lios4O.TUqwzBK', 'utilisateur4@services.com', 1, 'Utilisateur Name', 'Firstname', '1983-07-07', 4);

-- --------------------------------------------------------

--
-- Structure de la table `user_address`
--

DROP TABLE IF EXISTS `user_address`;
CREATE TABLE IF NOT EXISTS `user_address` (
  `id` int NOT NULL AUTO_INCREMENT,
  `address` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `city` varchar(20) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `postal_code` int DEFAULT NULL,
  `main_address` tinyint(1) NOT NULL,
  `user_id` int DEFAULT NULL,
  `dwelling_type` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `dwelling_size` int NOT NULL,
  `rental` tinyint(1) DEFAULT NULL,
  `number` int DEFAULT NULL,
  `additional` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `rentprice` int DEFAULT NULL,
  `real_estate_agency` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5543718BA76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=717 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `user_address`
--

INSERT INTO `user_address` (`id`, `address`, `city`, `postal_code`, `main_address`, `user_id`, `dwelling_type`, `dwelling_size`, `rental`, `number`, `additional`, `rentprice`, `real_estate_agency`) VALUES
(713, 'rue inconnu 1', 'Ville1', 66649, 0, 527, 'Appartement', 243, 0, 0, NULL, NULL, NULL),
(714, 'rue inconnu 2', 'Ville2', 50226, 0, 528, 'Appartement', 187, 1, 64, NULL, NULL, NULL),
(715, 'rue inconnu 3', 'Ville3', 83826, 0, 529, 'Appartement', 101, 1, 40, NULL, NULL, NULL),
(716, 'rue inconnu 4', 'Ville4', 94234, 0, 530, 'Appartement', 220, 1, 1, NULL, NULL, NULL);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `note`
--
ALTER TABLE `note`
  ADD CONSTRAINT `FK_CFBDFA14A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `service`
--
ALTER TABLE `service`
  ADD CONSTRAINT `FK_E19D9AD252D06999` FOREIGN KEY (`user_address_id`) REFERENCES `user_address` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Contraintes pour la table `user_address`
--
ALTER TABLE `user_address`
  ADD CONSTRAINT `FK_5543718BA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
