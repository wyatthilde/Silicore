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
-- Table structure for table `hr_job_titles`
--

DROP TABLE IF EXISTS `hr_job_titles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hr_job_titles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_id` int(11) NOT NULL,
  `position` varchar(64) NOT NULL,
  `is_management` tinyint(1) NOT NULL DEFAULT '0',
  `is_exec` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=233 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hr_job_titles`
--

LOCK TABLES `hr_job_titles` WRITE;
/*!40000 ALTER TABLE `hr_job_titles` DISABLE KEYS */;
INSERT INTO `hr_job_titles` VALUES (1,1,'Lab Tech',0,0),(2,1,'Lab Manager',1,0),(3,1,'Sr Lab Tech II',0,0),(4,1,'Sr Lab Tech',0,0),(5,1,'Lab Tech II',0,0),(6,2,'Programmer Analyst',0,0),(7,2,'Accounting Manager',1,0),(8,2,'IT Manager',1,0),(9,2,'Office Manager',1,0),(10,2,'Buyer/Inventory Control',0,0),(11,2,'Sr. Help Desk Support',0,0),(12,2,'Safety Systems Adminitrator',0,0),(13,2,'Lead Warehouse Clerk',0,0),(14,2,'Procurement Specialist',0,0),(15,2,'Custodial Support',0,0),(16,2,'Human Resources Manager',1,0),(17,2,'Procurement Manager',1,0),(18,2,'PHP Web Developer',0,0),(19,2,'Recruiting Coordinator',0,0),(20,2,'Warehouse Clerk',0,0),(21,2,'Human Resource Generalist',0,0),(22,2,'Safety Admin',0,0),(23,2,'Senior Web Developer',0,0),(24,2,'Survey Technician II',0,0),(25,2,'Geologist',0,0),(26,3,'Geology Manager',1,0),(27,3,'Production Manager',1,0),(28,3,'Sr. Logistics Manager',1,0),(29,3,'Logistics Manager',1,0),(30,3,'Safety Manager',1,0),(31,3,'Project Manager',1,0),(32,3,'Project Coordinator',0,0),(33,3,'Safety Specialist',0,0),(34,3,'Desktop Technician',0,0),(35,4,'Truck Boss Level 1',0,0),(36,4,'Haul Truck Operator Dual Level 1',0,0),(37,4,'Pit Supervisor',0,0),(38,4,'Haul Truck Operator',0,0),(39,4,'Sr Haul Truck Operator II',0,0),(40,4,'Heavy Equipment Operator Level 2',0,0),(41,4,'Front End Loader Dual Level 1',0,0),(42,4,'Front End Loader Operator Lead',0,0),(43,4,'Truck Boss Level 1 & 2',0,0),(44,4,'Sr. Front End Loader Operator',0,0),(45,4,'Pit Mechanic',0,0),(46,4,'Front End Loader Operator',0,0),(47,4,'Heavy Equipment Operator',0,0),(48,4,'Fleet Assets Manager',1,0),(49,4,'Front End Loader Dual Level 2',0,0),(50,4,'Shift Swing Supervisor',0,0),(51,4,'Fueler / Haul Truck Operator',0,0),(52,4,'Assistant Mine Superintendent',0,0),(53,4,'Heavy Equipment Operator Lead',0,0),(54,4,'Haul Truck Operator Lead',0,0),(55,4,'Fueler',0,0),(56,4,'Assistant Fleet Asset Manager',1,0),(57,5,'Plant Operator',0,0),(58,5,'Plant Shift Supervisor',0,0),(59,5,'Production Trainer',0,0),(60,5,'Plant Operator II',0,0),(61,5,'Field Service Tech',0,0),(62,5,'Plant Operator III',0,0),(63,5,'Check In Attendant',0,0),(64,6,'Railyard Supervisor',0,0),(65,6,'Transload Manager',1,0),(66,6,'General Operations Manager',1,0),(67,6,'Rail Transload Operator',0,0),(68,7,'Maintenance Manager',1,0),(69,7,'Mechanic',0,0),(70,7,'Maintenance Electrical Scheduler',0,0),(71,7,'Lead Mechanic',0,0),(72,7,'Maintenance Mechanic Planner',0,0),(73,7,'Electrical Maintenance Manager',1,0),(74,7,'Electrician',0,0),(75,7,'Mechanic II',0,0),(76,7,'Lead Electrician',0,0),(77,8,'Sr Lab Tech II',0,0),(78,8,'Sr Lab Tech',0,0),(79,8,'Lab Tech II',0,0),(80,8,'Lab Tech',0,0),(81,9,'Plant Operator III',0,0),(82,9,'Plant Shift Supervisor',0,0),(83,9,'Plant Operator II',0,0),(84,9,'Conductor',0,0),(85,9,'Plant Operator',0,0),(86,9,'Sr. Rail Operator',0,0),(87,9,'Enterprise Production Supervisor',0,0),(88,9,'Loadout Supervisor',0,0),(89,10,'Front End Loader Dual Level 1',0,0),(90,10,'Front End Loader Operator',0,0),(91,10,'Heavy Equipment Operator',0,0),(92,10,'Haul Truck Operator Dual Level 1',0,0),(93,10,'Pit Supervisor',0,0),(94,10,'Haul Truck Operator',0,0),(95,11,'Mechanic II',0,0),(96,11,'Mechanic',0,0),(97,11,'Electrician',0,0),(98,12,'Production Manager',1,0),(99,13,'Lead Lab Tech',0,0),(100,13,'Lab Tech',0,0),(101,14,'Plant Shift Supervisor',0,0),(102,14,'Loadout Supervisor',0,0),(103,14,'Loadout Operator',0,0),(104,14,'Plant Operator',0,0),(105,14,'Enterprise Production Supervisor',0,0),(106,15,'Pit Supervisor',0,0),(107,15,'Front End Loader Operator',0,0),(108,15,'Front End Loader Dual Level 1',0,0),(109,15,'Heavy Equipment Operator',0,0),(110,15,'Haul Truck Operator',0,0),(111,15,'Water Truck Operator',0,0),(112,15,'Fueler',0,0),(113,15,'Light Equipment Operator',0,0),(114,16,'Loadout Operator',0,0),(115,17,'Lead Mechanic',0,0),(116,17,'Electrician',0,0),(117,17,'Maintenance Mechanic Supervisor',0,0),(118,17,'Lube Tech',0,0),(119,17,'Mechanic',0,0),(120,18,'Production Manager',1,0),(121,18,'Management Trainee',0,0),(122,18,'Maintenance Manager',1,0),(123,18,'RV Maintenance Manager',1,0),(124,18,'Process Engineer',0,0),(125,18,'Human Resource Generalist',0,0),(126,18,'Sr Industrial Buyer',0,0),(127,18,'Custodial Support',0,0),(128,18,'Safety Manager',1,0),(129,18,'Warehouse Clerk',0,0),(130,18,'Lead Warehouse Clerk',0,0),(131,18,'Safety Specialist',0,0),(132,18,'Parts Day Runner',0,0),(133,18,'Employee Logistics Coordinator',0,0),(134,19,'Heavy Equipment Operator Level 2',0,0),(135,2,'A/P Specialist',0,0),(136,2,'A/P Clerk',0,0),(154,3,'Mine Superintendent',1,1),(155,23,'Mine Superintendent West Texas',1,1),(156,2,'Director Sales and Marketing',1,1),(157,2,'Technical Services - Director',1,1),(158,2,'Director of Business Development',1,1),(159,2,'EVP of Operations',1,1),(160,2,'Director of Human Resources',1,1),(161,3,'Operations Mgr Cresson & Tolar',1,1),(162,2,'Safety Director',1,1),(163,2,'Accounting - Controller',1,1),(164,2,'Director of IT',1,1),(165,2,'VP of Finance',1,1),(166,2,'VP of Logistics Operations',1,1),(167,2,'VP Business Development',1,1),(168,23,'Operations Mgr West Texas',1,1),(169,3,'Director, Plant Operations',1,1),(170,2,'Controller',1,1),(171,2,'Chief Financial Officer',1,1),(172,2,'Director of Construction & Eng',1,1),(173,2,'A/P Specialist',0,0),(174,2,'A/P Clerk',0,0),(175,4,'Heavy Equipment Operator Dual Level 2',0,0),(176,2,'A/P Specialist',0,0),(177,2,'A/P Clerk',0,0),(179,0,'',0,0),(180,0,'',0,0),(181,0,'',0,0),(182,0,'',0,0),(183,0,'test',0,0),(184,29,'test management',1,0),(185,29,'IT Manager',0,0),(186,27,'Logistics Coordinater Level 2',0,0),(187,29,'Onboarding Instructor',0,0),(188,29,'HR Manager',0,0),(189,74,'Loader Operator',0,0),(190,69,'Loader Operator',0,0),(191,22,'Loader Operator',0,0),(192,28,'Maintenance Mechanic',0,0),(193,27,'Logistics Manager',0,0),(194,69,'Shift Supervisor',0,0),(195,27,'Logistics Coordinator',0,0),(196,66,'Terminal Manager',0,0),(197,28,'LP Maintenance Manager',0,0),(198,70,'Loader Operator',0,0),(199,66,'Safety Admin Assistant',0,0),(200,66,'Loader Operator',0,0),(201,73,'Loader Operator',0,0),(202,29,'HR Generalist',0,0),(203,29,'AR Specialist',0,0),(204,29,'Safety Admin Assistant',0,0),(205,73,'Crew Lead',0,0),(206,29,'Payroll Manager',0,0),(207,73,'Admin Assistant',0,0),(208,73,'Crew Lead',0,0),(209,29,'Director of Transportation',0,0),(210,74,'Crew Lead',0,0),(211,73,'Crew Lead',0,0),(212,69,'Mechanic/Electrician',0,0),(213,70,'Shift Supervisor',0,0),(214,28,'Shift Supervisor',0,0),(215,28,'Supervisor',0,0),(216,28,'Loader Operator',0,0),(217,73,'Loader Operator',0,0),(218,29,'Recruiting Assistant',0,0),(219,27,'Business Analyst',0,0),(220,69,'Regional Manager',0,0),(221,28,'Mechanic',0,0),(222,29,'Lead Payables Supervisor',0,0),(223,70,'Maintenance',0,0),(224,29,'Staff Accountant',0,0),(225,10,'Engineer',0,0),(226,10,'Trucking Manager',0,0),(227,27,'Dispatcher',1,0),(228,27,'Dispatch Manager',1,0),(229,27,'Test1',1,0),(230,27,'test24',1,0),(231,27,'434764',1,0),(232,27,'46t23',1,0);
/*!40000 ALTER TABLE `hr_job_titles` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-01-17 13:52:44
