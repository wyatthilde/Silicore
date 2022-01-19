CREATE DATABASE  IF NOT EXISTS `silicore_site` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `silicore_site`;
-- MySQL dump 10.13  Distrib 8.0.25, for Win64 (x86_64)
--
-- Host: localhost    Database: silicore_site
-- ------------------------------------------------------
-- Server version	5.7.22-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `main_documents`
--

DROP TABLE IF EXISTS `main_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `main_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_name` varchar(64) NOT NULL,
  `doc_ext` varchar(4) NOT NULL,
  `doc_type` varchar(45) NOT NULL,
  `doc_description` varchar(1024) NOT NULL,
  `doc_size` int(11) NOT NULL,
  `doc_path` varchar(128) NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT '0',
  `dept_id` int(11) NOT NULL,
  `uses` int(11) DEFAULT '0',
  `is_active` varchar(45) NOT NULL DEFAULT '0',
  `last_access` datetime DEFAULT NULL,
  `create_date` datetime NOT NULL,
  `create_user_id` int(11) NOT NULL,
  `modify_date` datetime DEFAULT NULL,
  `modify_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `main_documents`
--

LOCK TABLES `main_documents` WRITE;
/*!40000 ALTER TABLE `main_documents` DISABLE KEYS */;
INSERT INTO `main_documents` VALUES (51,'Silicore','pdf','PDF','Silicone',12527,'../../Files/Archive/Silicore_nolliff_181127150731.pdf',16,4,2,'0','2018-11-27 15:08:01','2018-11-27 15:07:31',25,'2018-11-27 15:08:24',25),(52,'pdf-sample','pdf','PDF','Sample',7945,'../../Files/Archive/pdf-sample_nolliff_181127151431.pdf',16,4,2,'0','2018-11-27 15:14:08','2018-11-27 15:13:55',25,'2018-11-27 15:14:46',25),(53,'pdf-sample','pdf','PDF','sample',7945,'../../Files/QC/pdf-sample_nolliff_181127151527.pdf',16,4,12,'1','2021-12-18 14:54:54','2018-11-27 15:15:27',25,'2018-11-27 15:45:57',25),(54,'VPROP 2018 Carrier Contact Information','pdf','PDF','Silicor',86600,'../../Files/Archive/VPROP 2018 Carrier Contact Information_nolliff_181128144427.pdf',16,4,2,'0','2018-11-28 14:39:05','2018-11-28 14:38:56',25,'2018-11-28 14:44:39',25),(55,'Silicore','pdf','PDF','Silicore',12527,'../../Files/QC/Silicore_nolliff_181129061227.pdf',16,4,3,'1','2021-11-01 13:02:21','2018-11-29 06:12:27',25,NULL,NULL),(56,'ASTM D 1556 Sand-Cone','pdf','PDF','ASTM D 1556',65610,'../../Files/Archive/ASTM D 1556 Sand-Cone_jdrew_210826145500.pdf',16,4,1,'0','2021-08-26 14:55:12','2021-08-26 14:55:00',9,'2021-08-26 14:55:25',9),(57,'ASTM D 1556 Sand-Cone','pdf','PDF','XX DELETE',65610,'../../Files/Archive/ASTM D 1556 Sand-Cone_jdrew_210826145554.pdf',16,4,1,'0','2021-08-26 14:55:59','2021-08-26 14:55:54',9,'2021-08-26 14:56:16',9),(58,'ASTM D 1556 Sand-Cone','pdf','PDF','xx DELETE',65610,'../../Files/Archive/ASTM D 1556 Sand-Cone_jdrew_210826145633.pdf',16,4,0,'0',NULL,'2021-08-26 14:56:33',9,'2021-08-26 14:57:09',9);
/*!40000 ALTER TABLE `main_documents` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-01-17 13:53:28
