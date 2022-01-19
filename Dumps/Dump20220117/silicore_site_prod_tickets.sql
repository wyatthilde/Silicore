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
-- Table structure for table `prod_tickets`
--

DROP TABLE IF EXISTS `prod_tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prod_tickets` (
  `ticket_no` varchar(15) NOT NULL DEFAULT '0' COMMENT 'BOL #, required',
  `load_id` int(11) DEFAULT NULL,
  `rail_car_release_id` bigint(20) DEFAULT NULL,
  `invoice_id` bigint(20) DEFAULT NULL,
  `invoice_credit_id` bigint(20) DEFAULT NULL,
  `arrival_dt` datetime DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `dt` datetime NOT NULL,
  `dt_short` bigint(11) NOT NULL,
  `shift_date` date DEFAULT NULL,
  `shift` varchar(5) DEFAULT NULL,
  `departure_dt` datetime DEFAULT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `customer` varchar(64) DEFAULT NULL,
  `po_id` bigint(20) DEFAULT NULL,
  `job` varchar(128) DEFAULT NULL,
  `po_no_old` varchar(64) DEFAULT NULL,
  `destination` varchar(96) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `customer_product_id` bigint(20) DEFAULT NULL,
  `site_id` int(11) DEFAULT NULL,
  `silo_id` int(11) NOT NULL,
  `silo_no` varchar(6) DEFAULT NULL,
  `scale_id_gross` int(11) DEFAULT NULL,
  `scale_id_tare` int(11) DEFAULT NULL,
  `inventory_silo_id` bigint(20) DEFAULT NULL,
  `carrier_id` bigint(20) DEFAULT NULL,
  `carrier` varchar(50) DEFAULT NULL,
  `vehicle_no` varchar(10) DEFAULT NULL,
  `driver_id` bigint(20) DEFAULT NULL,
  `driver_user_id` bigint(20) DEFAULT NULL,
  `transfer_site_id` int(11) DEFAULT NULL,
  `transfer_dt` datetime DEFAULT NULL,
  `transfer_from_rail_car_id` varchar(20) DEFAULT NULL,
  `transfer_from_rail_car_net_pounds` int(11) DEFAULT NULL,
  `transfer_from_rail_car_net_tons` decimal(10,2) DEFAULT NULL,
  `transfer_from_rail_car_2_id` varchar(20) DEFAULT NULL,
  `transfer_from_rail_car_2_net_pounds` int(11) DEFAULT NULL,
  `transfer_from_rail_car_2_net_tons` decimal(10,2) DEFAULT NULL,
  `transfer_from_silo_id` int(11) DEFAULT NULL,
  `transfer_to_rail_car_id` varchar(20) DEFAULT NULL,
  `transfer_to_silo_id` int(11) DEFAULT NULL,
  `gross_pounds` int(11) DEFAULT NULL,
  `tare_pounds` int(11) DEFAULT NULL,
  `net_pounds` int(11) DEFAULT NULL,
  `net_tons` decimal(10,2) DEFAULT NULL,
  `carrier_ticket_no` varchar(20) DEFAULT NULL,
  `pounds_received` int(11) DEFAULT NULL,
  `tons_received` decimal(10,2) DEFAULT NULL,
  `received_site_id` int(11) DEFAULT NULL,
  `received_silo_id` int(11) DEFAULT NULL,
  `received_by` varchar(8) DEFAULT NULL,
  `ticket_manual_img_path` varchar(50) DEFAULT NULL,
  `ticket_img_path` varchar(50) DEFAULT NULL,
  `vehicle_img_path` varchar(50) DEFAULT NULL,
  `ok_status_code` varchar(1) DEFAULT NULL,
  `void_status_code` varchar(1) NOT NULL DEFAULT 'A',
  `void_reason_code` varchar(1) NOT NULL DEFAULT 'A',
  `void_comments` varchar(100) DEFAULT NULL,
  `void_email_dt` datetime DEFAULT NULL,
  `sent_dt` datetime DEFAULT NULL,
  `stored_vehicle_pu_dt` datetime DEFAULT NULL,
  `stored_vehicle_pu_user_id` bigint(20) DEFAULT NULL,
  `duplicate_email_dt` datetime DEFAULT NULL,
  `constraint_override_dt` datetime DEFAULT NULL,
  `constraint_override_user_id` bigint(20) DEFAULT NULL,
  `weighmaster_error_status_code` varchar(1) DEFAULT NULL,
  `jws_user_id` bigint(20) DEFAULT NULL,
  `jws_is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `is_ok_for_billing` varchar(1) NOT NULL DEFAULT 'Y',
  `create_dt` datetime DEFAULT NULL,
  `create_user_id` bigint(20) DEFAULT NULL,
  `edit_dt` datetime DEFAULT NULL,
  `edit_user_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`ticket_no`),
  KEY `date` (`date`),
  KEY `dt_short` (`dt_short`),
  KEY `po_id` (`po_id`),
  KEY `void_status_code` (`void_status_code`),
  KEY `void_reason_code` (`void_reason_code`),
  KEY `carrier_id` (`carrier_id`),
  KEY `site_id` (`site_id`),
  KEY `inventory_silo_id` (`inventory_silo_id`),
  KEY `load_id` (`load_id`),
  KEY `customer_id` (`customer_id`),
  KEY `silo_id` (`silo_id`),
  KEY `dt` (`dt`),
  KEY `driver_id` (`driver_id`),
  KEY `transfer_site_id` (`transfer_site_id`),
  KEY `invoice_id` (`invoice_id`),
  KEY `product_id` (`product_id`),
  KEY `received_silo_id` (`received_silo_id`),
  KEY `received_site_id` (`received_site_id`),
  KEY `invoice_credit_id` (`invoice_credit_id`),
  KEY `rail_car_release_id` (`rail_car_release_id`),
  KEY `driver_user_id` (`driver_user_id`),
  KEY `ok_status_code` (`ok_status_code`),
  KEY `customer_product_id` (`customer_product_id`),
  KEY `transfer_to_rail_car_id` (`transfer_to_rail_car_id`),
  KEY `transfer_to_silo_id` (`transfer_to_silo_id`),
  KEY `transfer_from_rail_car_id` (`transfer_from_rail_car_id`),
  KEY `transfer_from_rail_car_2_id` (`transfer_from_rail_car_2_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prod_tickets`
--

LOCK TABLES `prod_tickets` WRITE;
/*!40000 ALTER TABLE `prod_tickets` DISABLE KEYS */;
/*!40000 ALTER TABLE `prod_tickets` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-01-17 13:54:44
