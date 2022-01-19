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
-- Table structure for table `prod_dispatch_loads`
--

DROP TABLE IF EXISTS `prod_dispatch_loads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prod_dispatch_loads` (
  `id` int(11) NOT NULL,
  `load_no` varchar(20) NOT NULL,
  `description` varchar(50) DEFAULT NULL,
  `po_id` bigint(20) DEFAULT NULL,
  `po_no` varchar(20) DEFAULT NULL,
  `po_modifier` varchar(6) DEFAULT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `customer` varchar(50) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `material_no` varchar(20) DEFAULT NULL,
  `customer_product_id` bigint(20) DEFAULT NULL,
  `pounds` decimal(8,1) DEFAULT NULL,
  `tons` decimal(5,2) DEFAULT NULL,
  `site_id` int(11) DEFAULT NULL,
  `destination_id` bigint(20) DEFAULT NULL,
  `destination` varchar(50) DEFAULT NULL,
  `estimated_arrival_date` date DEFAULT NULL,
  `estimated_arrival_dt` datetime DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `delivery_dt` datetime DEFAULT NULL,
  `delivery_dt_original` datetime DEFAULT NULL,
  `delivery_dt_utc` datetime DEFAULT NULL,
  `expected_start_dt_utc` datetime DEFAULT NULL,
  `expected_end_dt_utc` datetime DEFAULT NULL,
  `priority` tinyint(2) NOT NULL DEFAULT '10',
  `is_roll_forward` varchar(1) NOT NULL DEFAULT 'N',
  `roll_forward_end_date` date DEFAULT NULL,
  `roll_forward_end_date_utc` date DEFAULT NULL,
  `carrier_id` bigint(20) DEFAULT NULL,
  `carrier` varchar(64) DEFAULT NULL,
  `vehicle_no` int(11) DEFAULT NULL,
  `driver_id` bigint(20) DEFAULT NULL,
  `driver_user_id` bigint(20) DEFAULT NULL,
  `ticket_ok_status_code` varchar(1) DEFAULT NULL,
  `tax_code_id` varchar(15) NOT NULL DEFAULT 'EXEMPT',
  `freight_fob` varchar(1) NOT NULL DEFAULT 'P',
  `edit_status_code` varchar(1) NOT NULL DEFAULT 'N',
  `sent_dt` datetime DEFAULT NULL,
  `create_dt` datetime NOT NULL,
  `create_user_id` bigint(20) DEFAULT NULL,
  `edit_dt` datetime DEFAULT NULL,
  `edit_user_id` bigint(20) DEFAULT NULL,
  `manual_edit_dt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `material_no` (`material_no`),
  KEY `customer_id` (`customer_id`),
  KEY `delivery_date` (`delivery_date`),
  KEY `driver_id` (`driver_id`),
  KEY `carrier_id` (`carrier_id`),
  KEY `edit_status_code` (`edit_status_code`),
  KEY `po_id` (`po_id`),
  KEY `ticket_ok_status_code` (`ticket_ok_status_code`),
  KEY `product_id` (`product_id`),
  KEY `vehicle_no` (`vehicle_no`),
  KEY `site_id` (`site_id`),
  KEY `driver_user_id` (`driver_user_id`),
  KEY `destination_id` (`destination_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prod_dispatch_loads`
--

LOCK TABLES `prod_dispatch_loads` WRITE;
/*!40000 ALTER TABLE `prod_dispatch_loads` DISABLE KEYS */;
/*!40000 ALTER TABLE `prod_dispatch_loads` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-01-17 13:58:35
