-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  ven. 21 fév. 2020 à 21:27
-- Version du serveur :  10.4.6-MariaDB
-- Version de PHP :  7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `kamisado`
--

-- --------------------------------------------------------

--
-- Structure de la table `games`
--

CREATE TABLE `games` (
  `game_id` int(11) NOT NULL,
  `player_1_id` int(11) NOT NULL,
  `player_2_id` int(11) NOT NULL,
  `player_1_score` int(11) NOT NULL,
  `player_2_score` int(11) NOT NULL,
  `points_to_win` int(11) NOT NULL,
  `tower_id_to_move` int(11) DEFAULT NULL,
  `is_first_move` tinyint(1) NOT NULL,
  `turn` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `games`
--

INSERT INTO `games` (`game_id`, `player_1_id`, `player_2_id`, `player_1_score`, `player_2_score`, `points_to_win`, `tower_id_to_move`, `is_first_move`, `turn`) VALUES
(47, 7, 6, 0, 0, 3, NULL, 1, '7'),
(48, 6, 7, 0, 0, 3, NULL, 1, '6'),
(49, 5, 8, 0, 0, 3, NULL, 1, '5');

-- --------------------------------------------------------

--
-- Structure de la table `lobby`
--

CREATE TABLE `lobby` (
  `lobby_id` int(11) NOT NULL,
  `points_to_win` int(11) NOT NULL,
  `player_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `lobby`
--

INSERT INTO `lobby` (`lobby_id`, `points_to_win`, `player_id`) VALUES
(16, 3, 6),
(17, 3, 5);

-- --------------------------------------------------------

--
-- Structure de la table `players`
--

CREATE TABLE `players` (
  `player_id` int(11) NOT NULL,
  `player_name` varchar(20) NOT NULL,
  `google_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `players`
--

INSERT INTO `players` (`player_id`, `player_name`, `google_id`) VALUES
(1, 'Vincent', ''),
(2, 'Stéphanie', ''),
(3, 'Charles', ''),
(4, 'Julie', ''),
(5, 'test_0002', 'test_0002'),
(6, 'test_0003', 'test_0003'),
(7, 'test_0004', 'test_0004'),
(8, 'test_0001', 'test_0001');

-- --------------------------------------------------------

--
-- Structure de la table `tiles`
--

CREATE TABLE `tiles` (
  `tile_id` int(11) NOT NULL,
  `position_x` int(11) NOT NULL,
  `position_y` int(11) NOT NULL,
  `color` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `tiles`
--

INSERT INTO `tiles` (`tile_id`, `position_x`, `position_y`, `color`) VALUES
(1, 1, 1, 'orange'),
(2, 2, 1, 'blue'),
(3, 3, 1, 'indigo'),
(4, 4, 1, 'pink'),
(5, 5, 1, 'yellow'),
(6, 6, 1, 'red'),
(7, 7, 1, 'green'),
(8, 8, 1, 'brown'),
(9, 1, 2, 'red'),
(10, 2, 2, 'orange'),
(11, 3, 2, 'pink'),
(12, 4, 2, 'green'),
(13, 5, 2, 'blue'),
(14, 6, 2, 'yellow'),
(15, 7, 2, 'brown'),
(16, 8, 2, 'indigo'),
(17, 1, 3, 'green'),
(18, 2, 3, 'pink'),
(19, 3, 3, 'orange'),
(20, 4, 3, 'red'),
(21, 5, 3, 'indigo'),
(22, 6, 3, 'brown'),
(23, 7, 3, 'yellow'),
(24, 8, 3, 'blue'),
(25, 1, 4, 'pink'),
(26, 2, 4, 'indigo'),
(27, 3, 4, 'blue'),
(28, 4, 4, 'orange'),
(29, 5, 4, 'brown'),
(30, 6, 4, 'green'),
(31, 7, 4, 'red'),
(32, 8, 4, 'yellow'),
(33, 1, 5, 'yellow'),
(34, 2, 5, 'red'),
(35, 3, 5, 'green'),
(36, 4, 5, 'brown'),
(37, 5, 5, 'orange'),
(38, 6, 5, 'blue'),
(39, 7, 5, 'indigo'),
(40, 8, 5, 'pink'),
(41, 1, 6, 'blue'),
(42, 2, 6, 'yellow'),
(43, 3, 6, 'brown'),
(44, 4, 6, 'indigo'),
(45, 5, 6, 'red'),
(46, 6, 6, 'orange'),
(47, 7, 6, 'pink'),
(48, 8, 6, 'green'),
(49, 1, 7, 'indigo'),
(50, 2, 7, 'brown'),
(51, 3, 7, 'yellow'),
(52, 4, 7, 'blue'),
(53, 5, 7, 'green'),
(54, 6, 7, 'pink'),
(55, 7, 7, 'orange'),
(56, 8, 7, 'red'),
(57, 1, 8, 'brown'),
(58, 2, 8, 'green'),
(59, 3, 8, 'red'),
(60, 4, 8, 'yellow'),
(61, 5, 8, 'pink'),
(62, 6, 8, 'indigo'),
(63, 7, 8, 'blue'),
(64, 8, 8, 'orange');

-- --------------------------------------------------------

--
-- Structure de la table `towers`
--

CREATE TABLE `towers` (
  `tower_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `tower_color` varchar(10) NOT NULL,
  `player_color` varchar(10) NOT NULL,
  `sumo` int(11) NOT NULL,
  `position_x` int(11) NOT NULL,
  `position_y` int(11) NOT NULL,
  `symbol` varchar(1) CHARACTER SET utf8 NOT NULL,
  `player_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `towers`
--

INSERT INTO `towers` (`tower_id`, `game_id`, `tower_color`, `player_color`, `sumo`, `position_x`, `position_y`, `symbol`, `player_id`) VALUES
(977, 47, 'orange', 'white', 0, 1, 4, '주', 7),
(978, 47, 'blue', 'white', 0, 2, 1, '푸', 7),
(979, 47, 'indigo', 'white', 0, 3, 1, '남', 7),
(980, 47, 'pink', 'white', 0, 4, 1, '담', 7),
(981, 47, 'yellow', 'white', 0, 5, 1, '노', 7),
(982, 47, 'red', 'white', 0, 6, 1, '빨', 7),
(983, 47, 'green', 'white', 0, 7, 1, '녹', 7),
(984, 47, 'brown', 'white', 0, 8, 1, '갈', 7),
(985, 47, 'brown', 'black', 0, 1, 8, '갈', 6),
(986, 47, 'green', 'black', 0, 2, 8, '녹', 6),
(987, 47, 'red', 'black', 0, 3, 8, '빨', 6),
(988, 47, 'yellow', 'black', 0, 4, 8, '노', 6),
(989, 47, 'pink', 'black', 0, 5, 8, '담', 6),
(990, 47, 'indigo', 'black', 0, 6, 8, '남', 6),
(991, 47, 'blue', 'black', 0, 7, 8, '푸', 6),
(992, 47, 'orange', 'black', 0, 8, 8, '주', 6),
(993, 48, 'orange', 'white', 0, 1, 1, '주', 6),
(994, 48, 'blue', 'white', 0, 2, 1, '푸', 6),
(995, 48, 'indigo', 'white', 0, 3, 1, '남', 6),
(996, 48, 'pink', 'white', 0, 4, 1, '담', 6),
(997, 48, 'yellow', 'white', 0, 5, 1, '노', 6),
(998, 48, 'red', 'white', 0, 6, 1, '빨', 6),
(999, 48, 'green', 'white', 0, 7, 1, '녹', 6),
(1000, 48, 'brown', 'white', 0, 8, 1, '갈', 6),
(1001, 48, 'brown', 'black', 0, 1, 8, '갈', 7),
(1002, 48, 'green', 'black', 0, 2, 8, '녹', 7),
(1003, 48, 'red', 'black', 0, 3, 8, '빨', 7),
(1004, 48, 'yellow', 'black', 0, 4, 8, '노', 7),
(1005, 48, 'pink', 'black', 0, 5, 8, '담', 7),
(1006, 48, 'indigo', 'black', 0, 6, 8, '남', 7),
(1007, 48, 'blue', 'black', 0, 7, 8, '푸', 7),
(1008, 48, 'orange', 'black', 0, 8, 8, '주', 7),
(1009, 49, 'orange', 'white', 0, 1, 1, '주', 5),
(1010, 49, 'blue', 'white', 0, 2, 1, '푸', 5),
(1011, 49, 'indigo', 'white', 0, 3, 1, '남', 5),
(1012, 49, 'pink', 'white', 0, 4, 1, '담', 5),
(1013, 49, 'yellow', 'white', 0, 5, 1, '노', 5),
(1014, 49, 'red', 'white', 0, 6, 1, '빨', 5),
(1015, 49, 'green', 'white', 0, 7, 1, '녹', 5),
(1016, 49, 'brown', 'white', 0, 8, 1, '갈', 5),
(1017, 49, 'brown', 'black', 0, 1, 8, '갈', 8),
(1018, 49, 'green', 'black', 0, 2, 8, '녹', 8),
(1019, 49, 'red', 'black', 0, 3, 8, '빨', 8),
(1020, 49, 'yellow', 'black', 0, 4, 8, '노', 8),
(1021, 49, 'pink', 'black', 0, 5, 8, '담', 8),
(1022, 49, 'indigo', 'black', 0, 6, 8, '남', 8),
(1023, 49, 'blue', 'black', 0, 7, 8, '푸', 8),
(1024, 49, 'orange', 'black', 0, 8, 8, '주', 8);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`game_id`),
  ADD KEY `player_1_id` (`player_1_id`),
  ADD KEY `player_2_id` (`player_2_id`),
  ADD KEY `tower_id_to_move` (`tower_id_to_move`);

--
-- Index pour la table `lobby`
--
ALTER TABLE `lobby`
  ADD PRIMARY KEY (`lobby_id`),
  ADD KEY `player_id` (`player_id`);

--
-- Index pour la table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`player_id`);

--
-- Index pour la table `tiles`
--
ALTER TABLE `tiles`
  ADD PRIMARY KEY (`tile_id`);

--
-- Index pour la table `towers`
--
ALTER TABLE `towers`
  ADD PRIMARY KEY (`tower_id`),
  ADD KEY `game_id` (`game_id`),
  ADD KEY `player_id` (`player_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `games`
--
ALTER TABLE `games`
  MODIFY `game_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT pour la table `lobby`
--
ALTER TABLE `lobby`
  MODIFY `lobby_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `players`
--
ALTER TABLE `players`
  MODIFY `player_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `tiles`
--
ALTER TABLE `tiles`
  MODIFY `tile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT pour la table `towers`
--
ALTER TABLE `towers`
  MODIFY `tower_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1025;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `games_ibfk_1` FOREIGN KEY (`player_1_id`) REFERENCES `players` (`player_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `games_ibfk_2` FOREIGN KEY (`player_2_id`) REFERENCES `players` (`player_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `games_ibfk_3` FOREIGN KEY (`tower_id_to_move`) REFERENCES `towers` (`tower_id`);

--
-- Contraintes pour la table `lobby`
--
ALTER TABLE `lobby`
  ADD CONSTRAINT `lobby_ibfk_1` FOREIGN KEY (`player_id`) REFERENCES `players` (`player_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `towers`
--
ALTER TABLE `towers`
  ADD CONSTRAINT `towers_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `games` (`game_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `towers_ibfk_2` FOREIGN KEY (`player_id`) REFERENCES `players` (`player_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
