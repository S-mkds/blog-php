-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 07 oct. 2022 à 11:19
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
-- Base de données : `blog-y-bye_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `forum`
--

DROP TABLE IF EXISTS `forum`;
CREATE TABLE IF NOT EXISTS `forum` (
  `id` int(255) NOT NULL,
  `titre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` datetime NOT NULL,
  `ordre` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `topic`
--

DROP TABLE IF EXISTS `topic`;
CREATE TABLE IF NOT EXISTS `topic` (
  `id` int(255) NOT NULL,
  `id_forum` int(255) NOT NULL,
  `titre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contenu` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` datetime NOT NULL,
  `id_user` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `topic_commentaire`
--

DROP TABLE IF EXISTS `topic_commentaire`;
CREATE TABLE IF NOT EXISTS `topic_commentaire` (
  `id` int(255) NOT NULL,
  `id_topic` int(255) NOT NULL,
  `id_user` int(255) NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `mail` varchar(191) NOT NULL,
  `mdp` text NOT NULL,
  `date_creation_compte` datetime NOT NULL,
  `token` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mail` (`mail`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `nom`, `prenom`, `mail`, `mdp`, `date_creation_compte`, `token`) VALUES
(10, 'Elric', 'Edward', 'edward@ed.fr', 'test', '2022-10-07 09:24:03', ''),
(14, 'Mokaddem', 'Samir', 'mokaddem_s@hotmail.fr', '$6$rounds=5000$irkgbjdidjzdzdza$Wqoj2CqtRzBp4W7ToBTSPWnF9sj.EZD03pNxAVyp7XPhkpKtZV63yrc6uOSvf7V8T5Ewl/Ha0EF88HLiG1cx40', '2022-10-07 09:50:48', '320617aeccd9ae65aa122e1a'),
(15, 'Mokaddem', 'testaa', 'mokaddem_s@hotmail.fra', '$6$rounds=5000$irkgbjdidjzdzdza$Wqoj2CqtRzBp4W7ToBTSPWnF9sj.EZD03pNxAVyp7XPhkpKtZV63yrc6uOSvf7V8T5Ewl/Ha0EF88HLiG1cx40', '2022-10-07 09:53:59', '515740963747978eb8e9d655');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
