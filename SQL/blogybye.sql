-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 17 oct. 2022 à 18:01
-- Version du serveur : 5.7.36
-- Version de PHP : 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `blogybye`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `id_blog` int(255) NOT NULL,
  `titre` varchar(50) NOT NULL,
  `contenu` longtext NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime NOT NULL,
  `id_utilisateur` int(255) NOT NULL,
  `statut` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `id_blog`, `titre`, `contenu`, `date_creation`, `date_modification`, `id_utilisateur`, `statut`) VALUES
(3, 7, 'Titre #1', 'test', '2022-10-17 17:49:34', '2022-10-17 17:49:34', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `article_commentaire`
--

DROP TABLE IF EXISTS `article_commentaire`;
CREATE TABLE IF NOT EXISTS `article_commentaire` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `id_article` int(255) NOT NULL,
  `id_utilisateur` int(255) NOT NULL,
  `contenu` longtext NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `article_commentaire`
--

INSERT INTO `article_commentaire` (`id`, `id_article`, `id_utilisateur`, `contenu`, `date_creation`, `date_modification`) VALUES
(4, 7, 1, 'Bienvenue dans mon blog', '2022-10-17 17:48:51', '2022-10-17 17:48:51'),
(6, 3, 1, 'super votre blog !', '2022-10-17 19:55:54', '2022-10-17 19:55:54');

-- --------------------------------------------------------

--
-- Structure de la table `blog`
--

DROP TABLE IF EXISTS `blog`;
CREATE TABLE IF NOT EXISTS `blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(50) NOT NULL,
  `libelle` varchar(50) NOT NULL,
  `date_creation` datetime NOT NULL,
  `ordre` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `blog`
--

INSERT INTO `blog` (`id`, `titre`, `libelle`, `date_creation`, `ordre`) VALUES
(7, 'Mon blog', 'Crée un blog', '2022-10-17 17:19:42', 1);

-- --------------------------------------------------------

--
-- Structure de la table `forum`
--

DROP TABLE IF EXISTS `forum`;
CREATE TABLE IF NOT EXISTS `forum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(50) NOT NULL,
  `libelle` varchar(50) NOT NULL,
  `date_creation` datetime NOT NULL,
  `ordre` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `forum`
--

INSERT INTO `forum` (`id`, `titre`, `libelle`, `date_creation`, `ordre`) VALUES
(1, 'Voyages', 'Vacances', '2022-10-11 14:53:20', 1),
(2, 'Jeux videos', 'Gaming', '2022-10-17 10:10:20', 2),
(3, 'Matériels informatiques', 'Hardwares', '2022-10-17 10:10:20', 3),
(4, 'Logiciels', 'Softwares', '2022-10-17 10:10:20', 4),
(5, 'Résolutions de bugs', 'Bugs', '2022-10-17 10:10:20', 5),
(6, 'Divers', 'Others', '2022-10-17 10:10:20', 6);

-- --------------------------------------------------------

--
-- Structure de la table `topic`
--

DROP TABLE IF EXISTS `topic`;
CREATE TABLE IF NOT EXISTS `topic` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `id_forum` int(255) NOT NULL,
  `titre` varchar(50) NOT NULL,
  `contenu` longtext NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime NOT NULL,
  `id_utilisateur` int(255) NOT NULL,
  `statut` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `topic`
--

INSERT INTO `topic` (`id`, `id_forum`, `titre`, `contenu`, `date_creation`, `date_modification`, `id_utilisateur`, `statut`) VALUES
(2, 1, 'Salut les voyageurs', 'Bonjour, bienvenue dans ce forum\r\n-- sections voyages', '2022-10-17 13:03:57', '2022-10-17 13:03:57', 4, 0),
(3, 6, 'Lorem Ipsum c\'est quoi ?', 'Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum', '2022-10-17 19:28:13', '2022-10-17 19:28:13', 1, 0),
(4, 1, 'Un autre topic voyage', 'an other one', '2022-10-17 19:52:21', '2022-10-17 19:52:21', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `topic_commentaire`
--

DROP TABLE IF EXISTS `topic_commentaire`;
CREATE TABLE IF NOT EXISTS `topic_commentaire` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `id_topic` int(255) NOT NULL,
  `id_utilisateur` int(255) NOT NULL,
  `contenu` longtext NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `topic_commentaire`
--

INSERT INTO `topic_commentaire` (`id`, `id_topic`, `id_utilisateur`, `contenu`, `date_creation`, `date_modification`) VALUES
(3, 2, 1, 'Samir', '2022-10-17 14:58:16', '2022-10-17 14:58:16'),
(4, 3, 1, 'haha', '2022-10-17 19:28:18', '2022-10-17 19:28:18');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(50) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `mdp` text NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_connexion` datetime NOT NULL,
  `role` int(1) NOT NULL DEFAULT '0',
  `avatar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `pseudo`, `mail`, `mdp`, `date_creation`, `date_connexion`, `role`, `avatar`) VALUES
(1, 'Samir', 'mokaddem_s@hotmail.fr', '$argon2id$v=19$m=65536,t=4,p=1$ekk2bC44d201My5oOHBtRQ$QX21Iiq7wcJn2QxVYX2temwy5wmWatwak+wK31+KE1A', '2022-10-11 14:16:47', '2022-10-17 19:08:56', 1, NULL),
(2, 'Samir2', 'mokaddem_s@hotmail.fra', '$argon2id$v=19$m=65536,t=4,p=1$ZC4uMVJBQzhlVEhaSHovcg$ouilcN/dwIeC16pXm28a9o3yHi16J4jSUbxxShmX5CA', '2022-10-11 14:17:07', '2022-10-11 14:17:11', 0, NULL),
(3, 'Edward', 'edward@ed.fr', '$argon2id$v=19$m=65536,t=4,p=1$UDlZNkE2NXBsTzdJWWdHSg$fBz0Pbj90mmNIBoYvUpwDh79K1ju+xQ7CoOdCdO6DH4', '2022-10-11 15:23:50', '2022-10-17 14:58:32', 0, '875b18a68b4dec8e296a83f0a204ea10.jpg'),
(4, 'Edward1', 'edward@ed.fra', '$argon2id$v=19$m=65536,t=4,p=1$S3QwdUxNZkJuQWhaZ0RSbQ$Ca9NcZx+GDg1UPRt4G5R37ZrrWmKLXxbJPZ7RglLpuE', '2022-10-17 11:48:06', '2022-10-17 11:48:15', 0, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
