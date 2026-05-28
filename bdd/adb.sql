-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 28 mai 2026 à 13:19
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `adb`
--

-- --------------------------------------------------------

--
-- Structure de la table `actualite`
--

DROP TABLE IF EXISTS `actualite`;
CREATE TABLE IF NOT EXISTS `actualite` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(100) NOT NULL,
  `contenu` text NOT NULL,
  `image` varchar(250) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `likes` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `titre` (`titre`),
  KEY `date` (`date`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `actualite`
--

INSERT INTO `actualite` (`id`, `titre`, `contenu`, `image`, `date`, `likes`) VALUES
(22, 'Test de ma création d\'actu', 'Voici un texte factice de exactement 500 caractères (espaces compris), idéal pour tester la limite de votre champ contenu :\"Lancement officiel de notre toute nouvelle plateforme de gestion agricole connectée. Grâce à des capteurs de dernière génération installés directement dans les champs, les utilisateurs peuvent désormais suivre en temps réel l\'humidité des sols, la température ambiante et la croissance de leurs cultures depuis une application mobile. Ce projet innovant, développé en étroite collaboration avec des experts du secteur, vise à optimiser les rendements tout en réduisant la consommation d\'eau.\"', '5fbfe4ab6fb65ea8ef2e44e12070b210.jpg', '2026-05-28 12:29:13', 0),
(23, 'Taj mahal', 'Le Taj Mahal, joyau de l\'architecture moghole, reste le monument le plus emblématique de l\'Inde. Construit au XVIIe siècle par l\'empereur Shah Jahan en mémoire de son épouse favorite Mumtaz Mahal, ce mausolée de marbre blanc attire chaque année des millions de visiteurs venus du monde entier.\r\n\r\nSitué à Agra, au bord de la rivière Yamuna, l\'édifice est célèbre pour sa symétrie parfaite, ses dômes majestueux et ses incrustations de pierres semi-précieuses.\r\n\r\nInscrit au patrimoine mondial de l\'UNESCO, le monument subit d\'importants travaux de restauration pour protéger sa blancheur des effets de la pollution atmosphérique moderne.', '95ee1e3b66e383126326349abc68588e.webp', '2026-05-28 12:40:44', 0),
(24, 'Amitié chien chat', 'L\'amitié entre chiens et chats : briser les idées reçues pour une cohabitation réussie. Contrairement au célèbre dicton populaire, faire cohabiter un félin et un canidé sous le même toit est loin d\'être une mission impossible, à condition de respecter le rythme de chacun.\r\n\r\nLa clé d\'une entente harmonieuse réside principalement dans l\'introduction progressive des deux animaux. Les experts animaliers conseillent d\'isoler initialement les pièces pour que chacun s\'habitue à l\'odeur de l\'autre, avant d\'autoriser de courts contacts visuels supervisés.\r\n\r\nUne fois la barrière de l\'inconnu franchie, il n\'est pas rare de voir s\'installer une complicité fusionnelle. Partage des paniers, séances de toilettage mutuel et jeux endiablés transforment alors ces rivaux légendaires en véritables meilleurs amis pour la vie.', '1f30bbbbcc56a8242a0723338b0d26ed.webp', '2026-05-28 12:47:53', 0),
(25, 'Chat européen', 'Le chat Européen, souvent confondu avec le chat de gouttière, est une race à part entière reconnue pour sa robustesse et son élégance naturelle. Originaire de l\'Europe centrale, ce félin au poil court et dense se décline dans une immense variété de robes, allant du tabby classique au blanc pur.\r\n\r\nDoté d\'un caractère équilibré, affectueux mais indépendant, il s\'adapte aussi bien à la vie en appartement qu\'aux grands espaces extérieurs, où ses instincts de chasseur redoutable font merveille.\r\n\r\nParticulièrement sain et résistant aux maladies génétiques grâce à son histoire naturelle, l\'Européen représente le compagnon de famille idéal, capable de nouer des liens d\'une fidélité absolue avec ses maîtres tout au long de sa vie.', '2716cd699cdda8436b802bebe86a0e94.jpg', '2026-05-28 12:48:27', 0),
(26, 'Chat', 'Le chat domestique s\'impose aujourd\'hui comme l\'animal de compagnie préféré de millions de foyers à travers le monde. Vénéré à l\'époque de l\'Égypte antique pour ses talents de protecteur des récoltes, ce petit félin a su conserver au fil des siècles son aura de mystère, sa grâce naturelle et son indépendance caractéristique.\r\n\r\nDoté de sens ultra-développés, il possède une vision nocturne exceptionnelle ainsi qu\'une agilité hors du commun qui lui permettent de se déplacer avec une discrétion absolue. Sa communication passe par un large répertoire de miaulements, de postures corporelles et de ronronnements apaisants.\r\n\r\nAu-delà de son aspect esthétique, la présence d\'un félin à la maison apporte de nombreux bienfaits psychologiques reconnus. Le simple fait de caresser un chat réduit le stress, régule la tension artérielle et favorise un sentiment de bien-être quotidien inégalé.', '84f4ba2fdbc642377b92469208bd37f9.jpeg', '2026-05-28 12:49:15', 0);

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int DEFAULT NULL,
  `actualite_id` int NOT NULL,
  `message` varchar(250) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `utilisateur_id` (`utilisateur_id`),
  KEY `actualite_id` (`actualite_id`),
  KEY `date` (`date`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `commentaire`
--

INSERT INTO `commentaire` (`id`, `utilisateur_id`, `actualite_id`, `message`, `date`) VALUES
(17, 14, 24, 'Tellement vrai ! Mon berger allemand et mon siamois dorment ensemble tous les soirs.', '2026-05-28 13:08:50'),
(18, 9, 24, 'Au début c\'était compliqué chez moi, mais avec du temps et de la patience ils sont inséparables.', '2026-05-28 13:08:50'),
(19, 27, 24, 'Super article, très instructif pour les personnes qui hésitent encore à sauter le pas.', '2026-05-28 13:08:50'),
(20, 21, 24, 'Je confirme pour les odeurs, la séparation des pièces au départ a sauvé la cohabitation !', '2026-05-28 13:08:50'),
(21, 11, 24, 'Mes deux monstres passent leur temps à se courir après, c\'est un vrai spectacle au quotidien.', '2026-05-28 13:08:50'),
(22, 29, 24, 'Est-ce que cela fonctionne aussi bien si le chien est déjà adulte et qu\'on adopte un chaton ?', '2026-05-28 13:08:50'),
(23, 18, 24, 'Magnifique texte, cela change des clichés habituels sur la rivalité entre ces deux espèces.', '2026-05-28 13:08:50'),
(24, 15, 24, 'Le toilettage mutuel c\'est le signe ultime que c\'est gagné, c\'est tellement mignon à voir.', '2026-05-28 13:08:50'),
(25, 23, 24, 'Chez moi le chat a pris le dessus, c\'est lui le vrai boss de la maison face au labrador !', '2026-05-28 13:08:50'),
(26, 12, 24, 'Merci pour ces précieux conseils, je vais tenter l\'introduction progressive dès demain.', '2026-05-28 13:08:50'),
(27, 19, 25, 'Le chat européen est tellement sous-coté, le mien est d\'une gentillesse incroyable !', '2026-05-28 13:10:32'),
(28, 10, 25, 'C\'est vrai qu\'on fait souvent la confusion avec le chat de gouttière, merci pour la clarification.', '2026-05-28 13:10:32'),
(29, 26, 25, 'Une robustesse à toute épreuve, je confirme. Le mien n\'est jamais malade à bientôt 14 ans.', '2026-05-28 13:10:32'),
(30, 12, 25, 'Le mien a un pelage tabby magnifique, on dirait un mini tigre de salon.', '2026-05-28 13:10:32'),
(31, 22, 25, 'Très bon résumé de leur caractère : indépendants mais tellement proches de nous quand ils veulent.', '2026-05-28 13:10:32'),
(32, 28, 25, 'Le compagnon de famille idéal, mes enfants l\'adorent et il est d\'une patience d\'ange.', '2026-05-28 13:10:32'),
(33, 15, 25, 'Le mien vit en appartement et s\'adapte parfaitement, il passe ses journées à regarder par la fenêtre.', '2026-05-28 13:10:32'),
(34, 9, 25, 'Un excellent chasseur en effet ! Les souris du jardin n\'ont aucune chance avec lui.', '2026-05-28 13:10:32'),
(35, 24, 25, 'La mienne est toute blanche, une vraie perle. Très affectueuse et toujours en train de ronronner.', '2026-05-28 13:10:32'),
(36, 17, 25, 'Merci pour cet article complet sur cette race qui mérite vraiment d\'être plus connue.', '2026-05-28 13:10:32'),
(37, 11, 23, 'Un endroit absolument magique, j\'ai eu la chance de le visiter au lever du soleil c\'était inoubliable.', '2026-05-28 13:11:51'),
(38, 25, 23, 'La symétrie de ce monument est une pure prouesse architecturale pour l\'époque.', '2026-05-28 13:11:51'),
(39, 18, 23, 'Une magnifique histoire d\'amour derrière ce chef-d\'œuvre, l\'article résume parfaitement son histoire.', '2026-05-28 13:11:51'),
(40, 9, 23, 'C\'est triste que la pollution menace sa blancheur, j\'espère que les restaurations vont le préserver.', '2026-05-28 13:11:51'),
(41, 21, 23, 'Le marbre blanc avec les incrustations de pierres précieuses est un travail d\'orfèvre incroyable.', '2026-05-28 13:11:51'),
(42, 14, 23, 'Un de mes plus grands rêves de voyage, cet article me donne encore plus envie d\'y aller.', '2026-05-28 13:11:51'),
(43, 29, 23, 'Situé au bord de la rivière Yamuna, le cadre architectural global est tout simplement grandiose.', '2026-05-28 13:11:51'),
(44, 16, 23, 'La perspective depuis les jardins avec le reflet sur l\'eau est iconique, une vraie merveille.', '2026-05-28 13:11:51'),
(45, 27, 23, 'Merci pour ces précisions historiques, on oublie souvent le contexte de sa construction.', '2026-05-28 13:11:51'),
(46, 12, 23, 'L\'architecture moghole dans toute sa splendeur, l\'Inde possède vraiment un patrimoine unique.', '2026-05-28 13:11:51');

-- --------------------------------------------------------

--
-- Structure de la table `question`
--

DROP TABLE IF EXISTS `question`;
CREATE TABLE IF NOT EXISTS `question` (
  `id` int NOT NULL AUTO_INCREMENT,
  `question` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `question`
--

INSERT INTO `question` (`id`, `question`) VALUES
(1, 'Quel est votre plat préféré ?'),
(2, 'Quel est le nom de votre premier animal de compagnie ?'),
(3, 'Quel est le nom de votre sport préféré ?'),
(4, 'Quel est le nom de votre célébrité préférée ?'),
(5, 'Quelle est votre couleur préférée ?'),
(6, 'Quel est votre nombre préféré ?'),
(7, 'Quel est votre film préféré ?'),
(8, 'Quelle est votre série préférée ?'),
(9, 'Quelle est votre boisson préférée ?'),
(10, 'Quel est votre dessert préféré ?');

-- --------------------------------------------------------

--
-- Structure de la table `session`
--

DROP TABLE IF EXISTS `session`;
CREATE TABLE IF NOT EXISTS `session` (
  `token` varchar(100) NOT NULL,
  `utilisateur_id` int NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`token`),
  UNIQUE KEY `utilisateur_id` (`utilisateur_id`),
  KEY `date_creation` (`date_creation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `session`
--

INSERT INTO `session` (`token`, `utilisateur_id`, `date_creation`) VALUES
('1779960815-7478305712', 9, '2026-05-28 11:33:35'),
('1779960860-7987021551', 29, '2026-05-28 11:34:20'),
('1779964026-6379898842', 1, '2026-05-28 12:27:06');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `mdp` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `prenom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `question_id` int NOT NULL,
  `reponse_secrete` varchar(250) NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `derniere_activite` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tel` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `rue` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `numero` int DEFAULT NULL,
  `boite` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `code_postal` varchar(20) DEFAULT NULL,
  `commune` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `pays` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `question_id` (`question_id`),
  KEY `derniere_activite` (`derniere_activite`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `email`, `mdp`, `admin`, `nom`, `prenom`, `question_id`, `reponse_secrete`, `date_creation`, `derniere_activite`, `tel`, `rue`, `numero`, `boite`, `code_postal`, `commune`, `pays`) VALUES
(1, 'admin@gmail.com', '$2y$10$WfgyioPEiL5R0/ntZ95jGeeIB4FGBp8WvUtIU2sX3WBR7hN9HhmAG', 1, 'admin', 'admin', 5, '$2y$10$s0ErFTGc4oLdLC0BIfo5VunE/Sxcpaff.fFrkPnMXJ8SFWxxfhIP6', '2026-05-05 13:31:52', '2026-05-28 12:27:06', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'utilisateur_1@example.com', '$2y$12$WUMV27IShlBtZop0JxtbRO7q87cSHLy28EP6qdV2eF.wwX2F5dH9m', 0, 'Nom_1', 'Prenom_1', 3, '$2y$12$WhIVIb8dpWFMlta9hOG0zeubIw1YbH.ddwriSdK69zCDxGKRT1lJa', '2026-05-28 11:26:30', '2026-05-28 11:33:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'utilisateur_2@example.com', '$2y$12$WUMV27IShlBtZop0JxtbRO7q87cSHLy28EP6qdV2eF.wwX2F5dH9m', 0, 'Nom_2', 'Prenom_2', 1, '$2y$12$WhIVIb8dpWFMlta9hOG0zeubIw1YbH.ddwriSdK69zCDxGKRT1lJa', '2026-05-28 11:26:30', '2026-05-28 11:26:30', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'utilisateur_3@example.com', '$2y$12$WUMV27IShlBtZop0JxtbRO7q87cSHLy28EP6qdV2eF.wwX2F5dH9m', 0, 'Nom_3', 'Prenom_3', 10, '$2y$12$WhIVIb8dpWFMlta9hOG0zeubIw1YbH.ddwriSdK69zCDxGKRT1lJa', '2026-05-28 11:26:30', '2026-05-28 11:26:30', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'utilisateur_4@example.com', '$2y$12$WUMV27IShlBtZop0JxtbRO7q87cSHLy28EP6qdV2eF.wwX2F5dH9m', 0, 'Nom_4', 'Prenom_4', 3, '$2y$12$WhIVIb8dpWFMlta9hOG0zeubIw1YbH.ddwriSdK69zCDxGKRT1lJa', '2026-05-28 11:26:30', '2026-05-28 11:26:30', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 'utilisateur_5@example.com', '$2y$12$WUMV27IShlBtZop0JxtbRO7q87cSHLy28EP6qdV2eF.wwX2F5dH9m', 0, 'Nom_5', 'Prenom_5', 1, '$2y$12$WhIVIb8dpWFMlta9hOG0zeubIw1YbH.ddwriSdK69zCDxGKRT1lJa', '2026-05-28 11:26:30', '2026-05-28 11:26:30', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'utilisateur_6@example.com', '$2y$12$WUMV27IShlBtZop0JxtbRO7q87cSHLy28EP6qdV2eF.wwX2F5dH9m', 0, 'Nom_6', 'Prenom_6', 10, '$2y$12$WhIVIb8dpWFMlta9hOG0zeubIw1YbH.ddwriSdK69zCDxGKRT1lJa', '2026-05-28 11:26:30', '2026-05-28 11:26:30', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 'utilisateur_7@example.com', '$2y$12$WUMV27IShlBtZop0JxtbRO7q87cSHLy28EP6qdV2eF.wwX2F5dH9m', 0, 'Nom_7', 'Prenom_7', 4, '$2y$12$WhIVIb8dpWFMlta9hOG0zeubIw1YbH.ddwriSdK69zCDxGKRT1lJa', '2026-05-28 11:26:30', '2026-05-28 11:26:30', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 'utilisateur_8@example.com', '$2y$12$WUMV27IShlBtZop0JxtbRO7q87cSHLy28EP6qdV2eF.wwX2F5dH9m', 0, 'Nom_8', 'Prenom_8', 7, '$2y$12$WhIVIb8dpWFMlta9hOG0zeubIw1YbH.ddwriSdK69zCDxGKRT1lJa', '2026-05-28 11:26:30', '2026-05-28 11:26:30', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 'utilisateur_9@example.com', '$2y$12$WUMV27IShlBtZop0JxtbRO7q87cSHLy28EP6qdV2eF.wwX2F5dH9m', 0, 'Nom_9', 'Prenom_9', 3, '$2y$12$WhIVIb8dpWFMlta9hOG0zeubIw1YbH.ddwriSdK69zCDxGKRT1lJa', '2026-05-28 11:26:30', '2026-05-28 11:26:30', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 'utilisateur_10@example.com', '$2y$12$WUMV27IShlBtZop0JxtbRO7q87cSHLy28EP6qdV2eF.wwX2F5dH9m', 0, 'Nom_10', 'Prenom_10', 3, '$2y$12$WhIVIb8dpWFMlta9hOG0zeubIw1YbH.ddwriSdK69zCDxGKRT1lJa', '2026-05-28 11:26:30', '2026-05-28 11:26:30', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 'utilisateur_11@example.com', '$2y$12$WUMV27IShlBtZop0JxtbRO7q87cSHLy28EP6qdV2eF.wwX2F5dH9m', 0, 'Nom_11', 'Prenom_11', 10, '$2y$12$WhIVIb8dpWFMlta9hOG0zeubIw1YbH.ddwriSdK69zCDxGKRT1lJa', '2026-05-28 11:26:30', '2026-05-28 11:26:30', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'utilisateur_12@example.com', '$2y$12$WUMV27IShlBtZop0JxtbRO7q87cSHLy28EP6qdV2eF.wwX2F5dH9m', 0, 'Nom_12', 'Prenom_12', 3, '$2y$12$WhIVIb8dpWFMlta9hOG0zeubIw1YbH.ddwriSdK69zCDxGKRT1lJa', '2026-05-28 11:26:30', '2026-05-28 11:26:30', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 'utilisateur_13@example.com', '$2y$12$WUMV27IShlBtZop0JxtbRO7q87cSHLy28EP6qdV2eF.wwX2F5dH9m', 0, 'Nom_13', 'Prenom_13', 6, '$2y$12$WhIVIb8dpWFMlta9hOG0zeubIw1YbH.ddwriSdK69zCDxGKRT1lJa', '2026-05-28 11:26:30', '2026-05-28 11:26:30', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 'utilisateur_14@example.com', '$2y$12$WUMV27IShlBtZop0JxtbRO7q87cSHLy28EP6qdV2eF.wwX2F5dH9m', 0, 'Nom_14', 'Prenom_14', 1, '$2y$12$WhIVIb8dpWFMlta9hOG0zeubIw1YbH.ddwriSdK69zCDxGKRT1lJa', '2026-05-28 11:26:30', '2026-05-28 11:26:30', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 'utilisateur_15@example.com', '$2y$12$WUMV27IShlBtZop0JxtbRO7q87cSHLy28EP6qdV2eF.wwX2F5dH9m', 0, 'Nom_15', 'Prenom_15', 10, '$2y$12$WhIVIb8dpWFMlta9hOG0zeubIw1YbH.ddwriSdK69zCDxGKRT1lJa', '2026-05-28 11:26:30', '2026-05-28 11:26:30', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 'utilisateur_16@example.com', '$2y$12$WUMV27IShlBtZop0JxtbRO7q87cSHLy28EP6qdV2eF.wwX2F5dH9m', 0, 'Nom_16', 'Prenom_16', 5, '$2y$12$WhIVIb8dpWFMlta9hOG0zeubIw1YbH.ddwriSdK69zCDxGKRT1lJa', '2026-05-28 11:26:30', '2026-05-28 11:26:30', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 'utilisateur_17@example.com', '$2y$12$WUMV27IShlBtZop0JxtbRO7q87cSHLy28EP6qdV2eF.wwX2F5dH9m', 0, 'Nom_17', 'Prenom_17', 3, '$2y$12$WhIVIb8dpWFMlta9hOG0zeubIw1YbH.ddwriSdK69zCDxGKRT1lJa', '2026-05-28 11:26:30', '2026-05-28 11:26:30', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 'utilisateur_18@example.com', '$2y$12$WUMV27IShlBtZop0JxtbRO7q87cSHLy28EP6qdV2eF.wwX2F5dH9m', 0, 'Nom_18', 'Prenom_18', 3, '$2y$12$WhIVIb8dpWFMlta9hOG0zeubIw1YbH.ddwriSdK69zCDxGKRT1lJa', '2026-05-28 11:26:30', '2026-05-28 11:26:30', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 'utilisateur_19@example.com', '$2y$12$WUMV27IShlBtZop0JxtbRO7q87cSHLy28EP6qdV2eF.wwX2F5dH9m', 0, 'Nom_19', 'Prenom_19', 7, '$2y$12$WhIVIb8dpWFMlta9hOG0zeubIw1YbH.ddwriSdK69zCDxGKRT1lJa', '2026-05-28 11:26:30', '2026-05-28 11:26:30', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 'utilisateur_20@example.com', '$2y$12$WUMV27IShlBtZop0JxtbRO7q87cSHLy28EP6qdV2eF.wwX2F5dH9m', 0, 'Nom_20', 'Prenom_20', 6, '$2y$12$WhIVIb8dpWFMlta9hOG0zeubIw1YbH.ddwriSdK69zCDxGKRT1lJa', '2026-05-28 11:26:31', '2026-05-28 11:26:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 'nezone@gmail.com', '$2y$10$c5qL23noDJqBTlSAr106WO1IKefbS4k6ZbEqTPFSKcQWHQIuOBolS', 0, 'Jacques', 'Loïc', 1, '$2y$10$BgAbifJ7ePJ9px4dUv.SQ.QNoGuGTA3Fm.owyo3OEPrqYpZebAXpa', '2026-05-28 11:34:13', '2026-05-28 11:34:20', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `actualite`
--
ALTER TABLE `actualite` ADD FULLTEXT KEY `titre_2` (`titre`);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `fk_commentaire_actualite` FOREIGN KEY (`actualite_id`) REFERENCES `actualite` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_commentaire_utilisateur` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `session`
--
ALTER TABLE `session`
  ADD CONSTRAINT `fk_session_utilisateur` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `utilisateur_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
