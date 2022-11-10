-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 10 nov. 2022 à 08:58
-- Version du serveur : 10.4.25-MariaDB
-- Version de PHP : 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `netvod`
--

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `role` int(11) NOT NULL DEFAULT 0,
  `email` varchar(256) NOT NULL,
  `passwd` varchar(256) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `id_genre` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`role`, `email`, `passwd`, `prenom`, `nom`, `id_genre`) VALUES
(1, 'Admin@gmail.com', '$2y$10$At6gQel6cBKzdTQiFtsx8..2q5JlN/7pwGa5tZrhLup.gDr9QqOIW', 'gr', 'rick', 1),
(0, 'test@gmail.com', '$2y$10$LAN0QgPsB7Rqkq0MkvKDRO45VWa66IqHAjZPoVFfpQmGpjdKriD56', '', '', 0),
(1, 'Beta@gmail.com', '$2y$10$w5sRo6eX3S8k6PAxrVDknOvgMwAFjrOMd0slV/1Rw9X23vwXrKIMe', '', 'Ogre', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
