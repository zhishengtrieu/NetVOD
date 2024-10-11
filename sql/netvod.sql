-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 10 oct. 2024 à 15:55
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

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
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `email` varchar(25) NOT NULL,
  `serie_id` int NOT NULL,
  `commentaire` text NOT NULL,
  `note` double(2,1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `episode`
--

DROP TABLE IF EXISTS `episode`;
CREATE TABLE IF NOT EXISTS `episode` (
  `id` int NOT NULL AUTO_INCREMENT,
  `numero` int NOT NULL DEFAULT '1',
  `titre` varchar(128) NOT NULL,
  `resume` text,
  `duree` int NOT NULL DEFAULT '0',
  `file` varchar(256) DEFAULT NULL,
  `img` varchar(256) DEFAULT NULL,
  `serie_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `episode`
--

INSERT INTO `episode` (`id`, `numero`, `titre`, `resume`, `duree`, `file`, `img`, `serie_id`) VALUES
(1, 1, 'Le lac', 'Le lac se révolte ', 8, 'rickroll.mp4', NULL, 1),
(2, 2, 'Le lac : les mystères de l\'eau trouble', 'Un grand mystère, l\'eau du lac est trouble. Jack trouvera-t-il la solution ?', 8, 'rickroll.mp4', NULL, 1),
(3, 3, 'Le lac : les mystères de l\'eau sale', 'Un grand mystère, l\'eau du lac est sale. Jack trouvera-t-il la solution ?', 8, 'rickroll.mp4', NULL, 1),
(4, 4, 'Le lac : les mystères de l\'eau chaude', 'Un grand mystère, l\'eau du lac est chaude. Jack trouvera-t-il la solution ?', 8, 'rickroll.mp4', NULL, 1),
(5, 5, 'Le lac : les mystères de l\'eau froide', 'Un grand mystère, l\'eau du lac est froide. Jack trouvera-t-il la solution ?', 8, 'lake.mp4', NULL, 1),
(6, 1, 'Eau calme', 'L\'eau coule tranquillement au fil du temps.', 15, 'water.mp4', NULL, 2),
(7, 2, 'Eau calme 2', 'Le temps a passé, l\'eau coule toujours tranquillement.', 15, 'water.mp4', NULL, 2),
(8, 3, 'Eau moins calme', 'Le temps des tourments est pour bientôt, l\'eau s\'agite et le temps passe.', 15, 'water.mp4', NULL, 2),
(9, 4, 'la tempête', 'C\'est la tempête, l\'eau est en pleine agitation. Le temps passe mais rien n\'y fait. Jack trouvera-t-il la solution ?', 15, 'water.mp4', NULL, 2),
(10, 5, 'Le calme après la tempête', 'La tempête est passée, l\'eau retrouve son calme. Le temps passe et Jack part en vacances.', 15, 'water.mp4', NULL, 2),
(11, 1, 'les chevaux s\'amusent', 'Les chevaux s\'amusent bien, ils ont apportés les raquettes pour faire un tournoi de badmington.', 7, 'horses.mp4', NULL, 3),
(12, 2, 'les chevals fous', '- Oh regarde, des beaux chevals !!\r\n- non, des chevaux, des CHEVAUX !\r\n- oh, bin ça alors, ça ressemble drôlement à des chevals ?!!?', 7, 'horses.mp4', NULL, 3),
(13, 3, 'les chevaux de l\'étoile noire', 'Les chevaux de l\'Etoile Noire débrquent sur terre et mangent toute l\'herbe !', 7, 'horses.mp4', NULL, 3),
(14, 1, 'Tous à la plage', 'C\'est l\'été, tous à la plage pour profiter du soleil et de la mer.', 18, 'beach.mp4', NULL, 4),
(15, 2, 'La plage le soir', 'A la plage le soir, il n\'y a personne, c\'est tout calme', 18, 'beach.mp4', NULL, 4),
(16, 3, 'La plage le matin', 'A la plage le matin, il n\'y a personne non plus, c\'est tout calme et le jour se lève.', 18, 'beach.mp4', NULL, 4),
(17, 1, 'champion de surf', 'Jack fait du surf le matin, le midi le soir, même la nuit. C\'est un pro.', 11, 'surf.mp4', NULL, 5),
(18, 2, 'surf détective', 'Une planche de surf a été volée. Jack mène l\'enquête. Parviendra-t-il à confondre le brigand ?', 11, 'surf.mp4', NULL, 5),
(19, 3, 'surf amitié', 'En fait la planche n\'avait pas été volée, c\'est Jim, le meilleur ami de Jack, qui lui avait fait une blague. Les deux amis partagent une menthe à l\'eau pour célébrer leur amitié sans faille.', 11, 'surf.mp4', NULL, 5),
(20, 1, 'Ça roule, ça roule', 'Ça roule, ça roule toute la nuit. Jack fonce dans sa camionnette pour rejoindre le spot de surf.', 27, 'cars-by-night.mp4', NULL, 6),
(21, 2, 'Ça roule, ça roule toujours', 'Ça roule la nuit, comme chaque nuit. Jim fonce avec son taxi, pour rejoindre Jack à la plage. De l\'eau a coulé sous les ponts. Le mystère du Lac trouve sa solution alors que les chevaux sont de retour après une virée sur l\'Etoile Noire.', 27, 'cars-by-night.mp4', NULL, 6);

-- --------------------------------------------------------

--
-- Structure de la table `genre`
--

DROP TABLE IF EXISTS `genre`;
CREATE TABLE IF NOT EXISTS `genre` (
  `id_genre` int NOT NULL,
  `libelle_genre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `genre`
--

INSERT INTO `genre` (`id_genre`, `libelle_genre`) VALUES
(1, 'action'),
(2, 'thriller'),
(3, 'anime'),
(4, 'comedie'),
(5, 'romance'),
(6, 'horreur');

-- --------------------------------------------------------

--
-- Structure de la table `public`
--

DROP TABLE IF EXISTS `public`;
CREATE TABLE IF NOT EXISTS `public` (
  `id_public` int NOT NULL,
  `libelle_public` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `public`
--

INSERT INTO `public` (`id_public`, `libelle_public`) VALUES
(1, 'enfants'),
(2, 'adolescents'),
(3, 'familles'),
(4, 'adultes');

-- --------------------------------------------------------

--
-- Structure de la table `serie`
--

DROP TABLE IF EXISTS `serie`;
CREATE TABLE IF NOT EXISTS `serie` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(128) NOT NULL,
  `descriptif` text NOT NULL,
  `img` varchar(256) NOT NULL,
  `annee` int NOT NULL,
  `date_ajout` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `serie`
--

INSERT INTO `serie` (`id`, `titre`, `descriptif`, `img`, `annee`, `date_ajout`) VALUES
(1, 'Le lac aux mystères', 'C\'est l\'histoire d\'un lac mystérieux et plein de surprises. La série, bluffante et haletante, nous entraine dans un labyrinthe d\'intrigues époustouflantes. A ne rater sous aucun prétexte !', 'lake.png', 2020, '2022-10-30'),
(2, 'L\'eau a coulé', 'Une série nostalgique qui nous invite à revisiter notre passé et à se remémorer tout ce qui s\'est passé depuis que tant d\'eau a coulé sous les ponts.', 'water.png', 1907, '2022-10-29'),
(3, 'Chevaux fous', 'Une série sur la vie des chevals sauvages en liberté. Décoiffante.', 'horses.png', 2017, '2022-10-31'),
(4, 'A la plage', 'Le succès de l\'été 2021, à regarder sans modération et entre amis.', 'beach.png', 2021, '2022-11-04'),
(5, 'Champion', 'La vie trépidante de deux champions de surf, passionnés dès leur plus jeune age. Ils consacrent leur vie à ce sport. ', 'surf.png', 2022, '2022-11-03'),
(6, 'Une ville la nuit', 'C\'est beau une ville la nuit, avec toutes ces voitures qui passent et qui repassent. La série suit un livreur, un chauffeur de taxi, et un insomniaque. Tous parcourent la grande ville une fois la nuit venue, au volant de leur véhicule.', 'cars-by-night.png', 2017, '2022-10-31');

-- --------------------------------------------------------

--
-- Structure de la table `serie_en_cours`
--

DROP TABLE IF EXISTS `serie_en_cours`;
CREATE TABLE IF NOT EXISTS `serie_en_cours` (
  `email` varchar(256) NOT NULL,
  `serie_id` int NOT NULL,
  `episode_id` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `serie_en_cours`
--

INSERT INTO `serie_en_cours` (`email`, `serie_id`, `episode_id`) VALUES
('admin@gmail.com', 1, 1),
('admin@gmail.com', 1, 1),
('dev@mail.com', 1, 2),
('dev@mail.com', 4, 15);

-- --------------------------------------------------------

--
-- Structure de la table `serie_favoris`
--

DROP TABLE IF EXISTS `serie_favoris`;
CREATE TABLE IF NOT EXISTS `serie_favoris` (
  `email` varchar(256) NOT NULL,
  `serie_id` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `serie_genre`
--

DROP TABLE IF EXISTS `serie_genre`;
CREATE TABLE IF NOT EXISTS `serie_genre` (
  `id_serie` int NOT NULL,
  `id_genre` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `serie_genre`
--

INSERT INTO `serie_genre` (`id_serie`, `id_genre`) VALUES
(1, 1),
(1, 3),
(2, 4),
(2, 5),
(3, 6),
(4, 1),
(4, 2),
(5, 1),
(5, 2),
(5, 6),
(6, 4),
(6, 5);

-- --------------------------------------------------------

--
-- Structure de la table `serie_public`
--

DROP TABLE IF EXISTS `serie_public`;
CREATE TABLE IF NOT EXISTS `serie_public` (
  `id_serie` int NOT NULL,
  `id_public` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `serie_public`
--

INSERT INTO `serie_public` (`id_serie`, `id_public`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 2),
(2, 4),
(3, 4),
(4, 2),
(4, 4),
(5, 4),
(6, 1),
(6, 2),
(6, 3),
(6, 4);

-- --------------------------------------------------------

--
-- Structure de la table `serie_visionnees`
--

DROP TABLE IF EXISTS `serie_visionnees`;
CREATE TABLE IF NOT EXISTS `serie_visionnees` (
  `email` varchar(256) NOT NULL,
  `serie_id` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `role` int NOT NULL DEFAULT '0',
  `email` varchar(256) NOT NULL,
  `passwd` varchar(256) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `id_genre` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
