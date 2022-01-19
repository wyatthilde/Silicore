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
-- Table structure for table `tl_qc_locations`
--

DROP TABLE IF EXISTS `tl_qc_locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tl_qc_locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(256) NOT NULL,
  `main_site_id` int(11) DEFAULT NULL,
  `main_plant_id` int(11) NOT NULL,
  `main_product_id` int(11) DEFAULT NULL,
  `type_code` varchar(2) DEFAULT NULL,
  `is_split_sample_only` tinyint(1) DEFAULT '0',
  `email_list_id` int(11) DEFAULT NULL,
  `is_send_email` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `send_completion_message` tinyint(1) DEFAULT '1',
  `create_date` datetime DEFAULT NULL,
  `create_user_id` int(11) DEFAULT NULL,
  `modify_date` datetime DEFAULT NULL,
  `modify_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `plant_id` (`main_plant_id`),
  KEY `site_id` (`main_site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tl_qc_locations`
--

LOCK TABLES `tl_qc_locations` WRITE;
/*!40000 ALTER TABLE `tl_qc_locations` DISABLE KEYS */;
INSERT INTO `tl_qc_locations` VALUES (1,'Pit',50,16,0,'S',0,0,0,100,1,1,NULL,NULL,NULL,NULL),(2,'Belt Feed',50,12,0,'S',0,0,0,50,1,1,NULL,NULL,NULL,NULL),(3,'Primary Cyclone Feed',50,12,0,'S',0,0,0,100,1,1,NULL,NULL,NULL,NULL),(4,'Primary Cyclone Unders',50,12,0,'S',0,0,0,150,1,1,NULL,NULL,NULL,NULL),(5,'Primary Cyclone Overs',50,12,0,'S',0,0,0,200,1,1,NULL,NULL,NULL,NULL),(6,'Attrition Cell Discharge',50,12,0,'S',0,0,0,250,1,1,NULL,NULL,NULL,NULL),(7,'Secondary Cyclone Overs',50,12,0,'S',0,0,0,300,1,1,NULL,NULL,NULL,NULL),(8,'Wet Plant Product',50,12,0,'S',0,0,0,350,1,1,NULL,NULL,NULL,NULL),(9,'UFR Feed',50,13,0,'S',0,0,0,400,1,1,NULL,NULL,NULL,NULL),(10,'UFR Product',50,13,0,'S',0,0,0,450,1,1,NULL,NULL,NULL,NULL),(12,'Press Cake Moisture',50,13,0,'S',0,0,0,500,1,1,NULL,NULL,NULL,NULL),(13,'Rotary Feed',50,14,0,'S',0,0,0,550,1,1,NULL,NULL,NULL,NULL),(14,'Rotary 2 Feed',50,14,0,'S',0,0,0,600,1,1,NULL,NULL,NULL,NULL),(15,'Baghouse Fines',50,14,0,'S',0,0,0,650,1,1,NULL,NULL,NULL,NULL),(16,'Dry Mill Trash',50,14,0,'S',0,0,0,700,1,1,NULL,NULL,NULL,NULL),(17,'100 Mesh Product',50,14,0,'S',0,0,0,750,1,1,NULL,NULL,NULL,NULL),(18,'Rail Car 100 Mesh',50,15,0,'S',0,0,0,800,1,1,NULL,NULL,NULL,NULL),(19,'Generic Sample',50,14,0,'S',0,0,0,500,1,1,NULL,NULL,NULL,NULL),(20,'Unknown',50,15,0,'S',0,0,0,500,1,1,NULL,NULL,NULL,NULL),(21,'De-Watering Screen 1',50,12,0,'S',0,0,0,100,1,1,NULL,NULL,NULL,NULL),(22,'De-Watering Screen 2',50,12,0,'S',0,0,0,110,1,1,NULL,NULL,NULL,NULL),(35,'Test Description',50,12,NULL,NULL,0,NULL,1,810,0,1,'2018-07-25 10:14:39',192,'2018-07-25 10:14:44',192),(36,'&quot;Test\'?&quot;',50,12,NULL,NULL,0,NULL,1,820,0,1,'2018-07-26 16:32:26',192,'2018-07-26 16:32:36',192),(37,'Test Description',50,13,NULL,NULL,0,NULL,1,830,0,1,'2018-07-27 11:43:54',192,'2018-07-27 11:44:03',192);
/*!40000 ALTER TABLE `tl_qc_locations` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-01-17 13:54:25
