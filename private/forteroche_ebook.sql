-- MySQL dump 10.13  Distrib 5.7.23, for Win64 (x86_64)
--
-- Host: localhost    Database: forteroche_ebook
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
  `chap_title` varchar(255) NOT NULL COMMENT 'Title of the chapter (as Index)',
  PRIMARY KEY (`chap_id`),
  UNIQUE KEY `IDX_order` (`chap_order`),
  UNIQUE KEY `IDX_title` (`chap_title`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Contains definition of the book''s chapter, ordered and appointed.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chapters`
--

LOCK TABLES `chapters` WRITE;
/*!40000 ALTER TABLE `chapters` DISABLE KEYS */;
INSERT INTO `chapters` VALUES (1,0,'Titre du chapitre (ou catégorie) - extrait de Charles Darwin');
/*!40000 ALTER TABLE `chapters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parts`
--

DROP TABLE IF EXISTS `parts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parts` (
  `part_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID of the part (as P_KEY)',
  `part_order` int(11) NOT NULL COMMENT 'Order of the part (as Index)',
  `part_subtitle` varchar(255) DEFAULT NULL COMMENT 'Subtitle of the part (as Unique)',
  `part_text` text NOT NULL COMMENT 'Html content of the part',
  `part_modifier` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'TimeStamp of the last modification (as Index)',
  `part_chap_id` int(11) DEFAULT NULL COMMENT 'ID from the parent chapter (as Foreign)',
  PRIMARY KEY (`part_id`),
  UNIQUE KEY `IDX_order` (`part_order`),
  UNIQUE KEY `IDX_subtitle` (`part_subtitle`),
  KEY `IDX_chap_id` (`part_chap_id`),
  CONSTRAINT `F_KEY_chap_id` FOREIGN KEY (`part_chap_id`) REFERENCES `chapters` (`chap_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Contains definition of the chapter''s part, ordered and appointed.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parts`
--

LOCK TABLES `parts` WRITE;
/*!40000 ALTER TABLE `parts` DISABLE KEYS */;
INSERT INTO `parts` VALUES (1,0,'Des débuts prometteurs','&lt;blockquote&gt;\r\n&lt;p style=\\&quot;text-align: justify;\\&quot;&gt;&lt;span style=\\&quot;font-family: \\\'Times New Roman\\\'; font-size: 21.73px; font-variant-numeric: normal; font-variant-east-asian: normal; line-height: 32.59px; text-align: justify; text-indent: 21.73px;\\&quot;&gt;Je me propose de passer bri&amp;egrave;vement en revue les progr&amp;egrave;s de l&amp;rsquo;opinion relativement &amp;agrave; l&amp;rsquo;origine des esp&amp;egrave;ces. Jusque tout r&amp;eacute;cemment, la plupart des naturalistes croyaient que les esp&amp;egrave;ces sont des productions immuables cr&amp;eacute;&amp;eacute;es s&amp;eacute;par&amp;eacute;ment. De nombreux savants ont habilement soutenu cette hypoth&amp;egrave;se. Quelques autres, au contraire, ont admis que les esp&amp;egrave;ces &amp;eacute;prouvent des modifications et que les formes actuelles descendent de formes pr&amp;eacute;existantes par voie de g&amp;eacute;n&amp;eacute;ration r&amp;eacute;guli&amp;egrave;re. Si on laisse de c&amp;ocirc;t&amp;eacute; les allusions qu&amp;rsquo;on trouve &amp;agrave; cet &amp;eacute;gard dans les auteurs de l&amp;rsquo;antiquit&amp;eacute;&lt;/span&gt;&lt;a id=\\&quot;footnote_1_call\\&quot; class=\\&quot;footnote msbooks-tabindex-restored\\&quot; style=\\&quot;color: #000000; font-family: \\\'Times New Roman\\\'; font-size: 10.06px; font-variant-numeric: normal; font-variant-east-asian: normal; text-align: justify; text-decoration-line: none; text-indent: 21.73px; vertical-align: super;\\&quot; tabindex=\\&quot;0\\&quot; href=\\&quot;ms-local-stream://EpubReader_5964532E702F4FE1AF3AC02CA1932068/Content/OPS/footnotes.xml#footnote_1\\&quot;&gt;[1]&lt;/a&gt;&lt;span style=\\&quot;font-family: \\\'Times New Roman\\\'; font-size: 21.73px; font-variant-numeric: normal; font-variant-east-asian: normal; line-height: 32.59px; text-align: justify; text-indent: 21.73px;\\&quot;&gt;, Buffon est le premier qui, dans les temps modernes, a trait&amp;eacute; ce sujet au point de vue essentiellement scientifique. Toutefois, comme ses opinions ont beaucoup vari&amp;eacute; &amp;agrave; diverses &amp;eacute;poques, et qu&amp;rsquo;il n&amp;rsquo;aborde ni les causes ni les moyens de la transformation de l&amp;rsquo;esp&amp;egrave;ce, il est inutile d&amp;rsquo;entrer ici dans de plus amples d&amp;eacute;tails sur ses travaux.&lt;/span&gt;&lt;/p&gt;\r\n&lt;/blockquote&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;div style=\\&quot;color: #f8f8f2; background-color: #272822; font-family: Consolas, \\\'Courier New\\\', monospace; font-size: 14px; line-height: 19px; white-space: pre;\\&quot;&gt;\r\n&lt;div style=\\&quot;text-align: center;\\&quot;&gt;De l\\\'Origine des esp&amp;egrave;ces&lt;/div&gt;\r\n&lt;div style=\\&quot;text-align: center;\\&quot;&gt;Charles Darwin&lt;/div&gt;\r\n&lt;div style=\\&quot;text-align: center;\\&quot;&gt;(Traducteur: Edmond Barbier)&lt;/div&gt;\r\n&lt;br /&gt;&lt;br /&gt;\r\n&lt;div style=\\&quot;text-align: center;\\&quot;&gt;Publication: 1896&lt;/div&gt;\r\n&lt;/div&gt;','2019-02-26 02:19:32',1),(2,1,'De philosophie zoologique','&lt;blockquote&gt;\r\n&lt;p style=\\&quot;text-align: justify;\\&quot;&gt;&lt;span style=\\&quot;font-family: \\\'Times New Roman\\\'; font-size: 21.73px; font-variant-numeric: normal; font-variant-east-asian: normal; line-height: 32.59px; text-align: justify; text-indent: 21.73px;\\&quot;&gt;Lamarck est le premier qui &amp;eacute;veilla par ses conclusions une attention s&amp;eacute;rieuse sur ce sujet. Ce savant, justement c&amp;eacute;l&amp;egrave;bre, publia pour la premi&amp;egrave;re fois ses opinions en 1801&amp;nbsp;; il les d&amp;eacute;veloppa consid&amp;eacute;rablement, en 1809, dans sa &lt;/span&gt;&lt;em style=\\&quot;font-family: \\\'Times New Roman\\\'; font-size: 21.73px; font-variant-numeric: normal; font-variant-east-asian: normal; text-align: justify; text-indent: 21.73px;\\&quot;&gt;Philosophie zoologique&lt;/em&gt;&lt;span style=\\&quot;font-family: \\\'Times New Roman\\\'; font-size: 21.73px; font-variant-numeric: normal; font-variant-east-asian: normal; line-height: 32.59px; text-align: justify; text-indent: 21.73px;\\&quot;&gt;, et subs&amp;eacute;quemment, en 1815, dans l&amp;rsquo;introduction &amp;agrave; son &lt;/span&gt;&lt;em style=\\&quot;font-family: \\\'Times New Roman\\\'; font-size: 21.73px; font-variant-numeric: normal; font-variant-east-asian: normal; text-align: justify; text-indent: 21.73px;\\&quot;&gt;Histoire naturelle des animaux sans vert&amp;egrave;bres&lt;/em&gt;&lt;span style=\\&quot;font-family: \\\'Times New Roman\\\'; font-size: 21.73px; font-variant-numeric: normal; font-variant-east-asian: normal; line-height: 32.59px; text-align: justify; text-indent: 21.73px;\\&quot;&gt;. Il soutint dans ces ouvrages la doctrine que toutes les esp&amp;egrave;ces, l&amp;rsquo;homme compris, descendent d&amp;rsquo;autres esp&amp;egrave;ces. Le premier, il rendit &amp;agrave; la science l&amp;rsquo;&amp;eacute;minent service de d&amp;eacute;clarer que tout changement dans le monde organique, aussi bien que dans le monde inorganique, est le r&amp;eacute;sultat d&amp;rsquo;une loi, et non d&amp;rsquo;une intervention miraculeuse. L&amp;rsquo;impossibilit&amp;eacute; d&amp;rsquo;&amp;eacute;tablir une distinction entre les esp&amp;egrave;ces et les vari&amp;eacute;t&amp;eacute;s, la gradation si parfaite des formes dans certains groupes, et l&amp;rsquo;analogie des productions domestiques, paraissent avoir conduit Lamarck &amp;agrave; ses conclusions sur les changements graduels des esp&amp;egrave;ces. Quant aux causes de la modification, il les chercha en partie dans l&amp;rsquo;action directe des conditions physiques d&amp;rsquo;existence, dans le croisement des formes d&amp;eacute;j&amp;agrave; existantes, et surtout dans l&amp;rsquo;usage et le d&amp;eacute;faut d&amp;rsquo;usage, c&amp;rsquo;est-&amp;agrave;-dire dans les effets de l&amp;rsquo;habitude. C&amp;rsquo;est &amp;agrave; cette derni&amp;egrave;re cause qu&amp;rsquo;il semble rattacher toutes les admirables adaptations de la nature, telles que le long cou de la girafe, qui lui permet de brouter les feuilles des arbres. Il admet &amp;eacute;galement une loi de d&amp;eacute;veloppement progressif&amp;nbsp;; or, comme toutes les formes de la vie tendent ainsi au perfectionnement, il explique l&amp;rsquo;existence actuelle d&amp;rsquo;organismes tr&amp;egrave;s simples par la g&amp;eacute;n&amp;eacute;ration spontan&amp;eacute;e.&lt;/span&gt;&lt;a id=\\&quot;footnote_2_call\\&quot; class=\\&quot;footnote msbooks-tabindex-restored\\&quot; style=\\&quot;color: #000000; font-family: \\\'Times New Roman\\\'; font-size: 10.06px; font-variant-numeric: normal; font-variant-east-asian: normal; text-align: justify; text-decoration-line: none; text-indent: 21.73px; vertical-align: super;\\&quot; tabindex=\\&quot;0\\&quot; href=\\&quot;ms-local-stream://EpubReader_5964532E702F4FE1AF3AC02CA1932068/Content/OPS/footnotes.xml#footnote_2\\&quot;&gt;[2]&lt;/a&gt;&lt;/p&gt;\r\n&lt;/blockquote&gt;\r\n&lt;p style=\\&quot;text-align: justify;\\&quot;&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;div style=\\&quot;color: #f8f8f2; background-color: #272822; font-family: Consolas, \\\'Courier New\\\', monospace; font-size: 14px; line-height: 19px; white-space: pre;\\&quot;&gt;\r\n&lt;div style=\\&quot;text-align: center;\\&quot;&gt;De l\\\'Origine des esp&amp;egrave;ces&lt;/div&gt;\r\n&lt;div style=\\&quot;text-align: center;\\&quot;&gt;Charles Darwin&lt;/div&gt;\r\n&lt;div style=\\&quot;text-align: center;\\&quot;&gt;(Traducteur: Edmond Barbier)&lt;/div&gt;\r\n&lt;br /&gt;&lt;br /&gt;\r\n&lt;div style=\\&quot;text-align: center;\\&quot;&gt;Publication: 1896&lt;/div&gt;\r\n&lt;/div&gt;','2019-02-26 06:58:07',1),(3,2,NULL,'&lt;h2 style=\\&quot;text-align: center;\\&quot;&gt;INTRODUCTION...&lt;/h2&gt;\r\n&lt;div class=\\&quot;text\\&quot; style=\\&quot;font-family: \\\'Times New Roman\\\'; font-size: 21.73px; font-variant-numeric: normal; font-variant-east-asian: normal; line-height: 32.59px; overflow: visible; break-after: avoid; text-align: justify;\\&quot;&gt;\r\n&lt;blockquote&gt;\r\n&lt;p class=\\&quot;MsoNormal\\&quot; style=\\&quot;font-size: 21.73px; line-height: 32.59px; margin-bottom: 0px; margin-top: 0px; text-indent: 21.73px;\\&quot;&gt;Les rapports g&amp;eacute;ologiques qui existent entre la faune actuelle et la faune &amp;eacute;teinte de l&amp;rsquo;Am&amp;eacute;rique m&amp;eacute;ridionale, ainsi que certains faits relatifs &amp;agrave; la distribution des &amp;ecirc;tres organis&amp;eacute;s qui peuplent ce continent, m&amp;rsquo;ont profond&amp;eacute;ment frapp&amp;eacute; lors mon voyage &amp;agrave; bord du navire le &lt;em&gt;Beagle&lt;/em&gt;&lt;a id=\\&quot;footnote_4_call\\&quot; class=\\&quot;footnote msbooks-tabindex-restored\\&quot; style=\\&quot;color: #000000; font-size: 10.06px; text-decoration-line: none; vertical-align: super;\\&quot; tabindex=\\&quot;0\\&quot; href=\\&quot;ms-local-stream://EpubReader_9689034C93B14C81881FCEBE8FB5CF1F/Content/OPS/footnotes.xml#footnote_4\\&quot;&gt;[4]&lt;/a&gt;, en qualit&amp;eacute; de naturaliste. Ces faits, comme on le verra dans les chapitres subs&amp;eacute;quents de ce volume, semblent jeter quelque lumi&amp;egrave;re sur l&amp;rsquo;origine des esp&amp;egrave;ces &amp;ndash; ce myst&amp;egrave;re des myst&amp;egrave;res &amp;ndash; pour employer l&amp;rsquo;expression de l&amp;rsquo;un de nos plus grands philosophes. &amp;Agrave; mon retour en Angleterre, en 1837, je pensai qu&amp;rsquo;en accumulant patiemment tous les faits relatifs &amp;agrave; ce sujet, qu&amp;rsquo;en les examinant sous toutes les faces, je pourrais peut-&amp;ecirc;tre arriver &amp;agrave; &amp;eacute;lucider cette question. Apr&amp;egrave;s cinq ann&amp;eacute;es d&amp;rsquo;un travail opini&amp;acirc;tre, je r&amp;eacute;digeai quelques notes ; puis, en 1844, je r&amp;eacute;sumai ces notes sous forme d&amp;rsquo;un m&amp;eacute;moire, o&amp;ugrave; j&amp;rsquo;indiquais les r&amp;eacute;sultats qui me semblaient offrir quelque degr&amp;eacute; de probabilit&amp;eacute; ; depuis cette &amp;eacute;poque, j&amp;rsquo;ai constamment poursuivi le m&amp;ecirc;me but. On m&amp;rsquo;excusera, je l&amp;rsquo;esp&amp;egrave;re, d&amp;rsquo;entrer dans ces d&amp;eacute;tails personnels ; si je le fais, c&amp;rsquo;est pour prouver que je n&amp;rsquo;ai pris aucune d&amp;eacute;cision &amp;agrave; la l&amp;eacute;g&amp;egrave;re.&lt;/p&gt;\r\n&lt;/blockquote&gt;\r\n&lt;p class=\\&quot;MsoNormal\\&quot; style=\\&quot;font-size: 21.73px; line-height: 32.59px; margin-bottom: 0px; margin-top: 0px; text-indent: 21.73px;\\&quot;&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;div style=\\&quot;color: #f8f8f2; background-color: #272822; font-family: Consolas, \\\'Courier New\\\', monospace; font-size: 14px; line-height: 19px; white-space: pre;\\&quot;&gt;\r\n&lt;div style=\\&quot;text-align: center;\\&quot;&gt;De l\\\'Origine des esp&amp;egrave;ces&lt;/div&gt;\r\n&lt;div style=\\&quot;text-align: center;\\&quot;&gt;Charles Darwin&lt;/div&gt;\r\n&lt;div style=\\&quot;text-align: center;\\&quot;&gt;(Traducteur: Edmond Barbier)&lt;/div&gt;\r\n&lt;br /&gt;\r\n&lt;div style=\\&quot;text-align: center;\\&quot;&gt;Publication: 1896&lt;/div&gt;\r\n&lt;/div&gt;\r\n&lt;/div&gt;','2019-02-26 07:59:46',1);
/*!40000 ALTER TABLE `parts` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `com_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID of the comment (as P_KEY)',
  `com_author` varchar(60) NOT NULL DEFAULT 'Guest' COMMENT 'Name of the author of the comment',
  `com_text` text NOT NULL COMMENT 'Html content of the comment',
  `com_flag` int(11) NOT NULL DEFAULT '0' COMMENT 'The flag counter (from users)',
  `com_muted` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'The muted status (from admin)',
  `com_modifier` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'TimeStamp of the last modification (as Index)',
  `com_part_id` int(11) DEFAULT NULL COMMENT 'ID from the parent part (as Foreign)',
  PRIMARY KEY (`com_id`),
  KEY `IDX_modifier` (`com_modifier`),
  KEY `IDX_part_id` (`com_part_id`),
  CONSTRAINT `F_KEY_part_id` FOREIGN KEY (`com_part_id`) REFERENCES `parts` (`part_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Contains definition of the part''s comment, need to be treated by DESC Timestamp.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,'Invité','\\&quot;Les espèces qui survivent ne sont pas les espèces les plus fortes, ni les plus intelligentes, mais celles qui s’adaptent le mieux aux changements.\\&quot;',0,0,'2019-02-28 12:03:50',1),(2,'Jean Rochefort','\\&quot;La sélection naturelle recherche, à chaque instant et dans le monde entier, les variations les plus légères; elle repousse celles qui sont nuisibles, elle conserve et accumule celles qui sont utiles.\\&quot;',0,0,'2019-02-28 12:04:21',1);
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-03-01 13:15:11
