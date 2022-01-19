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
-- Table structure for table `main_page_help`
--

DROP TABLE IF EXISTS `main_page_help`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `main_page_help` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(64) NOT NULL,
  `department` varchar(64) NOT NULL,
  `text` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `main_page_help`
--

LOCK TABLES `main_page_help` WRITE;
/*!40000 ALTER TABLE `main_page_help` DISABLE KEYS */;
INSERT INTO `main_page_help` VALUES (1,'main.php','General','This is the main landing page. Welcome!'),(2,'profile.php','General','This page shows information about the user profile.'),(3,'main.php','QC','This page contains information about Quality Control.'),(4,'main.php','Production','This page contains information about Production.'),(5,'main.php','Loadout','This page contains information about loadout.'),(6,'main.php','Logistics','This page contains information about Logistics.'),(7,'main.php','Safety','This page contains information about safety.'),(8,'main.php','Accounting','This page contains information about Accounting.'),(9,'main.php','HR','This page contains information about HR.'),(10,'main.php','Development','This is the development main page.'),(11,'hrchecklist.php','HR','This page contains an HR checklist.'),(12,'quicklinks.php','General','This page contains commonly used links.'),(13,'updatepagehelp.php','Development','This web form lets you change the help text for pages in the application.'),(14,'analyticsdashboard.php','Development','This page displays website analytics information.'),(15,'gb_samples.php','QC','This page lists the QC samples recorded. Cick on Filter Settings to filter the view.'),(16,'gb_samplegroupadd.php','QC','This page lets you add new samples. Complete the fields and then click Save to start the new samples. Click on Select Locations provides a list of locations to choose from.'),(17,'gb_sievetracking.php','QC','This page lets you view a list of QC sieve stacks that are available for use.'),(18,'gb_sampleedit.php','QC','You are editing a QC sample. Complete the fields and click Save to update the record. Click on General, Characteristics, or Plant Settings to see sections of the sample form.'),(19,'gb_overview.php','QC','This page shows an overview of QC sample data and statistics for each location at the selected plant.'),(20,'gb_performance.php','QC','This page shows counts and statistics on samples by Quality Control laboratory technician.'),(21,'tl_samples.php','QC','This page lists the QC samples recorded. Cick on Filter Settings to filter the view.'),(22,'tl_samplegroupadd.php','QC','This page lets you add new samples. Complete the fields and then click Save to start the new samples. Click on Select Locations provides a list of locations to choose from.'),(23,'tl_sievetracking.php','QC','This page lets you view a list of QC sieve stacks that are available for use.'),(24,'tl_sampleedit.php','QC','You are editing a QC sample. Complete the fields and click Save to update the record. Click on General, Characteristics, or Plant Settings to see sections of the sample form.'),(25,'tl_overview.php','QC','This page shows an overview of QC sample data and statistics for each location at the selected plant.'),(26,'tl_performance.php','QC','This page shows counts and statistics on samples by Quality Control laboratory technician.'),(27,'gb_sampleview.php','QC','You are viewing a QC sample. Complete the fields and click Save to update the record. Click on General, Characteristics, or Plant Settings to see sections of the sample form.'),(28,'tl_sampleview.php','QC','You are viewing a QC sample. Complete the fields and click Save to update the record. Click on General, Characteristics, or Plant Settings to see sections of the sample form.'),(29,'gb_thresholdmaint.php','QC','This page allows you to set thresholds for QC data. These settings are used to highlight values in the QC Overview page.'),(30,'tl_thresholdmaint.php','QC','This page allows you to set thresholds for QC data. These settings are used to highlight values in the QC Overview page.'),(31,'wt_samples.php','QC','This page lists the QC samples recorded. Cick on Filter Settings to filter the view.'),(32,'wt_samplegroupadd.php','QC','This page lets you add new samples. Complete the fields and then click Save to start the new samples. Click on Select Locations provides a list of locations to choose from.'),(33,'wt_sievetracking.php','QC','This page lets you view a list of QC sieve stacks that are available for use.'),(34,'wt_sampleedit.php','QC','You are editing a QC sample. Complete the fields and click Save to update the record. Click on General, Characteristics, or Plant Settings to see sections of the sample form.'),(35,'wt_overview.php','QC','This page shows an overview of QC sample data and statistics for each location at the selected plant.'),(36,'wt_performance.php','QC','This page shows counts and statistics on samples by Quality Control laboratory technician.'),(37,'wt_sampleview.php','QC','You are viewing a QC sample. Complete the fields and click Save to update the record. Click on General, Characteristics, or Plant Settings to see sections of the sample form.'),(38,'wt_thresholdmaint.php','QC','This page allows you to set thresholds for QC data. These settings are used to highlight values in the QC Overview page.'),(39,'gb_main.php','QC','This is the home page for the Granbury Quality Control department.'),(40,'tl_main.php','QC','This is the home page for the Tolar Quality Control department'),(41,'wt_main.php','QC','This is the home page for the West Texas Quality Control department');
/*!40000 ALTER TABLE `main_page_help` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-01-17 13:57:29
