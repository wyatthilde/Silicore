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
-- Table structure for table `hr_departments`
--

DROP TABLE IF EXISTS `hr_departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hr_departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `main_department_id` int(11) DEFAULT NULL,
  `site_id` int(11) DEFAULT NULL,
  `department_display` varchar(64) DEFAULT NULL,
  `department` varchar(48) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hr_departments`
--

LOCK TABLES `hr_departments` WRITE;
/*!40000 ALTER TABLE `hr_departments` DISABLE KEYS */;
INSERT INTO `hr_departments` VALUES (1,4,1,'Quality Control','QC'),(2,1,1,'General & Administration','G&A'),(3,3,1,'Plant Management','Ops-Gen Plt Mgmt'),(4,3,1,'Pit','Pit Mining'),(5,3,1,'Wet Plant','Wet Plt'),(6,3,10,'Transload 58','Trnsld - 58'),(7,3,1,'Maintenance','Maintenance'),(8,4,3,'Quality Control','Tolar QC'),(9,3,3,'Wet Plant','Tolar Wet Plant'),(10,3,3,'Pit','Tolar Pit Mining'),(11,3,3,'Maintenance','Tolar Maintenance'),(12,3,3,'Plant Management','Tolar Gen Ops'),(13,4,2,'Quality Control','WTX QC'),(14,3,2,'Wet Plant','WTX Wet Plant'),(15,3,2,'Pit','WTX Pit Mining'),(16,3,2,'Loadout','WTX Loadout'),(17,3,2,'Maintenance','WTX Maintenance'),(18,3,2,'Plant Management','WTX OPS General'),(19,3,1,'Projects','Projects'),(20,3,2,'Projects','Projects'),(21,3,3,'Projects','Projects'),(22,3,1,'Transload 58','Trnsld - 58'),(23,1,2,'General & Administration','G&A'),(24,1,3,'General & Administration','G&A'),(25,1,4,'General & Administration','G&A'),(26,1,5,'General & Administration','G&A'),(27,1,6,'General & Administration','G&A'),(28,1,7,'General & Administration','G&A'),(29,1,8,'General & Administration','G&A'),(30,1,9,'General & Administration','G&A'),(31,1,10,'General & Administration','G&A'),(32,1,11,'General & Administration','G&A'),(33,1,12,'General & Administration','G&A'),(34,1,13,'General & Administration','G&A'),(35,1,14,'General & Administration','G&A'),(36,1,15,'General & Administration','G&A'),(37,1,16,'General & Administration','G&A'),(38,1,17,'General & Administration','G&A'),(39,1,18,'General & Administration','G&A'),(40,1,19,'General & Administration','G&A'),(41,1,20,'General & Administration','G&A'),(42,1,21,'General & Administration','G&A'),(43,3,1,'Contractor','Contractor'),(44,3,2,'Contractor','Contractor'),(45,3,3,'Contractor','Contractor'),(46,3,4,'Contractor','Contractor'),(47,3,5,'Contractor','Contractor'),(48,3,6,'Contractor','Contractor'),(49,3,7,'Contractor','Contractor'),(50,3,8,'Contractor','Contractor'),(51,3,9,'Contractor','Contractor'),(52,3,10,'Contractor','Contractor'),(53,3,11,'Contractor','Contractor'),(54,3,12,'Contractor','Contractor'),(55,3,13,'Contractor','Contractor'),(56,3,14,'Contractor','Contractor'),(57,3,15,'Contractor','Contractor'),(58,3,16,'Contractor','Contractor'),(59,3,17,'Contractor','Contractor'),(60,3,18,'Contractor','Contractor'),(61,3,19,'Contractor','Contractor'),(62,3,20,'Contractor','Contractor'),(63,3,21,'Contractor','Contractor'),(64,3,6,'Operations','Operations'),(65,3,7,'Operations','Operations'),(66,3,8,'Operations','Operations'),(67,3,9,'Operations','Operations'),(68,3,10,'Operations','Operations'),(69,3,11,'Operations','Operations'),(70,3,12,'Operations','Operations'),(71,3,13,'Operations','Operations'),(72,3,14,'Operations','Operations'),(73,3,15,'Operations','Operations'),(74,3,16,'Operations','Operations'),(75,3,17,'Operations','Operations');
/*!40000 ALTER TABLE `hr_departments` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-01-17 13:59:22
