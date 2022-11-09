-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 09 nov. 2022 à 10:59
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
  `role` int(11) NOT NULL,
  `email` varchar(256) NOT NULL,
  `passwd` varchar(256) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `nom` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`role`, `email`, `passwd`, `prenom`, `nom`) VALUES
(0, 'huihui@gmail.com', '$2y$10$zEg8H0HVarmkYCsXoxse4O6v5puk2o7ITApew9kGBB.1K35R7zmW6', '', ''),
(0, 'Lga@gmail.com', '$2y$10$Hgyj8stPNUY14Dzk3xvdZOCu4bl1JekiICYW.1UtMy326wuSctcga', '', ''),
(0, 'ty@gmail.com', '$2y$10$9OuKmJN0KnzI.m6yoW7XjOl5lQAGMYfSieq5hu7CDgkNBhgngk.1C', '', ''),
(0, 'ui@gmail.com', '$2y$10$bxl82BurfVxGlbsqhsN8I.bpP0sbhbJzZXgBKtpkVyQmjO1er.ksC', '', ''),
(0, 'tya@gmail.com', '$2y$10$DUkaDGHql5Qw2qkNp0qpUein0a1Ol2tid2WwOGCUSRPp4xj0RKPcu', '', ''),
(0, 'tyaa@gmail.com', '$2y$10$piy4hXQRP62aKv2T98yxN.26bThXLl3QPbS1wJaRma7ba8xYdf5uW', '', ''),
(0, 'uai@gmail.com', '$2y$10$6HlymE0PbvIVjzUvm1MEKuikkNOxOwxJ9h95XS3vch5T.kh6yiyZm', '', ''),
(0, 'uaia@gmail.com', '$2y$10$ORhTlOclrd21JS.9/EiKTOQTjtZSHNJTEQv9.6hMnp.EObYVuptce', '', ''),
(0, 'uaie@gmail.com', '$2y$10$IkPgQFKh7nYhy.yJybi3deeZ3RY.q4nqWqYzzn7C2nJLMY7wyUCSS', '', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
