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
-- Table structure for table `tl_qc_sieve_stacks`
--

DROP TABLE IF EXISTS `tl_qc_sieve_stacks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tl_qc_sieve_stacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(64) NOT NULL,
  `main_site_id` int(11) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT '10',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_camsizer` tinyint(1) NOT NULL DEFAULT '0',
  `last_cleaned` datetime DEFAULT NULL,
  `last_cleaned_by` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `create_user_id` int(11) DEFAULT NULL,
  `modify_date` datetime DEFAULT NULL,
  `modify_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_index` (`description`,`main_site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tl_qc_sieve_stacks`
--

LOCK TABLES `tl_qc_sieve_stacks` WRITE;
/*!40000 ALTER TABLE `tl_qc_sieve_stacks` DISABLE KEYS */;
INSERT INTO `tl_qc_sieve_stacks` VALUES (1,'Fine Sample Sieve 1',50,100,0,0,'2021-02-10 11:25:07',16,'2018-09-07 16:30:57',121,'2019-04-08 13:39:17',121),(2,'Fine Sample Sieve 2',50,1500,1,0,'2022-01-15 11:41:46',16,'2018-09-07 16:30:57',121,NULL,NULL),(3,'Fine Sample Sieve 3',50,2900,1,0,'2022-01-15 11:42:05',16,'2018-09-07 16:30:57',121,NULL,NULL),(4,'Fine Sample Sieve 4',50,4300,1,0,'2022-01-15 11:40:47',16,'2018-09-07 16:30:57',121,NULL,NULL),(5,'Fine Sample Sieve 5',50,5700,1,0,'2022-01-15 11:44:55',16,'2018-09-07 16:30:57',121,NULL,NULL),(6,'Fine Sample Sieve 6',50,7000,1,0,'2022-01-15 11:48:11',16,'2018-09-07 16:30:57',121,NULL,NULL),(7,'Fine Sample Sieve 7',50,8300,1,0,'2022-01-15 11:46:27',16,'2018-09-07 16:30:57',121,NULL,NULL),(8,'Sieve Set B',50,9600,1,0,'2022-01-15 11:44:28',16,'2018-09-07 16:30:57',121,NULL,NULL),(9,'Sieve Set C',50,10600,1,0,'2022-01-15 11:43:52',16,'2018-09-07 16:30:57',121,NULL,NULL),(10,'Sieve Set D',50,11600,1,0,'2022-01-15 11:41:26',16,'2018-09-07 16:30:57',121,NULL,NULL),(11,'Sieve Set A',50,12600,1,0,'2022-01-15 11:45:26',16,'2018-09-07 16:30:57',121,NULL,NULL),(12,'Camsizer (Wet Plant & 100)',50,12700,1,1,'2018-09-19 11:00:01',121,'2018-09-07 16:30:57',121,NULL,NULL),(13,'Tolar Test Stack',50,10,1,0,'2018-09-19 11:00:01',121,'2018-09-10 13:38:38',121,NULL,NULL),(14,'',50,10,1,0,'2021-03-16 08:43:41',NULL,'2021-03-16 08:43:41',9,NULL,NULL),(15,'Camsizer 100',50,10,1,0,'2021-03-23 10:47:25',NULL,'2021-03-23 10:47:25',16,NULL,NULL),(16,'Tolar_Test_JDD',50,10,1,0,'2021-04-16 13:52:36',NULL,'2021-04-16 13:52:36',9,NULL,NULL),(17,'Sieve Set E',50,10,1,0,'2022-01-15 11:43:59',16,'2021-10-27 10:17:13',16,NULL,NULL);
/*!40000 ALTER TABLE `tl_qc_sieve_stacks` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-01-17 14:01:24
