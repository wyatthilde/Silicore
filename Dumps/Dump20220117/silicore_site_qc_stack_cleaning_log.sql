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
-- Table structure for table `qc_stack_cleaning_log`
--

DROP TABLE IF EXISTS `qc_stack_cleaning_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `qc_stack_cleaning_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sieve_stack_id` int(11) NOT NULL,
  `site_id` int(11) DEFAULT NULL,
  `timestamp` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qc_stack_cleaning_log`
--

LOCK TABLES `qc_stack_cleaning_log` WRITE;
/*!40000 ALTER TABLE `qc_stack_cleaning_log` DISABLE KEYS */;
INSERT INTO `qc_stack_cleaning_log` VALUES (1,2054,20,'2018-09-19 10:53:43',121),(2,52,10,'2020-11-10 14:58:39',16),(3,50,10,'2020-11-10 14:58:51',16),(4,49,10,'2020-11-10 14:58:56',16),(5,53,10,'2020-11-10 14:59:06',16),(6,53,10,'2020-11-10 14:59:14',16),(7,5,10,'2020-11-10 14:59:45',16),(8,44,10,'2020-11-10 14:59:59',16),(9,2053,20,'2021-02-10 11:10:40',16),(10,39,10,'2021-02-10 11:23:50',16),(11,40,10,'2021-02-10 11:24:16',16),(12,1,10,'2021-02-10 11:24:45',16),(13,1,50,'2021-02-10 11:25:07',16),(14,1,60,'2021-02-10 11:25:25',16),(15,5,10,'2021-02-10 11:25:46',16),(16,49,10,'2021-02-10 11:26:03',16),(17,41,10,'2021-02-10 11:26:52',16),(18,50,10,'2021-02-10 11:31:03',16),(19,46,10,'2021-02-10 11:36:56',16),(20,40,10,'2021-02-23 10:05:26',16),(21,50,10,'2021-02-23 10:05:45',16),(22,49,10,'2021-02-23 10:05:58',16),(23,5,10,'2021-02-23 10:06:33',16),(24,2067,10,'2021-03-16 17:02:32',16),(25,23,60,'2021-05-16 13:56:47',162),(26,11,60,'2021-05-16 13:57:20',162),(27,20,60,'2021-05-16 13:58:00',162),(28,12,60,'2021-05-16 13:58:32',162),(29,18,60,'2021-05-17 09:00:17',162),(30,21,60,'2021-05-17 09:20:41',162),(31,2045,20,'2021-08-18 15:45:55',162),(32,20,60,'2021-08-19 05:21:13',162),(33,5,10,'2021-08-27 08:12:16',16),(34,49,10,'2022-01-14 08:10:36',16),(35,50,10,'2022-01-14 08:11:03',16),(36,40,10,'2022-01-14 08:11:31',16),(37,5,10,'2022-01-14 08:13:04',16),(38,2071,10,'2022-01-14 12:24:17',16),(39,2072,10,'2022-01-14 12:24:24',16),(40,46,10,'2022-01-14 12:25:03',16),(41,50,10,'2022-01-15 11:37:14',16),(42,40,10,'2022-01-15 11:37:31',16),(43,49,10,'2022-01-15 11:37:55',16),(44,4,50,'2022-01-15 11:40:47',16),(45,10,50,'2022-01-15 11:41:26',16),(46,2,50,'2022-01-15 11:41:46',16),(47,3,50,'2022-01-15 11:42:05',16),(48,9,50,'2022-01-15 11:43:52',16),(49,17,50,'2022-01-15 11:43:59',16),(50,8,50,'2022-01-15 11:44:28',16),(51,5,50,'2022-01-15 11:44:55',16),(52,11,50,'2022-01-15 11:45:26',16),(53,7,10,'2022-01-15 11:45:46',16),(54,8,10,'2022-01-15 11:46:07',16),(55,8,10,'2022-01-15 11:46:09',16),(56,7,50,'2022-01-15 11:46:27',16),(57,6,10,'2022-01-15 11:47:05',16),(58,6,50,'2022-01-15 11:48:11',16),(59,11,10,'2022-01-15 13:15:47',16);
/*!40000 ALTER TABLE `qc_stack_cleaning_log` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-01-17 13:53:36
