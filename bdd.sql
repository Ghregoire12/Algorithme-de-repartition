-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : sql212.epizy.com
-- Généré le :  sam. 26 juin 2021 à 10:09
-- Version du serveur :  5.6.48-88.0
-- Version de PHP :  7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `epiz_27920234_cr3adivity`
--

-- --------------------------------------------------------

--
-- Structure de la table `inscriptions_db`
--

CREATE TABLE `inscriptions_db` (
  `inscription_id` int(11) NOT NULL,
  `inscription_lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `inscription_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `inscription_school` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `inscription_choice` tinytext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `inscriptions_db`
--
--
-- Index pour les tables déchargées
--

--
-- Index pour la table `inscriptions_db`
--
ALTER TABLE `inscriptions_db`
  ADD PRIMARY KEY (`inscription_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `inscriptions_db`
--
ALTER TABLE `inscriptions_db`
  MODIFY `inscription_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
