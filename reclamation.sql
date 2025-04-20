-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 18 avr. 2025 à 19:18
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
-- Base de données : `reclamation`
--

-- --------------------------------------------------------

--
-- Structure de la table `reclamtion`
--

CREATE TABLE `reclamtion` (
  `id_reclamation` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `tel` int(11) NOT NULL,
  `date_creation` datetime DEFAULT current_timestamp(),
  `etat` varchar(50) DEFAULT 'pending',
  `type_reclamation` varchar(50) NOT NULL,
  `evenement_concerne` varchar(50) NOT NULL,
  `description` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reclamtion`
--

INSERT INTO `reclamtion` (`id_reclamation`, `nom`, `email`, `tel`, `date_creation`, `etat`, `type_reclamation`, `evenement_concerne`, `description`) VALUES
(15, 'Ali Najjaa', 'dddddd@ffff.ff', 90040416, '2025-04-16 00:00:00', 'pending', 'remboursement', 'ete2025', 'sssssssssssssssssssssssssss'),
(16, 'Ali Najjaa', 'dddddd@ffff.ff', 90040416, '2025-04-16 00:00:00', 'repondu', 'accueil', 'printemps2025', 'ddddddddddddddddddddddddddddd'),
(17, 'djjjjjjjj', 'dddddd@ffff.ff', 30303030, '2025-04-16 00:00:00', 'pending', 'accueil', 'printemps2025', 'yyyy brooooooooooo'),
(18, 'dfsfbsf', 'najjaaali3@gmail.com', 33000000, '2025-04-17 00:00:00', 'pending', 'accueil', 'noel2024', 'fffffffffffffffffffffffffffffffffffffffffffffffffff');

-- --------------------------------------------------------

--
-- Structure de la table `reponse`
--

CREATE TABLE `reponse` (
  `id_reponse` int(11) NOT NULL,
  `id_reclamation` int(11) NOT NULL,
  `contenu` text NOT NULL,
  `date_reponse` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reponse`
--

INSERT INTO `reponse` (`id_reponse`, `id_reclamation`, `contenu`, `date_reponse`) VALUES
(28, 16, 'xxxxxxxxxxxxxxxxxxxxxxxxxxx', '2025-04-17 09:31:14');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `reclamtion`
--
ALTER TABLE `reclamtion`
  ADD PRIMARY KEY (`id_reclamation`);

--
-- Index pour la table `reponse`
--
ALTER TABLE `reponse`
  ADD PRIMARY KEY (`id_reponse`),
  ADD KEY `id_reclamation` (`id_reclamation`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `reclamtion`
--
ALTER TABLE `reclamtion`
  MODIFY `id_reclamation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `reponse`
--
ALTER TABLE `reponse`
  MODIFY `id_reponse` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `reponse`
--
ALTER TABLE `reponse`
  ADD CONSTRAINT `reponse_ibfk_1` FOREIGN KEY (`id_reclamation`) REFERENCES `reclamtion` (`id_reclamation`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
