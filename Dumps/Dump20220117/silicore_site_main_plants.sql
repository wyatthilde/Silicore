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
-- Table structure for table `main_plants`
--

DROP TABLE IF EXISTS `main_plants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `main_plants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `main_site_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `description` varchar(256) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `tceq_max_tpy` int(11) DEFAULT NULL,
  `tceq_max_tph` int(11) DEFAULT NULL,
  `tceq_max_upy` int(11) DEFAULT NULL,
  `tceq_moisture_rate` decimal(5,2) NOT NULL DEFAULT '0.00',
  `tceq_description` varchar(256) DEFAULT NULL,
  `tceq_notes` varchar(512) DEFAULT NULL,
  `tceq_sort_order` int(11) DEFAULT NULL,
  `is_hidden` tinyint(4) DEFAULT '0',
  `create_date` datetime NOT NULL,
  `create_user_id` int(11) NOT NULL,
  `modify_date` datetime DEFAULT NULL,
  `modify_user_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `ix_main_plants_BYmain_site_id` (`main_site_id`),
  KEY `ix_main_plants_BYcreate_user_id` (`create_user_id`),
  KEY `ix_main_plants_BYmodify_user_id` (`modify_user_id`),
  CONSTRAINT `FK_MainPlants_MainSites` FOREIGN KEY (`main_site_id`) REFERENCES `main_sites` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_MainPlants_MainUsers_Create` FOREIGN KEY (`create_user_id`) REFERENCES `main_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_MainPlants_MainUsers_Modify` FOREIGN KEY (`modify_user_id`) REFERENCES `main_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `main_plants`
--

LOCK TABLES `main_plants` WRITE;
/*!40000 ALTER TABLE `main_plants` DISABLE KEYS */;
INSERT INTO `main_plants` VALUES (1,10,'Pit','Pit',0,NULL,NULL,NULL,0.05,NULL,'',0,0,'2018-01-26 15:57:30',11,NULL,NULL,0),(3,10,'Wet Plant 2','Wet Plant 2',20,2500000,350,7000,0.07,'Wet Plant #2 (New)','',20,0,'2018-01-26 15:57:30',11,NULL,NULL,1),(4,10,'Wet Plant 1','Wet Plant 1',10,2500000,350,7000,0.05,'Wet Plant #1 (Old)','',10,0,'2018-01-26 15:57:30',11,NULL,NULL,1),(5,10,'Dry Plant (Rotary)','Dry Plant (Rotary)',50,1400000,200,7000,0.05,'Drying Plant #3 (Rotary)[Removed]','',50,0,'2018-01-26 15:57:30',11,NULL,NULL,0),(6,10,'Carrier 1','Carrier 1',30,750000,110,7000,0.05,'Drying Plant #1 (Carrier #1)','',30,0,'2018-01-26 15:57:30',11,NULL,NULL,1),(7,10,'Rotary 1','Rotary 1',50,1500000,300,5000,0.05,'Drying Plant #3 (Rotary)','',50,0,'2018-01-26 15:57:30',11,NULL,NULL,1),(8,10,'Carrier 2','Carrier 2',40,750000,110,7000,0.05,'Drying Plant #4 (Carrier #2)','',40,0,'2018-01-26 15:57:30',11,NULL,NULL,1),(9,10,'Unknown','Unknown',99999,750000,110,7000,0.05,'Unknown','',99999,0,'2018-01-26 15:57:30',11,NULL,NULL,1),(10,20,'Railyard','Cresson Railyard',999,NULL,NULL,NULL,0.00,NULL,NULL,999,0,'2018-01-26 15:57:30',11,NULL,NULL,1),(11,50,'Wet Plant (Primary)','Wet Plant (Primary)',110,0,0,0,0.50,'Wet Plant (Primary)','',110,0,'2018-01-26 15:57:30',11,NULL,NULL,0),(12,50,'Wet Plant','Wet Plant',120,0,0,0,0.50,'Wet Plant','',120,0,'2018-01-26 15:57:30',11,NULL,NULL,1),(13,50,'UFR','UFR',130,0,0,0,0.50,'UFR','',130,0,'2018-01-26 15:57:30',11,NULL,NULL,1),(14,50,'Dry Plant','Dry Plant',140,0,0,0,0.50,'Dry Plant','',140,0,'2018-01-26 15:57:30',11,NULL,NULL,1),(15,50,'Load Out','Load Out',150,0,0,0,0.50,'Load Out','',150,0,'2018-01-26 15:57:30',11,NULL,NULL,1),(16,50,'Unknown','Unknown',199999,0,0,0,0.50,'Unknown','',199999,0,'2018-01-26 15:57:30',11,NULL,NULL,1),(17,50,'Pit','Pit',100,NULL,NULL,NULL,0.05,NULL,'',100,0,'2018-01-26 15:57:30',11,NULL,NULL,0),(18,60,'Pit','Pit',200,NULL,NULL,NULL,0.00,'Pit',NULL,200,0,'2018-01-26 15:57:30',11,NULL,NULL,1),(19,60,'Wet Plant (Primary)','Wet Plant (Primary)',210,NULL,NULL,NULL,0.00,'Wet Plant (Primary)',NULL,210,0,'2018-01-26 15:57:30',11,'2021-05-07 09:24:51',9,0),(20,60,'Wet Plant','Wet Plant',220,NULL,NULL,NULL,0.00,'Wet Plant',NULL,220,0,'2018-01-26 15:57:30',11,NULL,NULL,1),(21,60,'Dry Plant (Dryer AB)','Dry Plant (Dryer AB)',230,NULL,NULL,NULL,0.00,'Dry Plant (Dryer 1)',NULL,230,0,'2018-01-26 15:57:30',11,'2021-05-07 09:27:02',9,0),(22,60,'Dry Plant (Dryer C)','Dry Plant (Dryer C)',240,NULL,NULL,NULL,0.00,'Dry Plant (Dryer 2)',NULL,240,0,'2018-01-26 15:57:30',11,'2021-05-07 09:26:54',9,0),(23,60,'Dry Plant (Dryer D)','Dry Plant (Dryer D)',250,NULL,NULL,NULL,0.00,'Dry Plant (Dryer 3)',NULL,250,0,'2018-01-26 15:57:30',11,'2021-05-07 09:26:42',9,0),(24,60,'Loadout','Loadout',260,NULL,NULL,NULL,0.00,'Loadout',NULL,260,0,'2018-01-26 15:57:30',11,'2021-05-07 09:26:07',9,0),(25,60,'Unknown','Unknown',299999,NULL,NULL,NULL,0.00,'Unknown',NULL,299999,0,'2018-01-26 15:57:30',11,NULL,NULL,1),(26,60,'McCloskey','McCloskey',270,NULL,NULL,NULL,0.00,'Original McCloskey start up plant',NULL,270,0,'2018-01-26 15:57:30',11,'2021-05-07 09:25:59',9,0),(27,60,'UFR','UFR',225,0,0,0,0.50,'UFR','',225,0,'2018-01-15 11:47:30',11,'2021-05-07 09:27:30',9,0),(28,50,'Dry Plant (Dryer 1)','Dry Plant (Dryer 1)',122,NULL,NULL,NULL,0.00,'Dry Plant (Dryer 1)',NULL,122,0,'2018-01-26 15:57:30',11,NULL,NULL,1),(29,50,'Dry Plant (Dryer 2)','Dry Plant (Dryer 2)',124,NULL,NULL,NULL,0.00,'Dry Plant (Dryer 2)',NULL,124,0,'2018-01-26 15:57:30',11,NULL,NULL,1),(30,50,'Dry Plant (Dryer 3)','Dry Plant (Dryer 3)',126,NULL,NULL,NULL,0.00,'Dry Plant (Dryer 3)',NULL,126,0,'2018-01-26 15:57:30',11,NULL,NULL,1),(38,60,'Test Plant','Test Plant',300009,NULL,NULL,NULL,0.00,NULL,NULL,NULL,0,'2018-07-25 10:16:31',192,'2018-07-25 10:17:25',192,0),(39,20,'Test Plant2','Test Plant2',300019,NULL,NULL,NULL,0.00,NULL,NULL,NULL,0,'2018-07-26 16:33:46',192,NULL,NULL,1),(40,50,'Test Plant3','Test Plant3',300029,NULL,NULL,NULL,0.00,NULL,NULL,NULL,0,'2018-07-26 16:38:08',192,NULL,NULL,1),(41,60,'Test Plant4','Test Plant4',300039,NULL,NULL,NULL,0.00,NULL,NULL,NULL,0,'2018-07-26 16:38:32',192,NULL,NULL,1),(42,20,'Test Plant5','Test Plant5',300049,NULL,NULL,NULL,0.00,NULL,NULL,NULL,0,'2018-07-26 16:38:50',192,NULL,NULL,1),(43,20,'Test Plant','Test Plant',300059,NULL,NULL,NULL,0.00,NULL,NULL,NULL,0,'2018-07-27 11:47:48',192,NULL,NULL,1),(44,10,'Rotary','Rotary',300069,NULL,NULL,NULL,0.00,NULL,NULL,NULL,0,'2020-11-10 16:09:49',9,NULL,NULL,1),(45,60,'Dry Plant','Dry Plant',300079,NULL,NULL,NULL,0.00,NULL,NULL,NULL,0,'2021-04-21 11:23:18',9,NULL,NULL,1),(46,10,'Cresson Transload','Cresson Transload',300089,NULL,NULL,NULL,0.00,NULL,NULL,NULL,0,'2021-06-16 10:07:56',9,NULL,NULL,1);
/*!40000 ALTER TABLE `main_plants` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-01-17 13:56:12
