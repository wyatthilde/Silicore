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
-- Table structure for table `gb_qc_locations`
--

DROP TABLE IF EXISTS `gb_qc_locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gb_qc_locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(256) NOT NULL,
  `main_site_id` int(11) NOT NULL,
  `main_plant_id` int(11) NOT NULL,
  `main_product_id` int(11) NOT NULL DEFAULT '0',
  `type_code` varchar(2) NOT NULL DEFAULT 'S',
  `is_split_sample_only` tinyint(1) DEFAULT '0',
  `email_list_id` int(11) NOT NULL DEFAULT '0',
  `is_send_email` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `send_completion_message` tinyint(1) DEFAULT '1',
  `create_date` datetime DEFAULT NULL,
  `create_user_id` int(11) DEFAULT NULL,
  `modify_date` datetime DEFAULT NULL,
  `modify_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `plant_id` (`main_plant_id`),
  KEY `site_id` (`main_site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=185 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gb_qc_locations`
--

LOCK TABLES `gb_qc_locations` WRITE;
/*!40000 ALTER TABLE `gb_qc_locations` DISABLE KEYS */;
INSERT INTO `gb_qc_locations` VALUES (0,'NA',0,0,0,'S',0,0,0,0,0,1,NULL,NULL,NULL,NULL),(1,'Feed Rows',10,0,0,'S',0,0,0,1,0,1,NULL,NULL,NULL,NULL),(2,'Wet Plant Feed',10,3,3,'S',0,0,0,30,0,1,NULL,NULL,NULL,NULL),(3,'Wet Plant C4 (Coarse)',10,3,4,'S',0,3,1,50,1,1,NULL,NULL,NULL,NULL),(4,'Wet Plant C7 (Fine)',10,3,5,'S',0,0,1,60,1,1,NULL,NULL,NULL,NULL),(5,'Wet Plant Hydro 1 Over',10,3,0,'S',0,0,0,70,1,1,NULL,NULL,NULL,NULL),(6,'Wet Plant Hydro 2 Over',10,3,0,'S',0,0,0,80,1,1,NULL,NULL,NULL,NULL),(7,'Wet Plant Hydro 1 Under',10,3,0,'S',0,0,0,90,1,1,NULL,NULL,NULL,NULL),(8,'Wet Plant Hydro 2 Under',10,3,0,'S',0,0,0,91,1,1,NULL,NULL,NULL,NULL),(9,'Wet Plant Moisture Rate',10,3,0,'M',0,0,0,105,1,1,NULL,NULL,NULL,NULL),(11,'Carrier Feed 40/70',10,6,11,'S',1,0,1,10,1,1,NULL,NULL,NULL,NULL),(12,'Rotary Feed',10,5,9,'S',0,0,0,64,0,1,NULL,NULL,NULL,NULL),(13,'Rotary 100',10,5,10,'S',1,15,1,66,0,1,NULL,NULL,NULL,NULL),(14,'Carrier 140 40/70',10,6,0,'S',1,0,0,20,1,1,NULL,NULL,NULL,NULL),(15,'Carrier 140 100',10,6,0,'S',1,0,0,250,1,1,NULL,NULL,NULL,NULL),(16,'Carrier 145 40/70',10,6,0,'S',1,0,0,50,1,1,NULL,NULL,NULL,NULL),(17,'Carrier 145 100',10,6,0,'S',1,0,0,260,1,1,NULL,NULL,NULL,NULL),(18,'Pit',10,1,0,'S',0,0,0,10,1,1,NULL,NULL,NULL,NULL),(19,'Old Wet Plant Feed A',10,4,6,'S',0,4,1,230,1,1,NULL,NULL,NULL,NULL),(20,'Old Wet Plant Coarse Side A',10,4,7,'S',0,0,1,232,1,1,NULL,NULL,NULL,NULL),(21,'Old Wet Plant Fine Side A',10,4,8,'S',0,0,1,250,1,1,NULL,NULL,NULL,NULL),(22,'Old Wet Plant Coarse Side B',10,4,7,'S',0,0,1,240,1,1,NULL,NULL,NULL,NULL),(23,'Old Wet Plant Fine Side B',10,4,8,'S',0,0,1,260,1,1,NULL,NULL,NULL,NULL),(24,'Carrier Feed 100',10,6,12,'S',1,0,0,230,1,1,NULL,NULL,NULL,NULL),(25,'Old Wet Plant Hydro Side A Over',10,4,0,'S',0,0,0,275,1,1,NULL,NULL,NULL,NULL),(26,'Old Wet Plant Hydro Side B Over',10,4,0,'S',0,0,0,280,1,1,NULL,NULL,NULL,NULL),(27,'Wet Plant Cyclones 1-2 Over',10,3,15,'S',0,0,0,190,1,1,NULL,NULL,NULL,NULL),(28,'Wet Plant Cyclones 3-6 Over',10,3,15,'S',0,0,0,200,1,1,NULL,NULL,NULL,NULL),(29,'Old Wet Plant Cyclones',10,4,0,'S',0,0,0,0,0,1,NULL,NULL,NULL,NULL),(30,'Wet Plant Feed (Slurry)',10,3,3,'S',0,0,0,30,0,1,NULL,NULL,NULL,NULL),(31,'Wet Plant Cyclones 1-2 Feed',10,3,3,'S',0,4,1,40,1,1,NULL,NULL,NULL,NULL),(32,'Wet Plant Cyclones 3-4 Feed',10,3,0,'S',0,0,0,220,1,1,NULL,NULL,NULL,NULL),(33,'Wet Plant Cyclone 1 Under',10,3,0,'S',0,0,0,110,1,1,NULL,NULL,NULL,NULL),(34,'Wet Plant Cyclone 2 Under',10,3,0,'S',0,0,0,120,1,1,NULL,NULL,NULL,NULL),(35,'Wet Plant Cyclone 1 B Under',10,3,0,'S',0,0,0,130,1,1,NULL,NULL,NULL,NULL),(36,'Wet Plant Cyclone 2 B Under',10,3,0,'S',0,0,0,140,1,1,NULL,NULL,NULL,NULL),(37,'Old Wet Plant Cyclone 1 Feed Side B',10,4,6,'S',0,0,0,330,1,1,NULL,NULL,NULL,NULL),(38,'Old Wet Plant Cyclone 1 Tails Side A',10,4,0,'S',0,0,0,290,1,1,NULL,NULL,NULL,NULL),(39,'Old Wet Plant Cyclone 2 Tails Side A',10,4,0,'S',0,0,0,300,1,1,NULL,NULL,NULL,NULL),(40,'Old Wet Plant Cyclone 3 Tails Side A',10,4,0,'S',0,0,0,310,1,1,NULL,NULL,NULL,NULL),(41,'Old Wet Plant Cyclones 1-2 Tails Side B',10,4,0,'S',0,0,0,315,1,1,NULL,NULL,NULL,NULL),(42,'Old Wet Plant Cyclones 4-5 Over Side B',10,4,0,'S',0,0,0,320,1,1,NULL,NULL,NULL,NULL),(43,'Track 1',30,0,0,'S',1,0,0,300,1,1,NULL,NULL,NULL,NULL),(44,'Track 2',30,0,0,'S',1,0,0,305,1,1,NULL,NULL,NULL,NULL),(45,'Wet Plant Cyclone 5 Under',10,3,0,'S',0,0,0,150,1,1,NULL,NULL,NULL,NULL),(46,'Wet Plant Cyclone 6 Under',10,3,0,'S',0,0,0,160,1,1,NULL,NULL,NULL,NULL),(47,'Wet Plant Cyclone 7 Under',10,3,0,'S',0,0,0,170,1,1,NULL,NULL,NULL,NULL),(48,'Core Samples',10,0,0,'S',0,0,0,20,0,1,NULL,NULL,NULL,NULL),(49,'Rotary Feed',10,7,16,'S',0,0,1,440,1,1,NULL,NULL,NULL,NULL),(50,'Rotary 100',10,7,17,'S',0,37,1,450,1,1,NULL,NULL,'2020-03-18 14:05:28',15),(51,'Rotary Discharge',10,7,0,'S',1,0,1,460,1,1,NULL,NULL,NULL,NULL),(52,'Rotary Baghouse',10,7,0,'S',0,0,1,470,1,1,NULL,NULL,NULL,NULL),(53,'Carrier Baghouse',10,6,0,'S',0,0,1,290,1,1,NULL,NULL,NULL,NULL),(54,'Carrier 40/70 Silo',10,6,13,'S',0,40,1,90,1,1,NULL,NULL,NULL,NULL),(55,'Carrier 100',10,6,14,'S',0,15,1,240,1,1,NULL,NULL,NULL,NULL),(56,'Generic Sample',10,6,0,'S',0,0,1,270,1,1,NULL,NULL,NULL,NULL),(57,'Carrier Vehicle/Truck 100',10,6,0,'S',0,0,0,340,0,1,NULL,NULL,NULL,NULL),(58,'Wet Plant Cyclones 8-9 Feed',10,3,0,'S',0,0,0,179,1,1,NULL,NULL,NULL,NULL),(59,'Wet Plant Cyclone 8 Over',10,3,0,'S',0,0,0,211,1,1,NULL,NULL,NULL,NULL),(60,'Wet Plant Cyclone 8 Under',10,3,0,'S',0,0,0,173,1,1,NULL,NULL,NULL,NULL),(61,'Wet Plant Cyclone 9 Over',10,3,0,'S',0,0,0,213,1,1,NULL,NULL,NULL,NULL),(62,'Wet Plant Cyclone 9 Under',10,3,0,'S',0,0,0,176,1,1,NULL,NULL,NULL,NULL),(63,'Wet Plant Hydro 1 B Over',10,3,0,'S',0,0,0,85,1,1,NULL,NULL,NULL,NULL),(64,'Wet Plant Hydro 1 B Under',10,3,0,'S',0,0,0,92,1,1,NULL,NULL,NULL,NULL),(65,'Wet Plant Hydro 2 B Over',10,3,0,'S',0,0,0,86,1,1,NULL,NULL,NULL,NULL),(66,'Wet Plant Hydro 2 B Under',10,3,0,'S',0,0,0,93,1,1,NULL,NULL,NULL,NULL),(67,'Hardie Moisture Sample',10,6,0,'M',0,43,1,280,1,1,NULL,NULL,NULL,NULL),(68,'UFR 200 Belt Composite',10,3,0,'S',0,0,1,345,0,1,NULL,NULL,NULL,NULL),(69,'UFR 200 (NWP)',10,3,21,'S',0,0,1,100,1,1,NULL,NULL,NULL,NULL),(70,'UFR 200 (OWP)',10,4,0,'S',0,0,1,270,1,1,NULL,NULL,NULL,NULL),(100,'Inhibited Sample',0,0,0,'S',0,0,0,1000,0,1,NULL,NULL,NULL,NULL),(101,'Carrier 40/70 Lab Composite',10,6,13,'S',1,15,1,80,1,1,NULL,NULL,NULL,NULL),(102,'Carrier 2 100 Silo',10,8,22,'S',0,15,1,20,1,1,NULL,NULL,'2020-03-18 14:13:01',15),(103,'Carrier 2 Feed',10,8,22,'S',1,15,1,10,1,1,NULL,NULL,NULL,NULL),(104,'Carrier 140 40/70 (L)',10,6,0,'S',1,0,0,30,1,1,NULL,NULL,NULL,NULL),(105,'Carrier 140 40/70 (R)',10,6,0,'S',1,0,0,40,1,1,NULL,NULL,NULL,NULL),(106,'Carrier 140 Fine (L)',10,6,0,'S',1,0,0,110,1,1,NULL,NULL,NULL,NULL),(107,'Carrier 140 Fine (R)',10,6,0,'S',1,0,0,120,1,1,NULL,NULL,NULL,NULL),(108,'Carrier 140 Fine',10,6,0,'S',1,0,0,100,1,1,NULL,NULL,NULL,NULL),(109,'Carrier 140 OS (L)',10,6,0,'S',1,0,0,170,1,1,NULL,NULL,NULL,NULL),(110,'Carrier 140 OS (R)',10,6,0,'S',1,0,0,180,1,1,NULL,NULL,NULL,NULL),(111,'Carrier 140 OS',10,6,0,'S',1,0,0,160,1,1,NULL,NULL,NULL,NULL),(112,'Carrier 145 40/70 (L)',10,6,0,'S',1,0,0,60,1,1,NULL,NULL,NULL,NULL),(113,'Carrier 145 40/70 (R)',10,6,0,'S',1,0,0,70,1,1,NULL,NULL,NULL,NULL),(114,'Carrier 145 Fine (L)',10,6,0,'S',1,0,0,140,1,1,NULL,NULL,NULL,NULL),(115,'Carrier 145 Fine (R)',10,6,0,'S',1,0,0,150,1,1,NULL,NULL,NULL,NULL),(116,'Carrier 145 Fine',10,6,0,'S',1,0,0,130,1,1,NULL,NULL,NULL,NULL),(117,'Carrier 145 OS (L)',10,6,0,'S',1,0,0,200,1,1,NULL,NULL,NULL,NULL),(118,'Carrier 145 OS (R)',10,6,0,'S',1,0,0,210,1,1,NULL,NULL,NULL,NULL),(119,'Carrier 145 OS',10,6,0,'S',1,0,0,190,1,1,NULL,NULL,NULL,NULL),(120,'Rail Car 40/70',20,10,0,'S',1,0,0,300,1,1,NULL,NULL,NULL,NULL),(121,'Rail Car 100',20,10,0,'S',1,0,0,310,1,1,NULL,NULL,NULL,NULL),(122,'Truck 40/70',10,6,0,'S',1,0,0,320,1,1,NULL,NULL,NULL,NULL),(123,'Truck 100',10,6,0,'S',1,0,0,330,1,1,NULL,NULL,NULL,NULL),(124,'Carrier 2 40/70',10,8,0,'S',1,15,1,30,1,1,NULL,NULL,NULL,NULL),(125,'Carrier 2 OS',10,8,0,'S',1,15,1,40,1,1,NULL,NULL,NULL,NULL),(126,'Carrier 2 Baghouse',10,8,0,'S',1,15,1,50,1,1,NULL,NULL,NULL,NULL),(127,'Wet Plant Belt Feed',10,3,3,'S',0,0,0,31,1,1,NULL,NULL,NULL,NULL),(128,'Old Wet Plant Belt Feed',10,4,6,'S',0,0,0,225,1,1,NULL,NULL,NULL,NULL),(129,'Unknown',10,9,6,'S',0,0,0,1000,1,1,NULL,NULL,NULL,NULL),(130,'Core Sample',10,9,6,'S',0,0,0,900,1,1,NULL,NULL,NULL,NULL),(131,'Old Wet Plant Feed B',10,4,6,'S',0,4,1,231,1,1,NULL,NULL,NULL,NULL),(132,'Pump 6',10,4,0,'S',0,0,0,265,1,1,NULL,NULL,NULL,NULL),(133,'Carrier Trash Belt',10,6,0,'S',1,0,0,220,1,1,NULL,NULL,NULL,NULL),(134,'Pit Sample',10,9,0,'S',0,0,0,910,1,1,NULL,NULL,NULL,NULL),(135,'NA',50,16,0,'S',0,0,0,0,1,1,NULL,NULL,NULL,NULL),(136,'Inhibited Sample',50,16,0,'S',0,0,0,1000,1,1,NULL,NULL,NULL,NULL),(137,'Belt Feed',50,11,0,'S',0,0,0,50,1,1,NULL,NULL,NULL,NULL),(138,'Primary Cyclone Feed',50,12,0,'S',0,0,0,100,1,1,NULL,NULL,NULL,NULL),(139,'Primary Cyclone Unders',50,12,0,'S',0,0,0,150,1,1,NULL,NULL,NULL,NULL),(140,'Primary Cyclone Overs',50,12,0,'S',0,0,0,200,1,1,NULL,NULL,NULL,NULL),(141,'Attrition Cell Discharge',50,12,0,'S',0,0,0,250,1,1,NULL,NULL,NULL,NULL),(142,'Secondary Cyclone Overs',50,12,0,'S',0,0,0,300,1,1,NULL,NULL,NULL,NULL),(143,'Wet Plant Product',50,12,0,'S',0,0,0,350,1,1,NULL,NULL,NULL,NULL),(144,'UFR Feed',50,13,0,'S',0,0,0,400,1,1,NULL,NULL,NULL,NULL),(145,'UFR Product',50,13,0,'S',0,0,0,450,1,1,NULL,NULL,NULL,NULL),(146,'Press Cake Moisture',50,13,0,'S',0,0,0,500,1,1,NULL,NULL,NULL,NULL),(147,'Rotary Feed',50,14,0,'S',0,0,0,550,1,1,NULL,NULL,NULL,NULL),(148,'Rotary 2 Feed',50,14,0,'S',0,0,0,600,1,1,NULL,NULL,NULL,NULL),(149,'Baghouse Fines',50,14,0,'S',0,0,0,650,1,1,NULL,NULL,NULL,NULL),(150,'Dry Mill Trash',50,14,0,'S',0,0,0,700,1,1,NULL,NULL,NULL,NULL),(151,'100 Mesh Product',50,14,0,'S',0,0,0,750,1,1,NULL,NULL,NULL,NULL),(152,'Rail Car 100 Mesh',50,15,0,'S',0,0,0,800,1,1,NULL,NULL,NULL,NULL),(153,'De-Watering Screen 1',10,4,0,'S',0,0,0,500,1,1,NULL,NULL,NULL,NULL),(154,'De-Watering Screen 2',10,3,0,'S',0,0,0,550,1,1,NULL,NULL,NULL,NULL),(174,'Test Description',10,4,0,'S',0,0,1,1010,0,1,'2018-07-25 10:14:10',192,'2018-07-25 10:14:17',192),(175,'&quot;Test\'?&quot;',10,3,0,'S',0,0,1,1020,0,1,'2018-07-26 16:31:48',192,'2018-07-26 16:32:09',192),(176,'Test Description2',10,4,0,'S',0,0,1,1030,0,1,'2018-07-27 11:42:35',192,'2018-07-27 11:42:59',192),(177,'Hardie Silt',10,9,0,'S',1,0,1,1040,1,1,'2019-07-22 15:43:01',121,NULL,NULL),(178,'Rotary 200',10,7,0,'S',0,0,1,1050,1,1,'2020-11-10 16:24:48',9,NULL,NULL),(179,'Carrier 1 200',10,6,0,'S',0,0,1,1060,1,1,'2020-11-10 16:26:53',9,NULL,NULL),(180,'Carrier 2 200',10,8,0,'S',0,0,1,1070,1,1,'2020-11-10 16:27:03',9,NULL,NULL),(181,'Carrier Feed 200',10,6,0,'S',0,0,1,1080,1,1,'2020-11-16 14:40:31',9,NULL,NULL),(182,'Railcar 40/70',10,46,0,'S',0,0,1,1090,1,1,'2021-06-16 10:09:35',9,NULL,NULL),(183,'Railcar 100',10,46,0,'S',0,0,1,1100,1,1,'2021-06-16 10:09:59',9,NULL,NULL),(184,'Railcar 200',10,46,0,'S',0,0,1,1110,1,1,'2021-06-16 10:10:15',9,NULL,NULL);
/*!40000 ALTER TABLE `gb_qc_locations` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-01-17 13:58:53
