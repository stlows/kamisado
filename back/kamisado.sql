-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mer. 05 fév. 2020 à 05:19
-- Version du serveur :  10.3.15-MariaDB
-- Version de PHP :  7.1.30

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

-- --------------------------------------------------------

--
-- Structure de la table `lobby`
--

CREATE TABLE `lobby` (
  `lobby_id` int(11) NOT NULL,
  `points_to_win` int(11) NOT NULL,
  `player_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `players`
--

CREATE TABLE `players` (
  `player_id` int(11) NOT NULL,
  `player_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `players`
--

INSERT INTO `players` (`player_id`, `player_name`) VALUES
(1, 'Vincent'),
(2, 'Stéphanie'),
(3, 'Charles'),
(4, 'Julie');

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
  `symbol` varchar(1) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  ADD KEY `game_id` (`game_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `games`
--
ALTER TABLE `games`
  MODIFY `game_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT pour la table `lobby`
--
ALTER TABLE `lobby`
  MODIFY `lobby_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `players`
--
ALTER TABLE `players`
  MODIFY `player_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `tiles`
--
ALTER TABLE `tiles`
  MODIFY `tile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT pour la table `towers`
--
ALTER TABLE `towers`
  MODIFY `tower_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=913;

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
  ADD CONSTRAINT `towers_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `games` (`game_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
