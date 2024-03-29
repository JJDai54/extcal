-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Hôte : h2mysql12
-- Généré le :  Dim 02 fév. 2020 à 20:13
-- Version du serveur :  5.6.45-log
-- Version de PHP :  7.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `drrc_cds91700a`
--

-- --------------------------------------------------------

--
-- Structure de la table `x251_extcal_saints`
--

CREATE TABLE `x251_extcal_saints` (
  `saints_id` int(11) NOT NULL,
  `saints_month` int(11) NOT NULL,
  `saints_day` int(11) NOT NULL,
  `saints_name` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `x251_extcal_saints`
--
ALTER TABLE `x251_extcal_saints`
  ADD PRIMARY KEY (`saints_id`),
  ADD UNIQUE KEY `saints_month_day` (`saints_month`,`saints_day`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `x251_extcal_saints`
--
ALTER TABLE `x251_extcal_saints`
  MODIFY `saints_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
