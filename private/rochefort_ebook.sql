-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 31 jan. 2019 à 11:37
-- Version du serveur :  5.7.23
-- Version de PHP :  7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `rochefort_ebook`
--

-- --------------------------------------------------------

--
-- Structure de la table `chapters`
--

DROP TABLE IF EXISTS `chapters`;
CREATE TABLE IF NOT EXISTS `chapters` (
  `chap_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID of the chapter (as P_KEY)',
  `chap_order` int(11) NOT NULL COMMENT 'Order of the chapter (as Index)',
  `chap_title` varchar(255) NOT NULL COMMENT 'Title of the chapter',
  PRIMARY KEY (`chap_id`),
  UNIQUE KEY `IDX_order` (`chap_order`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `com_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID of the comment (as P_KEY)',
  `com_author` varchar(60) DEFAULT 'Anonyme' COMMENT 'Name of the author of the comment',
  `com_text` text NOT NULL COMMENT 'Html content of the comment',
  `com_flag` int(11) NOT NULL COMMENT 'The flag counter (from users)',
  `com_muted` tinyint(1) NOT NULL COMMENT 'The muted status (from admin)',
  `com_modifier` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'TimeStamp of the last modification (as Index)',
  `com_part_id` int(11) NOT NULL COMMENT 'ID from the parent part',
  PRIMARY KEY (`com_id`),
  KEY `IDX_modifier` (`com_modifier`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `parts`
--

DROP TABLE IF EXISTS `parts`;
CREATE TABLE IF NOT EXISTS `parts` (
  `part_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID of the part (as P_KEY)',
  `part_order` int(11) NOT NULL,
  `part_subtitle` varchar(255) NOT NULL COMMENT 'Subtitle of the part (as Index)',
  `part_text` text NOT NULL COMMENT 'Html content of the part',
  `part_modifier` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'TimeStamp of the last modification (as Index)',
  `part_chap_id` int(11) NOT NULL COMMENT 'ID from the parent chapter',
  PRIMARY KEY (`part_id`),
  UNIQUE KEY `IDX_order` (`part_order`),
  KEY `IDX_chap_id` (`part_chap_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
