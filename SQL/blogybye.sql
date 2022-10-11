# ************************************************************
# Base de données: BlogyBye
# © Blogybye
# ************************************************************


# Affichage de la table forum
# ------------------------------------------------------------

CREATE TABLE `forum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(50) NOT NULL,
  `libelle` varchar(50) NOT NULL,
  `date_creation` datetime NOT NULL,
  `ordre` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Affichage de la table topic
# ------------------------------------------------------------

CREATE TABLE `topic` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `id_forum` int(255) NOT NULL,
  `titre` varchar(50) NOT NULL,
  `contenu` longtext NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime NOT NULL,
  `id_utilisateur` int(255) NOT NULL,
  `statut` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Affichage de la table topic_commentaire
# ------------------------------------------------------------

CREATE TABLE `topic_commentaire` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `id_topic` int(255) NOT NULL,
  `id_utilisateur` int(255) NOT NULL,
  `contenu` longtext NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Affichage de la table utilisateur
# ------------------------------------------------------------

CREATE TABLE `utilisateur` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(50) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `mdp` text NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_connexion` datetime NOT NULL,
  `role` int(1) NOT NULL DEFAULT '0',
  `avatar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

