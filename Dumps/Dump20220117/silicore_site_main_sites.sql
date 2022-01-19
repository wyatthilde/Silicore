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
-- Table structure for table `main_sites`
--

DROP TABLE IF EXISTS `main_sites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `main_sites` (
  `id` int(11) NOT NULL,
  `description` varchar(64) NOT NULL,
  `is_vista_site` tinyint(1) NOT NULL,
  `is_qc_samples_site` tinyint(1) NOT NULL,
  `local_network` varchar(60) DEFAULT NULL,
  `sort_order` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `create_date` datetime DEFAULT NULL,
  `create_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `main_sites`
--

LOCK TABLES `main_sites` WRITE;
/*!40000 ALTER TABLE `main_sites` DISABLE KEYS */;
INSERT INTO `main_sites` VALUES (10,'Granbury',1,1,'192.168.97,192.168.98,192.168.30',0,1,NULL,NULL),(11,'Fort Worth North',1,0,NULL,100,1,NULL,NULL),(12,'Fort Worth South',1,0,NULL,200,1,NULL,NULL),(13,'Cleburne',1,0,NULL,300,1,NULL,NULL),(14,'Gardendale',1,0,NULL,310,1,NULL,NULL),(15,'Big Spring',1,0,NULL,320,1,NULL,NULL),(16,'Enid',1,0,NULL,330,1,NULL,NULL),(17,'Sweetwater',1,0,NULL,340,1,NULL,NULL),(18,'Dilley',1,0,NULL,350,1,NULL,NULL),(19,'Pecos',1,0,NULL,360,1,NULL,NULL),(20,'Cresson',1,1,'192.168.22,192.168.2',400,1,NULL,NULL),(25,'Big Lake',1,0,NULL,450,1,NULL,NULL),(26,'Barnhart',1,0,NULL,460,1,NULL,NULL),(30,'Fort Stockon',1,0,'10.221.14',500,1,NULL,NULL),(40,'Corporate',1,0,'192.168.88',1000,1,NULL,NULL),(50,'Tolar',1,1,'192.168.21',50,1,NULL,NULL),(60,'West Texas',1,1,'192.168.113',60,1,NULL,NULL),(210,'Momentive',0,0,NULL,600,1,NULL,NULL),(700,'Tidewater San Angelo',0,0,NULL,700,1,NULL,NULL),(701,'Pinnacle San Angelo',0,0,NULL,701,1,NULL,NULL),(998,'Unknown Sample Site',0,1,NULL,950,1,NULL,NULL),(999,'Unknown/Customer',0,1,NULL,999,1,NULL,NULL),(1000,'Test',1,1,NULL,1010,1,'2018-07-26 16:39:32',192),(1001,'Test Site',1,1,NULL,1020,1,'2018-07-27 11:48:56',192);
/*!40000 ALTER TABLE `main_sites` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-01-17 13:54:33
