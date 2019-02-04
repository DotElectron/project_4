-- MySQL dump 10.13  Distrib 5.7.23, for Win64 (x86_64)
--
-- Host: localhost    Database: rochefort_ebook
-- ------------------------------------------------------
-- Server version	5.7.23

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `chapters`
--

DROP TABLE IF EXISTS `chapters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chapters` (
  `chap_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID of the chapter (as P_KEY)',
  `chap_order` int(11) NOT NULL COMMENT 'Order of the chapter (as Index)',
  `chap_title` varchar(255) NOT NULL COMMENT 'Title of the chapter',
  PRIMARY KEY (`chap_id`),
  UNIQUE KEY `IDX_order` (`chap_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Contains definition of the book''s chapter, ordered and appointed.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `com_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID of the comment (as P_KEY)',
  `com_author` varchar(60) DEFAULT 'Anonyme' COMMENT 'Name of the author of the comment',
  `com_text` text NOT NULL COMMENT 'Html content of the comment',
  `com_flag` int(11) NOT NULL COMMENT 'The flag counter (from users)',
  `com_muted` tinyint(1) NOT NULL COMMENT 'The muted status (from admin)',
  `com_modifier` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'TimeStamp of the last modification (as Index)',
  `com_part_id` int(11) DEFAULT NULL COMMENT 'ID from the parent part',
  PRIMARY KEY (`com_id`),
  KEY `IDX_modifier` (`com_modifier`),
  KEY `IDX_part_id` (`com_part_id`),
  CONSTRAINT `F_KEY_part_id` FOREIGN KEY (`com_part_id`) REFERENCES `parts` (`part_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Contains definition of the part''s comment, need to be treated by DESC Timestamp.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `parts`
--

DROP TABLE IF EXISTS `parts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parts` (
  `part_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID of the part (as P_KEY)',
  `part_order` int(11) NOT NULL,
  `part_subtitle` varchar(255) NOT NULL COMMENT 'Subtitle of the part (as Index)',
  `part_text` text NOT NULL COMMENT 'Html content of the part',
  `part_modifier` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'TimeStamp of the last modification (as Index)',
  `part_chap_id` int(11) DEFAULT NULL COMMENT 'ID from the parent chapter',
  PRIMARY KEY (`part_id`),
  UNIQUE KEY `IDX_order` (`part_order`),
  KEY `IDX_chap_id` (`part_chap_id`) USING BTREE,
  CONSTRAINT `F_KEY_chap_id` FOREIGN KEY (`part_chap_id`) REFERENCES `chapters` (`chap_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Contains definition of the chapter''s part, ordered and appointed.';
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-02-04 11:50:01
