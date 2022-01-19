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
-- Table structure for table `gb_qc_user_repeatability`
--

DROP TABLE IF EXISTS `gb_qc_user_repeatability`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gb_qc_user_repeatability` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `repeatability_counter` int(11) NOT NULL DEFAULT '100',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gb_qc_user_repeatability`
--

LOCK TABLES `gb_qc_user_repeatability` WRITE;
/*!40000 ALTER TABLE `gb_qc_user_repeatability` DISABLE KEYS */;
INSERT INTO `gb_qc_user_repeatability` VALUES (1,14,99),(2,18,0),(3,7,0),(4,42,0),(5,1,0),(6,47,0),(7,6,100),(8,15,77),(9,16,0),(10,48,0),(11,11,99),(12,9,70),(13,5,0),(14,50,0),(15,38,100),(16,49,75),(17,116,0),(18,98,100),(19,12,100),(20,25,100),(21,105,100),(22,130,100),(23,131,100),(24,87,100),(25,127,100),(26,139,0),(27,141,100),(28,162,100),(29,121,97),(30,163,0),(31,180,0),(32,187,99),(33,37,100),(34,216,100),(35,21,100),(36,217,100);
/*!40000 ALTER TABLE `gb_qc_user_repeatability` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-01-17 13:55:51
