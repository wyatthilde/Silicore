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
-- Table structure for table `it_network_maps`
--

DROP TABLE IF EXISTS `it_network_maps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `it_network_maps` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `model` varchar(45) NOT NULL,
  `main_location_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `it_network_maps`
--

LOCK TABLES `it_network_maps` WRITE;
/*!40000 ALTER TABLE `it_network_maps` DISABLE KEYS */;
INSERT INTO `it_network_maps` VALUES (1,'Dry Plant','JL322A Aruba 2930M 48G PoE + 1 Slot Switch',1,NULL,1,'192.168.97.250'),(2,'Warehouse','J9727A 2920-24G PoE+',1,1,1,'192.168.97.245'),(3,'QC','J9727A 2920-24G PoE+',1,2,1,'192.168.97.244'),(4,'Operations','JL322A Aruba 2930M 48G PoE + 1 Slot Switch',1,1,1,'192.168.97.249'),(5,'Main Office','JL322A Aruba 2930M 48G PoE + 1 Slot Switch',1,4,1,'192.168.97.248'),(6,'IT Room','J9727A 2920-24G PoE+',1,5,1,'192.168.97.246'),(7,'IT Room Bench','Unknown',1,6,1,'192.168.97.253'),(8,'Human Resources & Safety','J9727A 2920-24G PoE+',1,4,1,'192.168.97.252'),(9,'New Operations','JL322A Aruba 2930M 48G PoE + 1 Slot Switch',1,4,1,'192.168.97.247'),(10,'Operations Conference','JL322A Aruba 2930M 48G PoE + 1 Slot Switch',1,4,1,'192.168.97.252');
/*!40000 ALTER TABLE `it_network_maps` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-01-17 14:01:50
