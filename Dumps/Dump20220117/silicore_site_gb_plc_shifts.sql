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
-- Table structure for table `gb_plc_shifts`
--

DROP TABLE IF EXISTS `gb_plc_shifts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gb_plc_shifts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prod_area_id` int(3) NOT NULL,
  `plant_id` int(3) NOT NULL,
  `is_day` tinyint(1) NOT NULL,
  `start_dt` datetime NOT NULL,
  `end_dt` datetime DEFAULT NULL,
  `operator` varchar(64) NOT NULL,
  `duration_minutes` int(5) DEFAULT '0',
  `duration` decimal(5,2) DEFAULT '0.00',
  `uptime` decimal(5,2) DEFAULT '0.00',
  `downtime` decimal(5,2) DEFAULT '0.00',
  `schdowntime` decimal(5,2) DEFAULT '0.00',
  `idletime` decimal(5,2) DEFAULT '0.00',
  `is_removed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `ix_gb_plc_shifts_BYplant_id` (`plant_id`),
  CONSTRAINT `FK_GbPlcShifts_MainPlants` FOREIGN KEY (`plant_id`) REFERENCES `main_plants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=22364 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gb_plc_shifts`
--

LOCK TABLES `gb_plc_shifts` WRITE;
/*!40000 ALTER TABLE `gb_plc_shifts` DISABLE KEYS */;
INSERT INTO `gb_plc_shifts` VALUES (22287,1,0,1,'2017-12-26 05:30:25','2017-12-26 17:18:00','Shawn Samples',708,11.80,697.00,11.00,0.00,0.00,0),(22288,5,0,1,'2017-12-26 05:31:38','2017-12-26 17:28:46','No Ton Justin',717,11.95,696.00,21.00,0.00,0.00,0),(22289,6,0,1,'2017-12-26 05:31:47','2017-12-26 17:28:56','Justin',717,11.95,351.00,366.00,0.00,0.00,0),(22290,8,0,1,'2017-12-26 05:32:07','2017-12-26 17:28:58','Justin',716,11.93,716.00,0.00,0.00,0.00,0),(22292,1,0,0,'2017-12-26 17:18:03','2017-12-27 05:31:33','Joaquin Antillon',733,12.22,731.00,2.00,0.00,0.00,0),(22293,5,0,0,'2017-12-26 17:28:46','2017-12-27 05:31:38','NO Nilla Ice',723,12.05,483.00,224.00,0.00,16.00,0),(22294,6,0,0,'2017-12-26 17:28:56','2017-12-27 05:31:50','Ryan',723,12.05,430.00,293.00,0.00,0.00,0),(22296,8,0,0,'2017-12-26 17:29:02','2017-12-27 05:32:19','Ryan',723,12.05,655.00,68.00,0.00,0.00,0),(22297,1,0,1,'2017-12-27 05:31:33','2017-12-27 17:22:14','Shawn Samples',711,11.85,641.00,70.00,0.00,0.00,0),(22301,6,0,1,'2017-12-27 05:32:30','2017-12-27 17:30:17','Justin',718,11.97,10.00,0.00,0.00,708.00,0),(22302,5,0,1,'2017-12-27 05:32:31','2017-12-27 17:30:05','No Ton Justin',718,11.97,11.00,0.00,0.00,707.00,0),(22303,8,0,1,'2017-12-27 05:32:32','2017-12-27 17:30:19','Justin',718,11.97,718.00,0.00,0.00,0.00,0),(22305,1,0,0,'2017-12-27 17:22:15','2017-12-28 05:22:41','Joaquin Antillon',720,12.00,720.00,0.00,0.00,0.00,0),(22306,5,0,0,'2017-12-27 17:30:05','2017-12-28 05:29:43','NO Nilla Ice',719,11.98,10.00,0.00,0.00,709.00,0),(22307,6,0,0,'2017-12-27 17:30:17','2017-12-28 05:30:02','Ryan',720,12.00,11.00,0.00,0.00,709.00,0),(22308,8,0,0,'2017-12-27 17:30:19','2017-12-28 05:30:13','Ryan',720,12.00,590.00,130.00,0.00,0.00,0),(22309,1,0,1,'2017-12-28 05:22:41','2017-12-28 17:34:19','Ben Jordan',732,12.20,732.00,0.00,0.00,0.00,0),(22310,5,0,1,'2017-12-28 05:29:43','2017-12-28 17:34:55',' Dry Plant Jimmy',725,12.08,10.00,715.00,0.00,0.00,0),(22311,6,0,1,'2017-12-28 05:30:02','2017-12-28 17:35:13','Jimmy',725,12.08,11.00,714.00,0.00,0.00,0),(22312,8,0,1,'2017-12-28 05:30:13','2017-12-28 17:35:16','Jimmy',725,12.08,699.00,26.00,0.00,0.00,0),(22314,1,0,0,'2017-12-28 17:34:21','2017-12-29 05:30:53','John Sanchez',716,11.93,716.00,0.00,0.00,0.00,0),(22315,5,0,0,'2017-12-28 17:34:55','2017-12-29 05:49:57','BIG PAPI',735,12.25,354.00,0.00,0.00,381.00,0),(22316,6,0,0,'2017-12-28 17:35:13','2017-12-29 05:44:15','Luis',729,12.15,148.00,581.00,0.00,0.00,0),(22318,8,0,0,'2017-12-28 17:35:22','2017-12-29 05:44:21','Luis',729,12.15,608.00,121.00,0.00,0.00,0),(22320,1,0,1,'2017-12-29 05:31:06','2017-12-29 06:57:10','Ben Jordan',86,1.43,86.00,0.00,0.00,0.00,0),(22321,6,0,1,'2017-12-29 05:44:15','2017-12-29 17:32:25','Jimmy',708,11.80,680.00,28.00,0.00,0.00,0),(22322,8,0,1,'2017-12-29 05:44:21','2017-12-29 17:32:27','Jimmy',708,11.80,621.00,87.00,0.00,0.00,0),(22324,5,0,1,'2017-12-29 05:49:57','2017-12-29 17:32:03',' Dry Plant Jimmy',703,11.72,666.00,37.00,0.00,0.00,0),(22325,1,0,0,'2017-12-29 06:57:10','2017-12-29 17:53:11','Ben Jordan',656,10.93,15.00,641.00,0.00,0.00,0),(22326,5,0,0,'2017-12-29 17:32:03','2017-12-30 05:31:39','BIG PAPI',719,11.98,719.00,0.00,0.00,0.00,0),(22327,6,0,0,'2017-12-29 17:32:25','2017-12-30 05:31:47','Luis',719,11.98,719.00,0.00,0.00,0.00,0),(22328,8,0,0,'2017-12-29 17:32:27','2017-12-30 05:31:52','Luis',719,11.98,698.00,21.00,0.00,0.00,0),(22333,1,0,0,'2017-12-29 17:53:12','2017-12-30 05:30:32','John Sanchez',697,11.62,217.00,480.00,0.00,0.00,0),(22345,1,0,1,'2017-12-30 05:30:46','2017-12-30 17:31:55','Ben Jordan',721,12.02,721.00,0.00,0.00,0.00,0),(22346,5,0,1,'2017-12-30 05:31:39','2017-12-30 17:33:46',' Dry Plant Jimmy',722,12.03,598.00,124.00,0.00,0.00,0),(22347,6,0,1,'2017-12-30 05:31:47','2017-12-30 17:33:55','Jimmy',722,12.03,715.00,7.00,0.00,0.00,0),(22348,8,0,1,'2017-12-30 05:31:52','2017-12-30 17:33:56','Jimmy',722,12.03,722.00,0.00,0.00,0.00,0),(22351,1,0,0,'2017-12-30 17:32:01','2017-12-31 05:55:17','John Sanchez',743,12.38,743.00,0.00,0.00,0.00,0),(22352,5,0,0,'2017-12-30 17:33:46','2017-12-31 05:32:19','BIG PAPI',719,11.98,12.00,707.00,0.00,0.00,0),(22353,6,0,0,'2017-12-30 17:33:55','2017-12-31 05:32:21','Luis',719,11.98,719.00,0.00,0.00,0.00,0),(22354,8,0,0,'2017-12-30 17:33:57','2017-12-31 05:32:22','Luis',719,11.98,647.00,72.00,0.00,0.00,0),(22355,5,0,1,'2017-12-31 05:32:19','2017-12-31 09:39:51',' Dry Plant Jimmy',247,4.12,1.00,246.00,0.00,0.00,0),(22356,6,0,1,'2017-12-31 05:32:21','2017-12-31 17:43:48','Jimmy',731,12.18,659.00,72.00,0.00,0.00,0),(22358,8,0,1,'2017-12-31 05:32:25','2017-12-31 17:44:03','Jimmy',732,12.20,670.00,62.00,0.00,0.00,0),(22362,1,0,1,'2017-12-31 05:55:31','2017-12-31 17:42:38','Ben Jordan',707,11.78,82.00,625.00,0.00,0.00,0),(22363,5,0,0,'2017-12-31 09:39:51','2017-12-31 17:43:35',' Dry Plant Jimmy',484,8.07,13.00,471.00,0.00,0.00,0);
/*!40000 ALTER TABLE `gb_plc_shifts` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-01-17 14:01:42
