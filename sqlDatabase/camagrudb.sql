-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 08 juin 2020 à 19:19
-- Version du serveur :  10.4.11-MariaDB
-- Version de PHP : 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `camagrudb`
--

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `idComment` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idImage` varchar(70) NOT NULL,
  `commentText` text NOT NULL,
  `postDate` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`idComment`, `idUser`, `idImage`, `commentText`, `postDate`) VALUES
(1, 1, '../posts/aougdal.11590348341.jpg', 'Cute <3<3', '2020-06-04'),
(2, 1, '../posts/aougdal.11590328868.png', 'The Best <3', '2020-06-04'),
(3, 1, '../posts/aougdal.11590348341.jpg', 'Nice one <3', '2020-06-04'),
(4, 1, '../posts/aougdal.11590348341.jpg', ' a7 3lik osf te7t ana te7t', '2020-06-05');

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

CREATE TABLE `images` (
  `idImage` varchar(70) NOT NULL,
  `postDate` date NOT NULL DEFAULT current_timestamp(),
  `idUser` int(11) NOT NULL,
  `confirmed` int(1) NOT NULL DEFAULT 0,
  `likes` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `images`
--

INSERT INTO `images` (`idImage`, `postDate`, `idUser`, `confirmed`, `likes`) VALUES
('../posts/aougdal.11590328868.png', '2020-05-24', 1, 1, 1),
('../posts/aougdal.11590348341.jpg', '2020-05-24', 1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `likes`
--

CREATE TABLE `likes` (
  `idUser` int(11) NOT NULL,
  `idImage` varchar(70) NOT NULL,
  `likeDate` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `likes`
--

INSERT INTO `likes` (`idUser`, `idImage`, `likeDate`) VALUES
(1, '../posts/aougdal.11590328868.png', '2020-06-05'),
(1, '../posts/aougdal.11590348341.jpg', '2020-06-05');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `idUser` int(11) NOT NULL,
  `firstName` varchar(30) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  `username` varchar(45) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(45) NOT NULL,
  `vkey` varchar(45) NOT NULL,
  `isVerified` int(1) NOT NULL DEFAULT 0,
  `profilePicture` varchar(70) NOT NULL DEFAULT '../profile-pictures/default.png',
  `joinDate` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`idUser`, `firstName`, `lastName`, `username`, `email`, `password`, `vkey`, `isVerified`, `profilePicture`, `joinDate`) VALUES
(1, 'Achraf', 'Ougdal', 'aougdal.1', 'ougdal.achraf@gmail.com', '17b5307fbdc36c026f699ccba4cf8e45', '3509f0bdf2e6ce7802941d6fc270e0bc', 1, '../profile-pictures/aougdal.1.jpg', '2020-06-06');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`idComment`),
  ADD KEY `fk_comments_images` (`idImage`),
  ADD KEY `fk_comments_users` (`idUser`);

--
-- Index pour la table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`idImage`),
  ADD KEY `fk_images_users` (`idUser`);

--
-- Index pour la table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`idUser`,`idImage`),
  ADD KEY `fk_likes_images` (`idImage`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `idComment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comments_images` FOREIGN KEY (`idImage`) REFERENCES `images` (`idImage`),
  ADD CONSTRAINT `fk_comments_users` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`);

--
-- Contraintes pour la table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `fk_images_users` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`);

--
-- Contraintes pour la table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `fk_likes_images` FOREIGN KEY (`idImage`) REFERENCES `images` (`idImage`),
  ADD CONSTRAINT `fk_likes_users` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
