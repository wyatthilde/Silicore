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
-- Table structure for table `gb_qc_thresholds`
--

DROP TABLE IF EXISTS `gb_qc_thresholds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gb_qc_thresholds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `screen` varchar(16) NOT NULL,
  `location_id` int(11) DEFAULT NULL,
  `low_threshold` double NOT NULL,
  `high_threshold` double NOT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gb_qc_thresholds`
--

LOCK TABLES `gb_qc_thresholds` WRITE;
/*!40000 ALTER TABLE `gb_qc_thresholds` DISABLE KEYS */;
INSERT INTO `gb_qc_thresholds` VALUES (1,'30',54,0.1,1,1),(2,'PAN',54,1,1,1),(3,'-40+70',54,0,0.96,1),(4,'30',14,0.1,1,1),(5,'PAN',14,1,1,1),(6,'-40+70',14,0,0.96,1),(7,'30',16,0.1,1,1),(8,'PAN',16,1,1,1),(9,'-40+70',16,0,0.96,1),(10,'30',101,0.1,1,1),(11,'PAN',101,1,1,1),(12,'-40+70',101,0,0.96,1),(13,'+70',55,1,0,1),(14,'-140',55,0,0.9,1),(15,'+70',13,0,0,1),(16,'-140',13,0,0.9,1),(17,'+70',102,0,0,1),(18,'-140',102,0,0.9,1),(19,'+70',103,0,0,1),(20,'-140',103,0,0.9,1),(21,'+70',50,0,0,1),(22,'-140',50,0,0.9,1),(23,'+70',3,0.8,1,1),(24,'+70',4,0.2,1,1),(25,'+70',20,0.8,1,1),(26,'+70',21,0.2,1,1),(27,'20',135,0.01,0.01,1);
/*!40000 ALTER TABLE `gb_qc_thresholds` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-01-17 14:00:59
