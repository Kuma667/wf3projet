-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 16 juin 2020 à 07:41
-- Version du serveur :  8.0.18
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `wf3symfony`
--

-- --------------------------------------------------------

--
-- Structure de la table `annonces`
--

DROP TABLE IF EXISTS `annonces`;
CREATE TABLE IF NOT EXISTS `annonces` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` int(11) NOT NULL,
  `ville` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `premium` tinyint(1) NOT NULL,
  `categorie_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_CB988C6FA76ED395` (`user_id`),
  KEY `IDX_CB988C6FBCF5E72D` (`categorie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `annonces`
--

INSERT INTO `annonces` (`id`, `titre`, `description`, `prix`, `ville`, `created_at`, `user_id`, `premium`, `categorie_id`) VALUES
(8, 'test', 'test', 44, 'test', '2020-06-10 13:13:40', 1, 1, 1),
(9, 'voiture', 'magnifique voiture', 2500, 'Strasbourg', '2020-06-10 13:30:55', 1, 0, 3),
(10, 'Appartement T4', 'Superbe appart\' plein centre', 550, 'Strasbourg', '2020-06-11 08:49:50', 1, 0, 1),
(11, 'test 33', '3333', 333, 'test', '2020-06-11 09:32:52', 1, 0, 1),
(12, 'ordinateur', 'occasion i5 bla bla', 599, 'Strasbourg', '2020-06-11 14:25:06', 1, 0, 1),
(13, 'annonce 05', 'description lzozozozozozo', 220, 'Colmar', '2020-06-12 10:22:41', 3, 1, 2),
(14, 'annonce 05', 'description lzozozozozozo', 220, 'Colmar', '2020-06-12 10:22:41', 3, 1, 2),
(15, 'test 33', '3333', 333, 'test', '2020-06-11 09:32:52', 1, 0, 1),
(16, 'Appartement T4', 'Superbe appart\' plein centre', 550, 'Strasbourg', '2020-06-11 08:49:50', 1, 0, 1),
(17, 'voiture', 'magnifique voiture', 2500, 'Strasbourg', '2020-06-10 13:30:55', 1, 0, 3),
(18, 'test 33', '3333', 333, 'test', '2020-06-11 09:32:52', 1, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `nom`, `slug`) VALUES
(1, 'Immobilier', 'immobilier'),
(2, 'Mode', 'mode'),
(3, 'Véhicules', 'vehicules'),
(5, 'Loisirs', 'loisirs'),
(6, 'Multimédia', 'multimedia'),
(7, 'Mobilier', 'mobilier');

-- --------------------------------------------------------

--
-- Structure de la table `historique`
--

DROP TABLE IF EXISTS `historique`;
CREATE TABLE IF NOT EXISTS `historique` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url_historique` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_EDBFD5ECA76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `historique`
--

INSERT INTO `historique` (`id`, `url_historique`, `created_at`, `user_id`) VALUES
(1, '/search?categorie=immobilier&search=voiture', '2020-06-10 14:06:45', 1),
(2, '/search?categorie=immobilier&search=voiture', '2020-06-10 14:07:11', 1),
(3, '/search?search=', '2020-06-12 10:23:15', 3),
(4, '/search?search=', '2020-06-12 10:46:51', 3),
(5, '/search?search=', '2020-06-12 10:47:02', 3),
(6, '/search?search=', '2020-06-12 10:47:12', 3);

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `annonces_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E01FBE6A4C2885D7` (`annonces_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `images`
--

INSERT INTO `images` (`id`, `annonces_id`, `name`) VALUES
(4, 9, 'aa183acca7575352f4021ea320a24749.jpg'),
(5, 9, 'cc6d41a37eb1c58d290cd70ea7cfaa52.jpg'),
(9, 8, '5cf26993c13a9eea05c21532e9405624.jpg'),
(14, 8, '6f7c2e3e8383ca3c8c3ae471d5a01331.jpg'),
(15, 8, '81cbb7ac8917fac47c688ed2d5dfc6d5.jpg'),
(16, 10, '0906c739583e221a8de55e94c1dd9934.jpg'),
(17, 11, 'e05723c19277802e51e1a670ddbb9c87.jpg'),
(18, 12, 'c20eb56221e292b559796505d2e131e2.jpg'),
(19, 12, 'd3908aec47ba59fab476154814a533de.jpg'),
(20, 12, 'd1071e31f2ca0eecae15f94810c69d65.jpg'),
(21, 13, '370011e0b3bf2d1630270cb83c217d1f.jpg'),
(22, 13, '03676b0bcb0fec85fa49b9efb3364cf2.jpg'),
(23, 13, '6fab841294790fd9d96bb92e012f73ce.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE IF NOT EXISTS `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20200529092251', '2020-05-29 09:25:12'),
('20200608073515', '2020-06-08 07:38:41');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numtel` int(11) NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `roles` json NOT NULL,
  `is_verified` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `nom`, `prenom`, `email`, `numtel`, `password`, `created_at`, `roles`, `is_verified`) VALUES
(1, 'Rahmoun', 'Cyril', 'contact@cyrilrahmoun.fr', 1234567891, '$argon2id$v=19$m=65536,t=4,p=1$bE1NV1VVNWJQLnlxcDBFbQ$nbrSwdR6JQLcQEskUBapred9OwrC/EIBvJv0L9pupFY', '2020-06-08 00:00:00', '[\"ROLE_ADMIN\"]', 1),
(2, 'RAHMOUN', 'Cyril', 'c.rahmoun@hotmail.com', 630120855, '$argon2id$v=19$m=65536,t=4,p=1$dzJSZWo3aTkzWmdNUWpQcw$8zMwr5T/U/+krDy4aYZKj7vjdM4VK2l1/j8nPqECeOs', '2020-06-09 08:03:32', '[]', 1),
(3, 'test', 'inscription', 'test@inscription.fr', 1255555555, '$argon2id$v=19$m=65536,t=4,p=1$b1FUQUZkNUY0SEJDeE9pMw$Lp27An6q/3UazYc4bQr6x3ekAHQy81qO9YYn921A2HY', '2020-06-12 09:39:07', '[]', 0);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `annonces`
--
ALTER TABLE `annonces`
  ADD CONSTRAINT `FK_CB988C6FA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_CB988C6FBCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`);

--
-- Contraintes pour la table `historique`
--
ALTER TABLE `historique`
  ADD CONSTRAINT `FK_EDBFD5ECA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `FK_E01FBE6A4C2885D7` FOREIGN KEY (`annonces_id`) REFERENCES `annonces` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
