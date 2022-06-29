-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mar. 21 juin 2022 à 16:11
-- Version du serveur :  8.0.29-0ubuntu0.20.04.3
-- Version de PHP : 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `Quizzeo`
--

-- --------------------------------------------------------

--
-- Structure de la table `authtokens`
--

CREATE TABLE `authtokens` (
  `user_id` int DEFAULT NULL,
  `user_tokens` varchar(255) DEFAULT NULL
);

--
-- Déchargement des données de la table `authtokens`
--

INSERT INTO `authtokens` (`user_id`, `user_tokens`) VALUES
(2, '971b3d40a9a4db15f99dae7a8c733bf8eed77f67'),
(1, 'b0f27460b4283788789a47a3c1dc33a391046af0');

-- --------------------------------------------------------

--
-- Structure de la table `questions`
--

CREATE TABLE `questions` (
  `id` int NOT NULL,
  `description` text,
  `level` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `user_id` int DEFAULT NULL
);

--
-- Déchargement des données de la table `questions`
--

INSERT INTO `questions` (`id`, `description`, `level`, `created_at`, `user_id`) VALUES
(1, 'Quelle est la capitale de la France ?', 3, '2022-06-20 22:04:21', 1),
(2, 'Quel est le plus haut sommet du Monde ?', 2, '2022-06-20 22:04:45', 1),
(3, 'Quelle est la capitale du Cameroun ?', 1, '2022-06-21 11:05:52', 1);

-- --------------------------------------------------------

--
-- Structure de la table `questionschoices`
--

CREATE TABLE `questionschoices` (
  `id` int NOT NULL,
  `description` text,
  `answer` enum('0','1') DEFAULT NULL,
  `question_id` int DEFAULT NULL
);

--
-- Déchargement des données de la table `questionschoices`
--

INSERT INTO `questionschoices` (`id`, `description`, `answer`, `question_id`) VALUES
(1, 'Mont Cameroun', '0', 2),
(2, 'Mont Everest', '1', 2),
(3, 'Mont Blanc', '0', 2),
(4, 'Mont Kilimanjaro', '0', 2),
(5, 'Saint Louis', '0', 1),
(6, 'Lyon', '0', 1),
(7, 'Paris', '1', 1),
(8, 'Marseilles', '0', 1),
(9, 'Douala', '0', 3),
(10, 'Yaoundé', '1', 3),
(11, 'Garoua', '0', 3),
(12, 'Mbouda', '0', 3);

-- --------------------------------------------------------

--
-- Structure de la table `quizz`
--

CREATE TABLE `quizz` (
  `id` int NOT NULL,
  `title` text,
  `level` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `user_id` int DEFAULT NULL
);

--
-- Déchargement des données de la table `quizz`
--

INSERT INTO `quizz` (`id`, `title`, `level`, `created_at`, `user_id`) VALUES
(1, 'Jeu de culture générale', 2, '2022-06-20 22:08:59', 1),
(2, 'Quizz de culture générale', 2, '2022-06-21 12:57:18', 1);

-- --------------------------------------------------------

--
-- Structure de la table `quizzquestions`
--

CREATE TABLE `quizzquestions` (
  `quizz_id` int DEFAULT NULL,
  `question_id` int DEFAULT NULL
);

--
-- Déchargement des données de la table `quizzquestions`
--

INSERT INTO `quizzquestions` (`quizz_id`, `question_id`) VALUES
(1, 2),
(1, 1),
(2, 2),
(2, 3);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `pseudo` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('ADMIN','QUIZZER','USER') DEFAULT NULL
);

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `pseudo`, `email`, `password`, `role`) VALUES
(1, 'Hanniel TSASSE', 'tatsabonghanniel@gmail.com', '123456', 'USER');

-- --------------------------------------------------------

--
-- Structure de la table `usersquizz`
--

CREATE TABLE `usersquizz` (
  `user_id` int DEFAULT NULL,
  `quizz_id` int DEFAULT NULL,
  `score` varchar(20) DEFAULT NULL
);

--
-- Déchargement des données de la table `usersquizz`
--

INSERT INTO `usersquizz` (`user_id`, `quizz_id`, `score`) VALUES
(1, 1, '18 / 20'),
(1, 1, '0 / 2'),
(1, 1, '0 / 2'),
(1, 1, '0 / 2'),
(1, 1, '0 / 2'),
(1, 1, '2 / 2'),
(1, 1, '2 / 2');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `questionschoices`
--
ALTER TABLE `questionschoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Index pour la table `quizz`
--
ALTER TABLE `quizz`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `quizzquestions`
--
ALTER TABLE `quizzquestions`
  ADD KEY `quizz_id` (`quizz_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `usersquizz`
--
ALTER TABLE `usersquizz`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `quizz_id` (`quizz_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `questionschoices`
--
ALTER TABLE `questionschoices`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `quizz`
--
ALTER TABLE `quizz`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `questionschoices`
--
ALTER TABLE `questionschoices`
  ADD CONSTRAINT `questionschoices_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`);

--
-- Contraintes pour la table `quizzquestions`
--
ALTER TABLE `quizzquestions`
  ADD CONSTRAINT `quizzquestions_ibfk_1` FOREIGN KEY (`quizz_id`) REFERENCES `quizz` (`id`),
  ADD CONSTRAINT `quizzquestions_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`);

--
-- Contraintes pour la table `usersquizz`
--
ALTER TABLE `usersquizz`
  ADD CONSTRAINT `usersquizz_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `usersquizz_ibfk_2` FOREIGN KEY (`quizz_id`) REFERENCES `quizz` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;