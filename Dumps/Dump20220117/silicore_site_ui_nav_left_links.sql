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
-- Table structure for table `ui_nav_left_links`
--

DROP TABLE IF EXISTS `ui_nav_left_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ui_nav_left_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_link_id` int(11) NOT NULL,
  `link_name` varchar(64) NOT NULL,
  `link_title` varchar(256) DEFAULT NULL,
  `main_department_id` int(11) DEFAULT NULL,
  `web_file` varchar(128) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `indent` int(11) DEFAULT '0',
  `permission_level` int(11) DEFAULT '0',
  `company` varchar(32) NOT NULL,
  `site` varchar(32) NOT NULL,
  `permission` varchar(32) NOT NULL,
  `is_external` tinyint(1) NOT NULL DEFAULT '0',
  `is_hidden` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ui_nav_left_links`
--

LOCK TABLES `ui_nav_left_links` WRITE;
/*!40000 ALTER TABLE `ui_nav_left_links` DISABLE KEYS */;
INSERT INTO `ui_nav_left_links` VALUES (1,0,'Home','Main Page',1,'main.php',100,0,0,'vista','granbury','all',0,0,1),(2,0,'QC - GB','Quality Control Department',4,'gb_main.php',1000,0,0,'vista','granbury','qc',0,0,1),(3,0,'Production','Production Department',3,'main.php',2000,0,1,'vista','granbury','production',0,0,1),(4,0,'Loadout','Loadout Department',5,'main.php',3000,0,1,'vista','granbury','loadout',0,0,1),(5,0,'Logistics','Logistics Department',6,'main.php',4000,0,1,'vista','granbury','logistics',0,0,1),(6,0,'Safety','Safety Department',8,'main.php',5000,0,1,'vista','granbury','safety',0,0,1),(7,0,'Accounting','Accounting Department',7,'main.php',6000,0,1,'vista','granbury','accounting',0,0,1),(8,0,'HR','Human Resources Department',9,'main.php',7000,0,1,'vista','granbury','hr',0,0,1),(9,0,'Development','Development Department',2,'main.php',8000,0,5,'vista','granbury','development',0,0,1),(10,0,'Quicklinks','Quick Links',1,'quicklinks.php',9000,0,0,'vista','granbury','all',0,0,1),(11,8,'HR On Boarding','Human Resources Employee Checklist',9,'onboarding.php',7010,2,3,'vista','granbury','hr',0,0,1),(12,12,'Vista Sand','Vista Sand External Website',1,'http://pweb.vistasand.com/',9010,2,0,'vista','granbury','all',1,0,1),(13,12,'Maalt LP','Maalt LP External Website',1,'https://www.maaltlp.com/',9020,2,0,'vista','granbury','all',1,0,1),(14,12,'Maalt Transportation','Maalt Transportation External Website',1,'http://www.maalt.com/',9030,2,0,'vista','granbury','all',1,0,1),(15,12,'Paycom','Paycom',1,'http://www.paycom.com/',9040,2,0,'vista','granbury','hr',1,0,1),(16,9,'Analytics Dashboard','Analytics Dashboard',2,'analyticsdashboard.php',8010,2,5,'vista','granbury','development',0,0,1),(17,9,'Update Page Help','Update Page Help',2,'updatepagehelp.php',8020,2,5,'vista','granbury','development',0,0,1),(18,9,'Edit Page Content','Edit Page Content',2,'editpage.php',8030,2,1,'vista','granbury','development',0,0,1),(19,9,'SendPHPMail()','This page executes SendPHPMail() in debug mode',2,'testmail.php',8340,4,5,'vista','granbury','development',0,0,1),(20,9,'MySQL-PHP-Sproc','Example of how stored procedures should be used with MySQL',2,'mysqlphpsproc.php',8350,4,5,'vista','granbury','development',0,0,1),(21,9,'MSSQL-PHP-Sproc','Example of how stored procedures should be used with MSSQL',2,'mssqlphpsproc.php',8360,4,5,'vista','granbury','development',0,0,1),(22,9,'Server Notes','Ongoing documentation for Silicore platform server configuration and maintenance',2,'doc_servernotes.php',8380,4,5,'vista','granbury','development',0,0,1),(23,9,'Code Examples','List of code examples',2,'codeexamples.php',8100,2,5,'vista','granbury','development',0,0,1),(24,2,'Overview','QC Overview',4,'gb_overview.php',1010,2,0,'vista','granbury','qc',0,0,1),(25,2,'Add Sample Group','Add a New Sample Group',4,'gb_samplegroupadd.php',1020,2,1,'vista','granbury','qc',0,0,1),(26,2,'Sample Database','QC Samples',4,'gb_samples.php?view=verbose',1030,2,0,'vista','granbury','qc',0,0,1),(27,2,'Edit Sample','Edit an Existing Sample',4,'gb_sampleedit.php',1040,2,1,'vista','granbury','qc',0,0,1),(28,2,'View Sample','View an Existing Sample',4,'gb_sampleview.php',1050,2,0,'vista','granbury','qc',0,0,0),(29,2,'Performance','QC Performance Metrics',4,'gb_performance.php',1060,2,1,'vista','granbury','qc',0,0,1),(30,3,'KPI Dashboard','Key Performance Indicators',3,'kpidashboard.php',2010,2,1,'vista','granbury','production',0,0,1),(31,3,'Plant Dashboard','Production Plant Metrics',3,'plantdashboard.php',2020,2,1,'vista','granbury','production',0,0,1),(32,3,'TCEQ Report','Environmental Report',3,'tceqreport.php',2030,2,1,'vista','granbury','production',0,0,1),(33,3,'Cresson Dashboard','Track Cresson/58 Acres Data',3,'cressondashboard.php',2040,2,0,'vista','granbury','production',0,1,0),(34,0,'User Profile','User Profile',1,'profile.php',10100,2,0,'vista','granbury','general',0,0,1),(35,44,'Silicore Users','Silicore Users',10,'silicoreusers.php',8040,2,1,'vista','granbury','it',0,0,1),(36,9,'Edit User','Edit Silicore User Information',2,'silicoreuseredit.php',8050,2,5,'vista','granbury','development',0,1,1),(37,0,'QC - TL','Quality Control Department',4,'tl_main.php',1500,0,0,'vista','tolar','qc',0,0,1),(38,37,'Overview','QC Overview',4,'tl_overview.php',1510,2,0,'vista','tolar','qc',0,0,1),(39,37,'Add Sample Group','Add a New Sample Group',4,'tl_samplegroupadd.php',1520,2,1,'vista','tolar','qc',0,0,1),(40,37,'Sample Database','QC Samples',4,'tl_samples.php?view=verbose',1530,2,0,'vista','tolar','qc',0,0,1),(41,37,'Edit Sample','Edit an Existing Sample',4,'tl_sampleedit.php',1540,2,1,'vista','tolar','qc',0,0,1),(42,37,'View Sample','View an Existing Sample',4,'tl_sampleview.php',1550,2,0,'vista','tolar','qc',0,0,0),(43,37,'Performance','QC Performance Metrics',4,'tl_performance.php',1560,2,1,'vista','tolar','qc',0,0,1),(44,0,'IT','IT Help Desk Department',10,'main.php',4500,0,1,'vista','granbury','it',0,0,1),(45,2,'Threshold Maint.','Threshold Maintenance',4,'gb_thresholdmaint.php',1070,2,4,'vista','granbury','qc',0,0,1),(46,37,'Threshold Maint.','Threshold Maintenance',4,'tl_thresholdmaint.php',1570,2,4,'vista','granbury','qc',0,0,1),(47,2,'Edit Threshold','Edit Threshold',4,'gb_thresholdedit.php',1080,2,4,'vista','granbury','qc',0,0,1),(48,37,'Edit Threshold','Edit Threshold',4,'tl_thresholdedit.php',1580,2,4,'vista','granbury','qc',0,0,1),(49,0,'QC - WT','Quality Control Department',4,'wt_main.php',1600,0,0,'vista','west_texas','qc',0,0,1),(50,49,'Overview','QC Overview',4,'wt_overview.php',1610,2,0,'vista','west_texas','qc',0,0,1),(51,49,'Add Sample Group','Add a New Sample Group',4,'wt_samplegroupadd.php',1620,2,1,'vista','west_texas','qc',0,0,1),(52,49,'Sample Database','QC Samples',4,'wt_samples.php?view=verbose',1630,2,0,'vista','west_texas','qc',0,0,1),(53,49,'Edit Sample','Edit an Existing Sample',4,'wt_sampleedit.php',1640,2,1,'vista','west_texas','qc',0,0,1),(54,49,'View Sample','View an Existing Sample',4,'wt_sampleview.php',1650,2,0,'vista','west_texas','qc',0,0,0),(55,49,'Performance','QC Performance Metrics',4,'wt_performance.php',1660,2,1,'vista','west_texas','qc',0,0,1),(56,49,'Threshold Maint.','Threshold Maintenance',4,'wt_thresholdmaint.php',1670,2,4,'vista','west_texas','qc',0,0,1),(57,49,'Edit Threshold','Edit Threshold',4,'wt_thresholdedit.php',1680,2,4,'vista','west_texas','qc',0,0,1),(58,3,'Plant Thresholds','Change Alert Thresholds',3,'plc_plant_thresholds.php',2050,2,1,'vista','granbury','production',0,0,1),(59,3,'Add Tag','Add Tag For Alert Tracking',3,'gb_plc_add_tag.php',2052,2,1,'vista','granbury','production',0,0,1),(60,3,'Edit Threshold','Edit Selected Threshold',3,'plc_edit_threshold.php',2051,2,1,'vista','granbury','production',0,0,1),(61,8,'HR Off Boarding','Human Resources Employee Off Boarding',9,'hroffboarding.php',7020,2,3,'vista','granbury','hr',0,0,1),(62,3,'Weather Data','Table of weather from WeatherUnderground',3,'weather_data_table.php',2080,2,1,'vista','granbury','production',0,0,1),(65,0,'Wiki','Development Department',11,'index.php',10000,0,1,'vista','granbury','safety',0,0,0),(66,3,'TL Plant Dashboard','Tolar Production Metrics',3,'plantdashboard_tl.php',2021,2,1,'vista','granbury','production',0,0,1),(67,3,'Weather Data TL','Weather Data',3,'tl_weatherdata.php',2081,2,1,'vista','granbury','production',0,0,1),(68,3,'Weather Data WT','Weather Data',3,'wt_weatherdata.php',2082,2,1,'vista','granbury','production',0,0,1),(72,2,'GB Manage Locations','Manage GB Locations',4,'gb_managelocations.php',1035,2,4,'vista','granbury','qc',0,0,1),(73,37,'TL Manage Locations','Manage TL Locations',4,'tl_managelocations.php',1535,2,4,'vista','tolar','qc',0,0,1),(74,49,'WT Manage Locations','Manage TL Locations',4,'wt_managelocations.php',1635,2,4,'vista','west_texas','qc',0,0,1),(75,2,'Manage Plants','Manage Plants',4,'manageplants.php',1033,2,4,'vista','granbury','qc',0,0,1),(76,37,'Manage Plants','Manage Plants',4,'manageplants.php',1533,2,4,'vista','tolar','qc',0,0,1),(77,49,'Manage Plants','Manage Plants',4,'manageplants.php',1633,2,4,'vista','west_texas','qc',0,0,1),(78,2,'Manage Sites','Manage Sites',4,'managesites.php',1031,2,4,'vista','granbury','qc',0,0,1),(79,37,'Manage Sites','Manage Sites',4,'managesites.php',1531,2,4,'vista','tolar','qc',0,0,1),(80,49,'Manage Sites','Manage Sites',4,'managesites.php',1631,2,4,'vista','west_texas','qc',0,0,1),(81,9,'Delete Location','Delelte Location',2,'deletelocation.php',8400,2,5,'vista','granbury','development',0,0,1),(85,3,'Tl Scorecard','Scorecard For Tolar',3,'tl_scorecard.php',2030,2,3,'vista','granbury','production',0,0,1),(86,2,'GB Manage Specific Locations','Manage GB Specific Locations',4,'gb_managespecificlocations.php',1036,2,4,'vista','granbury','qc',0,0,1),(87,37,'TL Manage Specific Locations','Manage TL Specific Locations',4,'tl_managespecificlocations.php',1536,2,6,'vista','tolar','qc',0,0,0),(88,49,'WT Manage Specific Locations','Manage WT Specific Locations',4,'wt_managespecificlocations.php',1636,2,6,'vista','west_texas','qc',0,0,0),(89,3,'GB Scorecard','Scorecard For Granbury',3,'gb_scorecard.php',2029,2,3,'vista','granbury','production',0,0,1),(90,2,'Sieve Management','QC Sieve Management',4,'sievemanagement.php',1036,2,1,'vista','granbury','qc',0,0,1),(91,2,'Document Managment','Document Management QC',4,'document_management_qc.php',1040,2,1,'vista','granbury','qc',0,0,1),(92,0,'Asset Management','Inventory Management IT',10,'inventorymanagement.php',4510,2,1,'vista','granbury','it',0,0,1),(93,3,'Silos Dashboard','Silos Dashboard',3,'silos_dashboard.php',2091,2,1,'vista','granbury','production',0,0,1),(98,7,'Back Office Docs','Accounting Department',7,'legacydocuments.php',7020,1,1,'vista','granbury','accounting',0,0,1),(99,44,'Server Status','Status of networked servers',10,'serverstatus.php',11000,1,1,'vista','granbury','it',0,0,1),(100,8,'Pre-employment','Pre-employment',9,'preemployment.php',7000,1,3,'vista','granbury','hr',0,0,1);
/*!40000 ALTER TABLE `ui_nav_left_links` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-01-17 13:52:57
