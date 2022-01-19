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
-- Table structure for table `prod_email_lists`
--

DROP TABLE IF EXISTS `prod_email_lists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prod_email_lists` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `description` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `create_dt` datetime DEFAULT NULL,
  `create_user_id` bigint(20) DEFAULT NULL,
  `edit_dt` datetime DEFAULT NULL,
  `edit_user_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `description` (`description`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prod_email_lists`
--

LOCK TABLES `prod_email_lists` WRITE;
/*!40000 ALTER TABLE `prod_email_lists` DISABLE KEYS */;
INSERT INTO `prod_email_lists` VALUES (1,'200',NULL,'2014-03-10 14:19:15',20,'2014-11-25 14:15:41',125),(2,'AR System Alerts','arsystemalerts@vistasand.com','2014-03-10 14:19:15',20,NULL,NULL),(3,'C4 QC Samples','c4qcsamples@vistasand.com','2014-03-10 14:19:15',20,NULL,NULL),(4,'WP Feed QC Samples','wetplantfeedqcsamples@vistasand.com','2014-03-10 14:19:15',20,'2014-10-15 08:34:19',20),(5,'Dry Plant',NULL,'2014-03-10 14:19:15',20,NULL,NULL),(6,'Dry Plant Status',NULL,'2014-03-10 14:19:15',20,NULL,NULL),(7,'EOG Transloads','eogtransload@vistasand.com','2014-03-10 14:19:15',20,NULL,NULL),(8,'EOG Unit Trains','eogunittrain@vistasand.com','2014-03-10 14:19:15',20,'2014-08-02 10:42:45',132),(9,'EOG West Texas','eogwesttexas@vistasand.com','2014-03-10 14:19:15',20,NULL,NULL),(10,'HR System Alerts','hrsystemalerts@vistasand.com','2014-03-10 14:19:15',20,'2015-01-26 12:24:03',20),(11,'Hall Tonnage Recap','halltonnagerecap@vistasand.com','2014-03-10 14:19:15',20,NULL,NULL),(12,'Halliburton (Enid/Woodward)','haliburtonok@vistasand.com','2014-03-10 14:19:15',20,'2015-05-20 15:01:23',248),(13,'Halliburton (Monohans)','haliburtonmonohans@vistasand.com','2014-03-10 14:19:15',20,NULL,NULL),(14,'Inventory Update','inventoryupdate@vistasand.com','2014-03-10 14:19:15',20,NULL,NULL),(15,'Latest QC Samples','qcsamples@vistasand.com','2014-03-10 14:19:15',20,NULL,NULL),(16,'Owner','owner@vistasand.com','2014-03-10 14:19:15',20,NULL,NULL),(18,'RJ',NULL,'2014-03-10 14:19:15',20,NULL,NULL),(20,'SH System Alerts','shsystemalerts@vistasand.com','2014-03-10 14:19:15',20,'2015-05-04 08:40:12',534),(22,'Silo-Trailer Update',NULL,'2014-03-10 14:19:15',20,'2014-11-25 14:54:41',20),(23,'Tanner',NULL,'2014-03-10 14:19:15',20,NULL,NULL),(24,'System Alerts','websitesystemalert@vistasand.com','2014-03-10 14:19:15',20,NULL,NULL),(25,'User Access Update','useraccessupdate@vistasand.com','2014-03-10 14:19:15',20,NULL,NULL),(26,'Management','manage@vistasand.com','2014-03-10 14:19:15',20,NULL,NULL),(27,'TMS Data Errors','tmsdatafeederrors@vistasand.com','2014-03-10 14:19:15',20,NULL,NULL),(28,'Momentive','momentive@vistasand.com','2014-04-28 11:58:35',20,'2015-04-23 08:26:43',248),(29,'Python Pressure Pumping','pythonpressure@vistasand.com','2014-06-02 11:25:40',20,NULL,NULL),(30,'Voided Tickets','voidedtickets@vistasand.com','2014-06-10 12:36:50',20,NULL,NULL),(31,'Duplicate Tickets','duplicatetickets@vistasand.com','2014-06-10 12:36:50',20,NULL,NULL),(32,'Cresson Facility','cressonfacilityalerts@vistasand.com','2014-07-28 15:38:00',20,NULL,NULL),(33,'Fort Stockon Facility','fortstocktonfac@vistasand.com','2014-07-28 15:38:00',20,'2014-10-06 18:54:20',248),(34,'Schlumberger','schlumberger@vistasand.com','2014-07-28 15:39:00',20,NULL,NULL),(35,'Apache ','apache@vistasand.com','2014-07-29 20:22:09',132,NULL,NULL),(37,'Rotary High Slimes','rotaryhighslimes@vistasand.com','2014-09-09 10:13:41',20,NULL,NULL),(38,'Lester Thomas',NULL,'2014-10-02 07:51:50',214,NULL,NULL),(39,'fortstocktonfacility',NULL,'2014-10-06 18:51:19',248,'2014-10-17 18:17:03',248),(40,'Rotary QC Oversize Out of Spec','rotartyqcoversize@vistasand.com','2014-10-09 09:46:01',20,'2014-10-09 11:13:40',20),(41,'Vista Hold Release','vistaholdrelease@vistasand.com','2014-10-23 03:40:34',248,'2014-10-23 03:47:52',248),(42,'AP System Alerts','apsystemalerts@vistasand.com','2014-11-04 13:15:10',20,NULL,NULL),(43,'James Hardie High Moisture Rate','jhhighmoist@vistasand.com','2014-11-11 15:00:36',20,NULL,NULL),(44,'Current Revenue Update','currentrevenueupdate@vistasand.com','2014-11-19 09:30:07',20,'2014-11-19 13:26:04',20),(45,'JWS Ticket Alerts','jwsticketalert@vistasand.com','2014-11-19 15:36:57',20,'2014-12-03 09:57:11',20),(47,'old wet plant','oldwetplant@vistasand.com','2014-12-15 12:32:04',23,NULL,NULL),(48,'Cresson Handheld Alerts','cressonhha@vistasand.com','2014-12-17 10:43:22',20,'2014-12-17 11:01:47',20),(49,'FuelMaster Alerts','fuelmasteralert@vistasand.com','2014-12-23 12:20:58',20,NULL,NULL),(50,'Visionlink Alerts','catvisionlinkalerts@vistasand.com','2014-12-23 13:31:22',20,NULL,NULL),(51,'Granbury New Rotary Moisture Control','roatarymoisture@vistasand.com','2015-03-19 12:22:13',20,'2015-03-19 16:35:14',20),(52,'gGranbury New Rotary Moisture Control',NULL,'2015-06-30 16:24:00',538,NULL,NULL),(53,'devtest','developmenttest@vistasand.com','2015-06-30 16:40:21',538,NULL,NULL),(54,'testkarl','kkuehn@vistasand.com','2017-05-12 12:01:01',603,NULL,NULL);
/*!40000 ALTER TABLE `prod_email_lists` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-01-17 13:56:00
