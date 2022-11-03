-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 03 nov. 2022 à 12:59
-- Version du serveur :  8.0.27
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `cake-agogo`
--

-- --------------------------------------------------------

--
-- Structure de la table `adress`
--

DROP TABLE IF EXISTS `adress`;
CREATE TABLE IF NOT EXISTS `adress` (
  `id` int NOT NULL AUTO_INCREMENT,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adress1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adress2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `adress`
--

INSERT INTO `adress` (`id`, `country`, `city`, `postal_code`, `adress1`, `adress2`) VALUES
(1, 'France', 'Marly', '59174', '12 rue des postes', NULL),
(2, 'France', 'La Sentinelle', '59174', '12 rue machin', NULL),
(3, 'France', 'La Sentinelle', '59174', '12 rue machin', NULL),
(7, 'Pologne', 'La Sentinelle', '59174', '958 Rue Gustave Delory', NULL),
(22, 'Pologne', 'La Sentine', '59174', '958 Rue Gustave Delory', NULL),
(23, 'Farine', 'La Sentinelle', '59174', '958 Rue Gustave Delory', NULL),
(25, '958 Rue Gustave Delory', 'valencienens', '59300', '12 rue des pyrénées', NULL),
(26, 'France', 'Valencinnes', '59300', '12 rue des petit ponts', NULL),
(27, 'Pologne', 'Valenciennes', '59300', '958 Rue du ballon d\'or', NULL),
(28, 'ezaeza', 'eazeazTINELLE', '4646', '958 Rue ezaeazeazeDelory', NULL),
(29, 'La Sentinelle', '59174 - LA SENTINELLE', '59174', '958 Rue Gustave Delory', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `cake_like`
--

DROP TABLE IF EXISTS `cake_like`;
CREATE TABLE IF NOT EXISTS `cake_like` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_794A48A94584665A` (`product_id`),
  KEY `IDX_794A48A9A76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=183 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `cake_like`
--

INSERT INTO `cake_like` (`id`, `product_id`, `user_id`) VALUES
(90, 2, 16),
(96, 14, 16),
(97, 34, 16),
(98, 4, 16),
(99, 25, 31),
(100, NULL, 16),
(101, NULL, 31),
(102, 2, 16),
(103, NULL, 31),
(104, NULL, 31),
(105, NULL, 31),
(106, 4, 34),
(107, 2, NULL),
(109, 25, 34),
(110, NULL, NULL),
(111, NULL, 31),
(112, NULL, 16),
(113, NULL, 35),
(114, 34, NULL),
(115, 4, NULL),
(173, 55, 31);

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(320) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`, `description`) VALUES
(3, 'Poids Lourds', 'On Entre dans le vif du sujet , cet fois c\'est trop tard pour vous décourager, le poids lourd vous attends. Restez calme armé vous de vos meilleurs Element et tout ira bien'),
(4, 'Hors Category', 'Le Boss Final , le Heihachi Mishima des gateaux , le seul moment pour lui d\'apparaître c\'est pour vos évnements specieaux, type mariage . A ne risquez que si vous avez une armée avec vous '),
(5, 'snow', 'pour les produits sans categorie'),
(25, 'Poids Moyens', ' Quête pour 4 à 6 joueurs. Il est seul , vous êtes assez nombreux pour en finir avec lui mais soit vigilent , une crampe est vite arrivé '),
(26, 'Poids Légers', 'Pour une personnes , envie d\'une envie coquine ? ou bien faites un mezze de tous les produits pour tous vos combatants, et leurs estomac');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `content` varchar(320) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9474526CA76ED395` (`user_id`),
  KEY `IDX_9474526C4584665A` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `user_id`, `created_at`, `content`, `product_id`) VALUES
(33, 31, '2022-11-01 19:38:12', 'c\'est un trés jolie gateau merci encore  !! <3 ', 2),
(34, 31, '2022-11-01 19:53:52', 'c\'est un trés jolie gateau merci encore  !! <3 ', 2),
(36, 31, '2022-11-01 20:28:13', 'Trés jolie réalisations ! Chapeaux', 49),
(40, 36, '2022-11-03 00:17:34', 'J\'en commande 10 pour fêter mon ballon d\'or direct!', 2),
(41, 36, '2022-11-03 00:18:22', 'J\'en commande 10 pour fêter mon ballon d\'or direct!', 2),
(42, 36, '2022-11-03 00:20:48', 'J\'en commande 10 pour fêter mon ballon d\'or direct!', 2),
(43, 36, '2022-11-03 00:21:12', 'J\'en commande 10 pour fêter mon ballon d\'or direct!', 2),
(44, 36, '2022-11-03 00:21:21', 'J\'en commande 10 pour fêter mon ballon d\'or direct!', 2),
(51, 31, '2022-11-03 09:45:31', 'lalaelazelazleazleazlelazeazea', 2),
(52, 31, '2022-11-03 10:04:16', 'lldldazdaz', 2),
(53, 31, '2022-11-03 11:25:17', 'lalala', 2),
(54, 31, '2022-11-03 11:25:50', 'lalala', 2);

-- --------------------------------------------------------

--
-- Structure de la table `file`
--

DROP TABLE IF EXISTS `file`;
CREATE TABLE IF NOT EXISTS `file` (
  `id` int NOT NULL AUTO_INCREMENT,
  `caption` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `file`
--

INSERT INTO `file` (`id`, `caption`, `file_path`) VALUES
(3, NULL, 'f159cedd0f7fabfed745016eccb71915.png'),
(4, NULL, 'f2cf30740db2a1f9681f91fe6a56d63d.png'),
(5, NULL, '8676ab6ce94032f2d33339d76e0bb5e1.png'),
(6, NULL, 'e58c485648953c3993387654773b7fd7.png'),
(7, NULL, 'pres-team-1-635f8dc95e312.png'),
(8, NULL, 'pres-team-1-635f8dd18f7c7.png'),
(9, NULL, 'ErreurPaypalPAymentCard-635f8ef617e1f.png'),
(10, NULL, 'pres-team-1-635f93f924430.png'),
(11, NULL, 'pres-team-1-635f984dc005d.png'),
(12, NULL, 'pres-team-1-635f986fc17b2.png'),
(13, NULL, 'pres-team-1-635f98db8e311.png'),
(14, NULL, 'LOGOFRontCAKE-635f9a5294a6c.jpg'),
(15, NULL, 'faillespatiotemporelle-635f9aabb719e.png'),
(16, NULL, 'LOGOFRontCAKEss-635fad012fcc0.png'),
(17, NULL, 'LOGOFRontCAKEss-635fad095a481.png'),
(18, NULL, 'LOGOFRontCAKEss-635fad681958d.png'),
(19, NULL, 'LOGOFRontCAKEss-635faf3799ac3.png'),
(20, NULL, 'LOGOFRontCAKEss-635fafbe900d5.png'),
(21, NULL, 'pres-team-1-635fb06a98bdd.png'),
(22, NULL, 'faillespatiotemporelle-635fb09d39434.png'),
(23, NULL, 'caketest-6361162474001.jpg'),
(24, NULL, 'caketest-636283d396130.jpg'),
(25, NULL, 'caketest-636284738f240.jpg'),
(26, NULL, 'caketest-63628690b4d79.jpg'),
(27, NULL, 'vache-63628ab5d76f5.jpg'),
(28, NULL, 'caketest-6362dc4050157.jpg'),
(29, NULL, 'caketest-6362ead205736.jpg'),
(30, NULL, 'caketest-6362eaf089537.jpg'),
(31, NULL, 'caketest-6362f4581d098.jpg'),
(32, NULL, 'caketest-6362f49e96893.jpg'),
(33, NULL, 'caketest-6362f4aaad46f.jpg'),
(34, NULL, 'caketest-63638748b26e2.jpg'),
(35, NULL, 'caketest-636387cbe5b27.jpg'),
(36, NULL, 'faillespatiotemporelle-636388121c427.png'),
(37, NULL, 'caketest-6363b6310be2f.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `ingredient`
--

DROP TABLE IF EXISTS `ingredient`;
CREATE TABLE IF NOT EXISTS `ingredient` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `ingredient`
--

INSERT INTO `ingredient` (`id`, `name`, `quantity`) VALUES
(1, 'Farine', 75),
(2, 'Beurre', 150),
(3, 'Levure Chimique', 15),
(5, 'chocolat', 200),
(6, 'sucre', 150),
(7, 'sucre vanillé', 15);

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_ht` double NOT NULL,
  `price_ttc` double NOT NULL,
  `tva` double DEFAULT NULL,
  `nb_person` int DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `is_actif` tinyint(1) DEFAULT NULL,
  `brochure_filename` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D34A04AD12469DE2` (`category_id`),
  KEY `IDX_D34A04AD93CB796C` (`file_id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `category_id`, `name`, `price_ht`, `price_ttc`, `tva`, `nb_person`, `weight`, `created_at`, `is_actif`, `brochure_filename`, `file_id`) VALUES
(2, 3, 'LE  HIGH CAKE', 10.33, 14.5, 0.5, 10, 10, '2022-10-03 15:52:53', 1, NULL, 23),
(4, 4, 'LE FRONT CAKE', 10, 15, 0, 2, 15, '2022-10-10 14:54:08', 1, NULL, 23),
(14, 25, 'Le Middle Cake', 10, 10, 0, 10, 10, '2022-10-19 12:34:28', 1, NULL, 23),
(25, 5, 'Front KICK au Choclat a d', 10, 10, 0, 10, 10, '2022-10-20 08:17:55', 0, NULL, 23),
(34, 3, 'Front KICK au Choclat j', 10, 10, 0, 10, 10, '2022-10-30 20:50:39', 0, NULL, 23),
(49, 26, 'Le Low Cake', 10, 10, 0, 10, 10, '2022-11-01 12:51:47', 1, NULL, 23),
(50, 25, 'Le Mini cake', 10, 2.85, 0, 10, 10, '2022-11-02 14:51:38', 1, NULL, 24),
(51, 26, 'La Sentinelle', 10, 2, 0, 1, 10, '2022-11-02 14:53:44', 1, NULL, 25),
(54, 3, 'Le Front kick', 10, 30.5, 0, 10, 4500, '2022-11-02 22:10:42', 1, NULL, 29),
(55, 3, 'Le middle kick', 10, 22.5, 0, 8, 800, '2022-11-02 22:11:19', 1, NULL, 30);

-- --------------------------------------------------------

--
-- Structure de la table `receipt`
--

DROP TABLE IF EXISTS `receipt`;
CREATE TABLE IF NOT EXISTS `receipt` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(5000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_actif` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `receipt`
--

INSERT INTO `receipt` (`id`, `title`, `description`, `is_actif`) VALUES
(1, 'Le Front Cake', 'Commencez par sortir le beurre du réfrigérateur afin qu\'il ramollisse. Si vous avez oublié, il suffit de le passer au micro-ondes pendant une dizaine de secondes, il vous sera plus facile de le travailler par la suite.\nDans une casserole, cassez le chocolat en morceaux auxquels vous ajoutez 3 cuillères à soupe d\'eau et mettez le tout à fondre à feu moyen au bain-marie (dans une casserole plus grande remplie d\'eau).\nPendant ce temps, dans un saladier, vous travaillez, à l\'aide d\'une cuillère en bois, le beurre mou en pommade, auquel vous ajoutez le sucre en poudre. Continuez de remuer jusqu\'à ce que le mélange devienne léger et onctueux. Vous pouvez aussi vous aider d\'un batteur électrique, plus efficace pour obtenir la consistance désirée.\nAjoutez les œufs un à un en alternant avec la farine. Conseil : il faut remuer et bien travailler la pâte entre chaque œuf et chaque apport de farine, jusqu\'à incorporation complète de ces éléments dans la pâte. Pour rendre la pâte plus homogène, vous pouvez également donner un petit coup de batteur électrique.\nEnsuite, incorporez à ce mélange le chocolat fondu en remuant bien avec une cuillère. Beurrez votre moule, versez-y la pâte et faites cuire au four, préchauffé à 150°c, pendant 25 à 30 minutes.\nPour finir\nPlacez le sucre glace sur le dessus du gâteau une fois que celui-ci a totalement refroidi. À servir froid.', 1),
(7, 'Le High Cake', 'Commencez par sortir le beurre du réfrigérateur afin qu\'il ramollisse. Si vous avez oublié, il suffit de le passer au micro-ondes pendant une dizaine de secondes, il vous sera plus facile de le travailler par la suite.\nDans une casserole, cassez le chocolat en morceaux auxquels vous ajoutez 3 cuillères à soupe d\'eau et mettez le tout à fondre à feu moyen au bain-marie (dans une casserole plus grande remplie d\'eau).\nPendant ce temps, dans un saladier, vous travaillez, à l\'aide d\'une cuillère en bois, le beurre mou en pommade, auquel vous ajoutez le sucre en poudre. Continuez de remuer jusqu\'à ce que le mélange devienne léger et onctueux. Vous pouvez aussi vous aider d\'un batteur électrique, plus efficace pour obtenir la consistance désirée.\nAjoutez les œufs un à un en alternant avec la farine. Conseil : il faut remuer et bien travailler la pâte entre chaque œuf et chaque apport de farine, jusqu\'à incorporation complète de ces éléments dans la pâte. Pour rendre la pâte plus homogène, vous pouvez également donner un petit coup de batteur électrique.\nEnsuite, incorporez à ce mélange le chocolat fondu en remuant bien avec une cuillère. Beurrez votre moule, versez-y la pâte et faites cuire au four, préchauffé à 150°c, pendant 25 à 30 minutes.\nPour finir\nPlacez le sucre glace sur le dessus du gâteau une fois que celui-ci a totalement refroidi. À servir froid.', 1),
(8, 'Le Middle Cake', 'Commencez par sortir le beurre du réfrigérateur afin qu\'il ramollisse. Si vous avez oublié, il suffit de le passer au micro-ondes pendant une dizaine de secondes, il vous sera plus facile de le travailler par la suite.\nDans une casserole, cassez le chocolat en morceaux auxquels vous ajoutez 3 cuillères à soupe d\'eau et mettez le tout à fondre à feu moyen au bain-marie (dans une casserole plus grande remplie d\'eau).\nPendant ce temps, dans un saladier, vous travaillez, à l\'aide d\'une cuillère en bois, le beurre mou en pommade, auquel vous ajoutez le sucre en poudre. Continuez de remuer jusqu\'à ce que le mélange devienne léger et onctueux. Vous pouvez aussi vous aider d\'un batteur électrique, plus efficace pour obtenir la consistance désirée.\nAjoutez les œufs un à un en alternant avec la farine. Conseil : il faut remuer et bien travailler la pâte entre chaque œuf et chaque apport de farine, jusqu\'à incorporation complète de ces éléments dans la pâte. Pour rendre la pâte plus homogène, vous pouvez également donner un petit coup de batteur électrique.\nEnsuite, incorporez à ce mélange le chocolat fondu en remuant bien avec une cuillère. Beurrez votre moule, versez-y la pâte et faites cuire au four, préchauffé à 150°c, pendant 25 à 30 minutes.\nPour finir\nPlacez le sucre glace sur le dessus du gâteau une fois que celui-ci a totalement refroidi. À servir froid.Dans une casserole, cassez le chocolat en morceaux auxquels vous ajoutez 3 cuillères à soupe d\'eau et mettez le tout à fondre à feu moyen au bain-marie (dans une casserole plus grande remplie d\'eau).\nPendant ce temps, dans un saladier, vous travaillez, à l\'aide d\'une cuillère en bois, le beurre mou en pommade, auquel vous ajoutez le sucre en poudre. Continuez de remuer jusqu\'à ce que le mélange devienne léger et onctueux. Vous pouvez aussi vous aider d\'un batteur électrique, plus efficace pour obtenir la consistance désirée.\nAjoutez les œufs un à un en alternant avec la farine. Conseil : il faut remuer et bien travailler la pâte entre chaque œuf et chaque apport de farine, jusqu\'à incorporation complète de ces éléments dans la pâte. Pour rendre la pâte plus homogène, vou', 0),
(13, 'Le Low Cake', 'Commencez par sortir le beurre du réfrigérateur afin qu\'il ramollisse. Si vous avez oublié, il suffit de le passer au micro-ondes pendant une dizaine de secondes, il vous sera plus facile de le travailler par la suite.\nDans une casserole, cassez le chocolat en morceaux auxquels vous ajoutez 3 cuillères à soupe d\'eau et mettez le tout à fondre à feu moyen au bain-marie (dans une casserole plus grande remplie d\'eau).\nPendant ce temps, dans un saladier, vous travaillez, à l\'aide d\'une cuillère en bois, le beurre mou en pommade, auquel vous ajoutez le sucre en poudre. Continuez de remuer jusqu\'à ce que le mélange devienne léger et onctueux. Vous pouvez aussi vous aider d\'un batteur électrique, plus efficace pour obtenir la consistance désirée.\nAjoutez les œufs un à un en alternant avec la farine. Conseil : il faut remuer et bien travailler la pâte entre chaque œuf et chaque apport de farine, jusqu\'à incorporation complète de ces éléments dans la pâte. Pour rendre la pâte plus homogène, vous pouvez également donner un petit coup de batteur électrique.\nEnsuite, incorporez à ce mélange le chocolat fondu en remuant bien avec une cuillère. Beurrez votre moule, versez-y la pâte et faites cuire au four, préchauffé à 150°c, pendant 25 à 30 minutes.\nPour finir\nPlacez le sucre glace sur le dessus du gâteau une fois que celui-ci a totalement refroidi. À servir froid.Dans une casserole, cassez le chocolat en morceaux auxquels vous ajoutez 3 cuillères à soupe d\'eau et mettez le tout à fondre à feu moyen au bain-marie (dans une casserole plus grande remplie d\'eau).\nPendant ce temps, dans un saladier, vous travaillez, à l\'aide d\'une cuillère en bois, le beurre mou en pommade, auquel vous ajoutez le sucre en poudre. Continuez de remuer jusqu\'à ce que le mélange devienne léger et onctueux. Vous pouvez aussi vous aider d\'un batteur électrique, plus efficace pour obtenir la consistance désirée.\nAjoutez les œufs un à un en alternant avec la farine. Conseil : il faut remuer et bien travailler la pâte entre chaque œuf et chaque apport de farine, jusqu\'à incorporation complète de ces éléments dans la pâte. Pour rendre la pâte plus homogène, vou', 0);

-- --------------------------------------------------------

--
-- Structure de la table `receipt_ingredient`
--

DROP TABLE IF EXISTS `receipt_ingredient`;
CREATE TABLE IF NOT EXISTS `receipt_ingredient` (
  `receipt_id` int NOT NULL,
  `ingredient_id` int NOT NULL,
  PRIMARY KEY (`receipt_id`,`ingredient_id`),
  KEY `IDX_918CC69B2B5CA896` (`receipt_id`),
  KEY `IDX_918CC69B933FE08C` (`ingredient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `receipt_ingredient`
--

INSERT INTO `receipt_ingredient` (`receipt_id`, `ingredient_id`) VALUES
(1, 1),
(1, 2),
(7, 1),
(7, 2),
(7, 5),
(7, 6),
(7, 7),
(8, 1),
(8, 3),
(8, 5),
(8, 7),
(13, 1),
(13, 3),
(13, 5),
(13, 7);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `registered_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `adress_id` int NOT NULL,
  `reset_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  UNIQUE KEY `UNIQ_8D93D6498486F9AC` (`adress_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `phone`, `last_name`, `first_name`, `registered_at`, `adress_id`, `reset_token`) VALUES
(16, 'kevin@kevin.fr', '[\"ROLE_USER\"]', '$2y$13$8FOaPLdqxykKoXHX4KjZaeQKOEkrHOD8m02uNUeqFejS2Upw7Dd9q', '06548745898', 'Kevin', 'Kevin', '2022-10-16 21:15:16', 7, NULL),
(31, 'alexandre.lusiak@gmail.com', '[\"ROLE_USER\", \"ROLE_ADMIN\"]', '$2y$13$8FOaPLdqxykKoXHX4KjZaeQKOEkrHOD8m02uNUeqFejS2Upw7Dd9q', '0652457895', 'Alexandre', 'lusiak', '2022-10-18 14:51:43', 22, NULL),
(32, 'lusiakalexandr@gmail.com', '[\"ROLE_USER\"]', '$2y$13$jHv6T0y923tBYDa9U4umb.rqTrs8BJ3l9GqG/jHEy9px5g9dyyMDe', '065126456', 'Alexandre', 'lusiak', '2022-11-01 08:36:07', 23, NULL),
(34, 'jeremmie@gmail.com', '[\"ROLE_USER\"]', '$2y$13$ZMRxdTymRHMN5K4OQZp0/.sI3116NOJXDFmvhuk6sLXQ0YfpbkIJ6', '065245495945', 'jeremie', 'lusiak', '2022-11-01 08:37:31', 25, NULL),
(35, 'nicolassss@gmail.com', '[\"ROLE_USER\"]', '$2y$13$jHv6T0y923tBYDa9U4umb.rqTrs8BJ3l9GqG/jHEy9px5g9dyyMDe', '145145151', 'Zidane', 'Zinédine', '2022-11-01 08:38:12', 26, NULL),
(36, 'KarimBenzou@gmail.com', '[\"ROLE_USER\"]', '$2y$13$jHv6T0y923tBYDa9U4umb.rqTrs8BJ3l9GqG/jHEy9px5g9dyyMDe', '06554844545', 'Karim', 'Benzema', '2022-11-02 17:21:47', 27, NULL),
(37, 'lusiassskaleeazexandr@gmail.com', '[\"ROLE_USER\"]', '$2y$13$jHv6T0y923tBYDa9U4umb.rqTrs8BJ3l9GqG/jHEy9px5g9dyyMDe', '0561256156', 'azeaze', 'qdqdqsdqs', '2022-11-02 23:20:48', 28, NULL),
(38, 'lusiakaaalexandr@gmail.com', '[\"ROLE_USER\"]', '$2y$13$T42koVq1ePfoQnkxaBmNZuVXO.htd1yYWvtUrCqlHCAXzAgrCdj1S', '0215151256156', 'Alexandre', 'lusiak', '2022-11-03 11:13:29', 29, NULL);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `cake_like`
--
ALTER TABLE `cake_like`
  ADD CONSTRAINT `FK_794A48A94584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `FK_794A48A9A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_9474526C4584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `FK_9474526CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_D34A04AD12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `FK_D34A04AD93CB796C` FOREIGN KEY (`file_id`) REFERENCES `file` (`id`);

--
-- Contraintes pour la table `receipt_ingredient`
--
ALTER TABLE `receipt_ingredient`
  ADD CONSTRAINT `FK_918CC69B2B5CA896` FOREIGN KEY (`receipt_id`) REFERENCES `receipt` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_918CC69B933FE08C` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredient` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D6498486F9AC` FOREIGN KEY (`adress_id`) REFERENCES `adress` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
