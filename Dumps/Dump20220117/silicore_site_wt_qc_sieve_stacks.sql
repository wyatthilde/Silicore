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
-- Table structure for table `wt_qc_sieve_stacks`
--

DROP TABLE IF EXISTS `wt_qc_sieve_stacks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wt_qc_sieve_stacks` (
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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wt_qc_sieve_stacks`
--

LOCK TABLES `wt_qc_sieve_stacks` WRITE;
/*!40000 ALTER TABLE `wt_qc_sieve_stacks` DISABLE KEYS */;
INSERT INTO `wt_qc_sieve_stacks` VALUES (1,'Sieve Stack A',60,100,0,0,'2021-02-10 11:25:25',16,'2018-09-07 16:30:57',121,'2021-04-21 16:27:15',9),(2,'Sieve Stack B',60,200,0,0,'2018-09-19 11:00:01',121,'2018-09-07 16:30:57',121,'2021-04-21 16:26:57',9),(3,'West Texas Test Stack 1',60,10,0,0,'2018-09-19 11:00:01',121,'2018-09-10 14:00:05',121,'2021-04-21 16:26:42',9),(4,'XX_JDREW',60,10,0,0,'2021-03-10 15:10:17',NULL,'2021-03-10 15:10:17',9,'2021-04-21 16:26:24',9),(5,'WTx_Test_JDREW',60,10,0,0,'2021-03-16 09:23:56',NULL,'2021-03-16 09:23:56',9,'2021-04-21 16:26:07',9),(6,'210319_WTx_Test',60,10,0,0,'2021-03-19 09:56:35',NULL,'2021-03-19 09:56:35',9,'2021-04-21 16:25:51',9),(7,'Camsizer 100',60,10,0,0,'2021-03-22 10:07:54',NULL,'2021-03-22 10:07:54',16,'2021-04-21 16:25:27',9),(8,'Camsizer 4070',60,10,0,0,'2021-03-23 10:34:51',NULL,'2021-03-23 10:34:51',16,'2021-04-21 16:25:10',9),(10,'AC4',60,10,1,0,'2021-04-21 16:09:28',NULL,'2021-04-21 16:09:28',9,NULL,NULL),(11,'WTx Stack B',60,10,1,0,'2021-05-16 13:57:20',162,'2021-04-21 16:28:49',9,'2021-05-07 06:39:26',162),(12,'WTx Stack C',60,10,1,0,'2021-05-16 13:58:32',162,'2021-04-21 16:33:52',9,'2021-10-28 11:20:03',217),(13,'WTx Stack D',60,10,1,0,'2021-04-21 16:40:39',NULL,'2021-04-21 16:40:39',9,'2021-10-28 09:38:38',217),(14,'WTx Stack E',60,10,1,0,'2021-04-21 16:43:53',NULL,'2021-04-21 16:43:53',9,'2021-10-28 11:16:49',217),(15,'WTx Stack F',60,10,1,0,'2021-04-21 16:50:54',NULL,'2021-04-21 16:50:54',9,NULL,NULL),(16,'WTx Stack G',60,10,1,0,'2021-04-21 16:58:49',NULL,'2021-04-21 16:58:49',9,NULL,NULL),(17,'WTx Stack R',60,10,1,0,'2021-04-21 17:02:30',NULL,'2021-04-21 17:02:30',9,NULL,NULL),(18,'WTx Stack S',60,10,1,0,'2021-05-17 09:00:17',162,'2021-04-21 17:05:01',9,'2021-10-28 09:55:48',217),(19,'WTx Stack T',60,10,1,0,'2021-04-21 17:09:12',NULL,'2021-04-21 17:09:12',9,NULL,NULL),(20,'WTx Stack U',60,10,1,0,'2021-08-19 05:21:13',162,'2021-04-21 17:11:25',9,'2021-10-28 09:59:34',217),(21,'WTx Feed 1',60,10,1,0,'2021-05-17 09:20:41',162,'2021-04-21 17:13:44',9,'2021-05-07 06:43:49',162),(22,'WTx Feed 2',60,10,1,0,'2021-05-06 17:09:13',NULL,'2021-05-06 17:09:13',9,NULL,NULL),(23,'WTx Feed 3',60,10,1,0,'2021-05-16 13:56:47',162,'2021-05-06 17:21:07',9,NULL,NULL),(24,'AC5',60,10,1,0,'2021-06-16 16:11:15',NULL,'2021-06-16 16:11:15',9,'2021-10-28 09:35:06',217);
/*!40000 ALTER TABLE `wt_qc_sieve_stacks` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-01-17 13:55:57
