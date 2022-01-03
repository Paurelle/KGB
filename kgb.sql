-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 03 jan. 2022 à 18:43
-- Version du serveur : 10.4.21-MariaDB
-- Version de PHP : 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `kgb`
--

-- --------------------------------------------------------

--
-- Structure de la table `acquis`
--

CREATE TABLE `acquis` (
  `id_agent` int(11) NOT NULL,
  `id_specialite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `acquis`
--

INSERT INTO `acquis` (`id_agent`, `id_specialite`) VALUES
(1, 3),
(1, 4),
(2, 1),
(2, 3),
(2, 7),
(7, 1),
(7, 5);

-- --------------------------------------------------------

--
-- Structure de la table `administrateurs`
--

CREATE TABLE `administrateurs` (
  `id_admin` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mdp` varchar(128) NOT NULL,
  `date_creation` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `administrateurs`
--

INSERT INTO `administrateurs` (`id_admin`, `nom`, `prenom`, `email`, `mdp`, `date_creation`) VALUES
(7, 'Poutine', 'Vladimir', 'Vladimir-Poutine@gmail.com', '$2y$10$hLcrXEku86ENfyI1fGlmgO7.nd34u7Ind6LF9/sWTwZbtvfA14JUe', '2022-01-03');

-- --------------------------------------------------------

--
-- Structure de la table `agents`
--

CREATE TABLE `agents` (
  `id_agent` int(11) NOT NULL,
  `id_pays` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `date_naissance` date NOT NULL,
  `code_identification` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `agents`
--

INSERT INTO `agents` (`id_agent`, `id_pays`, `nom`, `prenom`, `date_naissance`, `code_identification`) VALUES
(1, 3, 'John', 'Renauds', '1982-09-02', 545241),
(2, 4, 'Dmitri', 'Basilovitch', '1979-06-16', 545228),
(7, 3, 'Bond', 'James', '1953-06-18', 700);

-- --------------------------------------------------------

--
-- Structure de la table `aide`
--

CREATE TABLE `aide` (
  `id_contact` int(11) NOT NULL,
  `id_mission` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `aide`
--

INSERT INTO `aide` (`id_contact`, `id_mission`) VALUES
(1, 25);

-- --------------------------------------------------------

--
-- Structure de la table `cibles`
--

CREATE TABLE `cibles` (
  `id_cible` int(11) NOT NULL,
  `id_pays` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `date_naissance` date NOT NULL,
  `nom_code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `cibles`
--

INSERT INTO `cibles` (`id_cible`, `id_pays`, `nom`, `prenom`, `date_naissance`, `nom_code`) VALUES
(1, 3, 'John', 'Abrame', '1980-11-13', 'Hat'),
(3, 2, 'Schmidt', 'Léo', '1982-06-18', 'Master');

-- --------------------------------------------------------

--
-- Structure de la table `contacts`
--

CREATE TABLE `contacts` (
  `id_contact` int(11) NOT NULL,
  `id_pays` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `date_naissance` date NOT NULL,
  `nom_code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `contacts`
--

INSERT INTO `contacts` (`id_contact`, `id_pays`, `nom`, `prenom`, `date_naissance`, `nom_code`) VALUES
(1, 2, 'Jäger', 'Marius', '2002-09-03', 'Gunter'),
(2, 1, 'Michel', 'Money', '2012-12-06', 'la baguette'),
(5, 3, 'Charlie', 'john', '1992-06-19', 'Sprin');

-- --------------------------------------------------------

--
-- Structure de la table `deploiement`
--

CREATE TABLE `deploiement` (
  `id_agent` int(11) NOT NULL,
  `id_mission` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `deploiement`
--

INSERT INTO `deploiement` (`id_agent`, `id_mission`) VALUES
(2, 25),
(7, 25);

-- --------------------------------------------------------

--
-- Structure de la table `missions`
--

CREATE TABLE `missions` (
  `id_mission` int(11) NOT NULL,
  `id_pays` int(11) NOT NULL,
  `id_statut` int(11) NOT NULL,
  `id_type_mission` int(11) NOT NULL,
  `id_specialite` int(11) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `nom_code` varchar(50) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `missions`
--

INSERT INTO `missions` (`id_mission`, `id_pays`, `id_statut`, `id_type_mission`, `id_specialite`, `titre`, `description`, `nom_code`, `date_debut`, `date_fin`) VALUES
(25, 2, 1, 2, 3, 'Elimination of the Master', 'Eliminate the Master without being spotted', 'Dead master', '2021-12-27', '2022-01-15');

-- --------------------------------------------------------

--
-- Structure de la table `pays`
--

CREATE TABLE `pays` (
  `id_pays` int(11) NOT NULL,
  `pays` varchar(100) NOT NULL,
  `nationalite` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `pays`
--

INSERT INTO `pays` (`id_pays`, `pays`, `nationalite`) VALUES
(1, 'France', 'français'),
(2, 'Allemagne', 'allemande'),
(3, 'Angleterre', 'anglais'),
(4, 'Russie', 'russe'),
(5, 'Pologne', 'polonaise'),
(6, 'Suisse', 'suisse');

-- --------------------------------------------------------

--
-- Structure de la table `planques`
--

CREATE TABLE `planques` (
  `id_planque` int(11) NOT NULL,
  `id_pays` int(11) NOT NULL,
  `code` int(11) NOT NULL,
  `adresse` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `planques`
--

INSERT INTO `planques` (`id_planque`, `id_pays`, `code`, `adresse`, `type`) VALUES
(1, 1, 55867, '8 pearl street', 'House'),
(2, 2, 56487, '9 german street', 'Tower'),
(4, 3, 548450, '5 fish street', 'Boat');

-- --------------------------------------------------------

--
-- Structure de la table `specialites`
--

CREATE TABLE `specialites` (
  `id_specialite` int(11) NOT NULL,
  `specialite` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `specialites`
--

INSERT INTO `specialites` (`id_specialite`, `specialite`) VALUES
(1, 'Spying'),
(2, 'hack'),
(3, 'Elimination'),
(4, 'surveillance'),
(5, 'Against espionage'),
(7, 'Poisoning');

-- --------------------------------------------------------

--
-- Structure de la table `statuts`
--

CREATE TABLE `statuts` (
  `id_statut` int(11) NOT NULL,
  `statut` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `statuts`
--

INSERT INTO `statuts` (`id_statut`, `statut`) VALUES
(1, 'Preperation'),
(2, 'In progress'),
(3, 'Completed'),
(4, 'Failure');

-- --------------------------------------------------------

--
-- Structure de la table `type_missions`
--

CREATE TABLE `type_missions` (
  `id_type_mission` int(11) NOT NULL,
  `type_mission` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `type_missions`
--

INSERT INTO `type_missions` (`id_type_mission`, `type_mission`) VALUES
(1, 'Monitoring'),
(2, 'Murder'),
(3, 'Infiltration');

-- --------------------------------------------------------

--
-- Structure de la table `utilise`
--

CREATE TABLE `utilise` (
  `id_planque` int(11) NOT NULL,
  `id_mission` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `utilise`
--

INSERT INTO `utilise` (`id_planque`, `id_mission`) VALUES
(2, 25);

-- --------------------------------------------------------

--
-- Structure de la table `vise`
--

CREATE TABLE `vise` (
  `id_cible` int(11) NOT NULL,
  `id_mission` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `vise`
--

INSERT INTO `vise` (`id_cible`, `id_mission`) VALUES
(3, 25);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `acquis`
--
ALTER TABLE `acquis`
  ADD PRIMARY KEY (`id_agent`,`id_specialite`),
  ADD KEY `id_specialite` (`id_specialite`);

--
-- Index pour la table `administrateurs`
--
ALTER TABLE `administrateurs`
  ADD PRIMARY KEY (`id_admin`);

--
-- Index pour la table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`id_agent`),
  ADD KEY `id_pays` (`id_pays`);

--
-- Index pour la table `aide`
--
ALTER TABLE `aide`
  ADD PRIMARY KEY (`id_contact`,`id_mission`),
  ADD KEY `id_mission` (`id_mission`);

--
-- Index pour la table `cibles`
--
ALTER TABLE `cibles`
  ADD PRIMARY KEY (`id_cible`),
  ADD KEY `id_pays` (`id_pays`);

--
-- Index pour la table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id_contact`),
  ADD KEY `id_pays` (`id_pays`);

--
-- Index pour la table `deploiement`
--
ALTER TABLE `deploiement`
  ADD PRIMARY KEY (`id_agent`,`id_mission`),
  ADD KEY `id_mission` (`id_mission`);

--
-- Index pour la table `missions`
--
ALTER TABLE `missions`
  ADD PRIMARY KEY (`id_mission`),
  ADD KEY `id_pays` (`id_pays`),
  ADD KEY `id_statut` (`id_statut`),
  ADD KEY `id_type_mission` (`id_type_mission`),
  ADD KEY `id_specialite` (`id_specialite`);

--
-- Index pour la table `pays`
--
ALTER TABLE `pays`
  ADD PRIMARY KEY (`id_pays`);

--
-- Index pour la table `planques`
--
ALTER TABLE `planques`
  ADD PRIMARY KEY (`id_planque`),
  ADD KEY `id_pays` (`id_pays`);

--
-- Index pour la table `specialites`
--
ALTER TABLE `specialites`
  ADD PRIMARY KEY (`id_specialite`);

--
-- Index pour la table `statuts`
--
ALTER TABLE `statuts`
  ADD PRIMARY KEY (`id_statut`);

--
-- Index pour la table `type_missions`
--
ALTER TABLE `type_missions`
  ADD PRIMARY KEY (`id_type_mission`);

--
-- Index pour la table `utilise`
--
ALTER TABLE `utilise`
  ADD PRIMARY KEY (`id_planque`,`id_mission`),
  ADD KEY `id_mission` (`id_mission`);

--
-- Index pour la table `vise`
--
ALTER TABLE `vise`
  ADD PRIMARY KEY (`id_cible`,`id_mission`),
  ADD KEY `id_mission` (`id_mission`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `administrateurs`
--
ALTER TABLE `administrateurs`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `agents`
--
ALTER TABLE `agents`
  MODIFY `id_agent` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `cibles`
--
ALTER TABLE `cibles`
  MODIFY `id_cible` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id_contact` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `missions`
--
ALTER TABLE `missions`
  MODIFY `id_mission` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `pays`
--
ALTER TABLE `pays`
  MODIFY `id_pays` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `planques`
--
ALTER TABLE `planques`
  MODIFY `id_planque` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `specialites`
--
ALTER TABLE `specialites`
  MODIFY `id_specialite` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `statuts`
--
ALTER TABLE `statuts`
  MODIFY `id_statut` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `type_missions`
--
ALTER TABLE `type_missions`
  MODIFY `id_type_mission` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `acquis`
--
ALTER TABLE `acquis`
  ADD CONSTRAINT `acquis_ibfk_1` FOREIGN KEY (`id_agent`) REFERENCES `agents` (`id_agent`),
  ADD CONSTRAINT `acquis_ibfk_2` FOREIGN KEY (`id_specialite`) REFERENCES `specialites` (`id_specialite`);

--
-- Contraintes pour la table `agents`
--
ALTER TABLE `agents`
  ADD CONSTRAINT `agents_ibfk_1` FOREIGN KEY (`id_pays`) REFERENCES `pays` (`id_pays`);

--
-- Contraintes pour la table `aide`
--
ALTER TABLE `aide`
  ADD CONSTRAINT `aide_ibfk_1` FOREIGN KEY (`id_contact`) REFERENCES `contacts` (`id_contact`),
  ADD CONSTRAINT `aide_ibfk_2` FOREIGN KEY (`id_mission`) REFERENCES `missions` (`id_mission`);

--
-- Contraintes pour la table `cibles`
--
ALTER TABLE `cibles`
  ADD CONSTRAINT `cibles_ibfk_1` FOREIGN KEY (`id_pays`) REFERENCES `pays` (`id_pays`);

--
-- Contraintes pour la table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_ibfk_1` FOREIGN KEY (`id_pays`) REFERENCES `pays` (`id_pays`);

--
-- Contraintes pour la table `deploiement`
--
ALTER TABLE `deploiement`
  ADD CONSTRAINT `deploiement_ibfk_1` FOREIGN KEY (`id_agent`) REFERENCES `agents` (`id_agent`),
  ADD CONSTRAINT `deploiement_ibfk_2` FOREIGN KEY (`id_mission`) REFERENCES `missions` (`id_mission`);

--
-- Contraintes pour la table `missions`
--
ALTER TABLE `missions`
  ADD CONSTRAINT `missions_ibfk_1` FOREIGN KEY (`id_pays`) REFERENCES `pays` (`id_pays`),
  ADD CONSTRAINT `missions_ibfk_2` FOREIGN KEY (`id_statut`) REFERENCES `statuts` (`id_statut`),
  ADD CONSTRAINT `missions_ibfk_3` FOREIGN KEY (`id_type_mission`) REFERENCES `type_missions` (`id_type_mission`),
  ADD CONSTRAINT `missions_ibfk_4` FOREIGN KEY (`id_specialite`) REFERENCES `specialites` (`id_specialite`);

--
-- Contraintes pour la table `planques`
--
ALTER TABLE `planques`
  ADD CONSTRAINT `planques_ibfk_1` FOREIGN KEY (`id_pays`) REFERENCES `pays` (`id_pays`);

--
-- Contraintes pour la table `utilise`
--
ALTER TABLE `utilise`
  ADD CONSTRAINT `utilise_ibfk_1` FOREIGN KEY (`id_planque`) REFERENCES `planques` (`id_planque`),
  ADD CONSTRAINT `utilise_ibfk_2` FOREIGN KEY (`id_mission`) REFERENCES `missions` (`id_mission`);

--
-- Contraintes pour la table `vise`
--
ALTER TABLE `vise`
  ADD CONSTRAINT `vise_ibfk_1` FOREIGN KEY (`id_cible`) REFERENCES `cibles` (`id_cible`),
  ADD CONSTRAINT `vise_ibfk_2` FOREIGN KEY (`id_mission`) REFERENCES `missions` (`id_mission`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
