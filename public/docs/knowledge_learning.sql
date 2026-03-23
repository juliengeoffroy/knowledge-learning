-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 27 août 2025 à 08:56
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `knowledge_learning`
--

-- --------------------------------------------------------

--
-- Structure de la table `certificate`
--

CREATE TABLE `certificate` (
  `id` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `obtained_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `certificate`
--

INSERT INTO `certificate` (`id`, `utilisateur_id`, `course_id`, `obtained_at`) VALUES
(1, 1, 2, '2025-08-07 16:35:50');

-- --------------------------------------------------------

--
-- Structure de la table `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `theme_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `course`
--

INSERT INTO `course` (`id`, `theme_id`, `title`, `price`) VALUES
(1, 1, 'Cursus Guitare', 50),
(2, 1, 'Cursus Piano', 50),
(3, 2, 'Cursus Cuisine', 44),
(4, 2, 'Cursus Dressage Culinaire', 48),
(5, 3, 'Cursus Développement Web', 60),
(6, 4, 'Cursus Jardinage', 30);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `lesson`
--

CREATE TABLE `lesson` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `content` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `lesson`
--

INSERT INTO `lesson` (`id`, `course_id`, `title`, `price`, `content`) VALUES
(1, 1, 'Découverte de la guitare', 10, 'Présentation des cordes, accordage et tenue de l’instrument.'),
(2, 1, 'Les accords de base', 15, 'Apprenez les accords majeurs et mineurs pour débuter.'),
(3, 2, 'Découverte du piano', 10, 'Présentation des touches et posture.'),
(4, 2, 'Les gammes de base', 15, 'Apprenez les gammes majeures et mineures.'),
(5, 3, 'Modes de cuisson', 12, 'Cuire à la vapeur, au four et à la poêle.'),
(6, 3, 'Association des saveurs', 14, 'Marier les saveurs pour sublimer vos plats.'),
(7, 4, 'Dressage des assiettes', 10, 'Disposition esthétique des aliments.'),
(8, 4, 'Harmonisation d’un repas', 15, 'Créer un menu équilibré et visuel.'),
(9, 5, 'HTML & CSS', 20, 'Bases pour créer des pages web structurées et stylisées.'),
(10, 5, 'JavaScript dynamique', 25, 'Apprenez l’interactivité côté client.'),
(11, 6, 'Outils du jardinier', 8, 'Présentation des outils et leur entretien.'),
(12, 6, 'Jardiner avec la lune', 12, 'Planter selon le calendrier lunaire.');

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `progress`
--

CREATE TABLE `progress` (
  `id` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL,
  `lesson_id` int(11) DEFAULT NULL,
  `percentage` int(11) NOT NULL,
  `completed_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `progress`
--

INSERT INTO `progress` (`id`, `utilisateur_id`, `lesson_id`, `percentage`, `completed_at`) VALUES
(1, 2, 12, 0, '2025-07-25 16:49:58');

-- --------------------------------------------------------

--
-- Structure de la table `purchase`
--

CREATE TABLE `purchase` (
  `id` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `lesson_id` int(11) DEFAULT NULL,
  `purchased_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `price` double NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `purchase`
--

INSERT INTO `purchase` (`id`, `utilisateur_id`, `course_id`, `lesson_id`, `purchased_at`, `price`, `created_at`) VALUES
(1, 2, 6, 12, '2025-07-25 16:49:58', 0, '2025-07-30 16:15:12'),
(3, 1, NULL, 4, '2025-08-04 16:17:38', 15, '2025-08-04 16:17:38'),
(4, 1, 2, NULL, '2025-08-07 16:35:50', 50, '2025-08-07 16:35:50');

-- --------------------------------------------------------

--
-- Structure de la table `theme`
--

CREATE TABLE `theme` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `theme`
--

INSERT INTO `theme` (`id`, `title`, `description`) VALUES
(1, 'Musique', 'Apprenez à jouer de la guitare et du piano pas à pas.'),
(2, 'Cuisine', 'Découvrez la cuisine et le dressage culinaire.'),
(3, 'Informatique', 'Apprenez le développement web (HTML, CSS, JavaScript).'),
(4, 'Jardinage', 'Initiez-vous aux techniques de jardinage et calendrier lunaire.');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`roles`)),
  `password` varchar(255) NOT NULL,
  `is_verified` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `is_verified`) VALUES
(1, 'admin@kl.com', '[\"ROLE_ADMIN\"]', '$2y$13$zqbsPVXPzpc4K54Qfv.ZfuYU5.5njXev11CxZS.LRQF2Ea8eGobsW', 1),
(2, 'user@kl.com', '[\"ROLE_USER\"]', '$2y$13$gwZyLEcBSuyGNF3VIXYjTOH2p1tDvMJ07dxeT9PHuvMp8N/DcDoIe', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `certificate`
--
ALTER TABLE `certificate`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_219CDA4AFB88E14F` (`utilisateur_id`),
  ADD KEY `IDX_219CDA4A591CC992` (`course_id`);

--
-- Index pour la table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_169E6FB959027487` (`theme_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `lesson`
--
ALTER TABLE `lesson`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F87474F3591CC992` (`course_id`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `progress`
--
ALTER TABLE `progress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2201F246FB88E14F` (`utilisateur_id`),
  ADD KEY `IDX_2201F246CDF80196` (`lesson_id`);

--
-- Index pour la table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6117D13BFB88E14F` (`utilisateur_id`),
  ADD KEY `IDX_6117D13B591CC992` (`course_id`),
  ADD KEY `IDX_6117D13BCDF80196` (`lesson_id`);

--
-- Index pour la table `theme`
--
ALTER TABLE `theme`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `certificate`
--
ALTER TABLE `certificate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `lesson`
--
ALTER TABLE `lesson`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `progress`
--
ALTER TABLE `progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `theme`
--
ALTER TABLE `theme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `certificate`
--
ALTER TABLE `certificate`
  ADD CONSTRAINT `fk_certificate_course_id` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`),
  ADD CONSTRAINT `fk_certificate_user_id` FOREIGN KEY (`utilisateur_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `FK_169E6FB959027487` FOREIGN KEY (`theme_id`) REFERENCES `theme` (`id`);

--
-- Contraintes pour la table `lesson`
--
ALTER TABLE `lesson`
  ADD CONSTRAINT `FK_F87474F3591CC992` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`);

--
-- Contraintes pour la table `progress`
--
ALTER TABLE `progress`
  ADD CONSTRAINT `FK_2201F246CDF80196` FOREIGN KEY (`lesson_id`) REFERENCES `lesson` (`id`),
  ADD CONSTRAINT `FK_2201F246FB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `purchase`
--
ALTER TABLE `purchase`
  ADD CONSTRAINT `FK_6117D13B591CC992` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`),
  ADD CONSTRAINT `FK_6117D13BCDF80196` FOREIGN KEY (`lesson_id`) REFERENCES `lesson` (`id`),
  ADD CONSTRAINT `FK_6117D13BFB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
