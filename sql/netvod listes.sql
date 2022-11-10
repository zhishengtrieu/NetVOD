-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 10, 2022 at 02:44 PM
-- Server version: 5.7.31
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `netvod`
--

-- --------------------------------------------------------

--
-- Table structure for table `serie_en_cours`
--

DROP TABLE IF EXISTS `serie_en_cours`;
CREATE TABLE IF NOT EXISTS `serie_en_cours` (
  `email` varchar(256) NOT NULL,
  `serie_id` int(2) NOT NULL,
  `episode_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `serie_en_cours`
--

INSERT INTO `serie_en_cours` (`email`, `serie_id`, `episode_id`) VALUES
('admin@gmail.com', 1, 1),
('admin@gmail.com', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `serie_favoris`
--

DROP TABLE IF EXISTS `serie_favoris`;
CREATE TABLE IF NOT EXISTS `serie_favoris` (
  `email` varchar(256) NOT NULL,
  `serie_id` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `serie_visonnees`
--

DROP TABLE IF EXISTS `serie_visionnees`;
CREATE TABLE IF NOT EXISTS `serie_visonnees` (
  `email` varchar(256) NOT NULL,
  `serie_id` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
