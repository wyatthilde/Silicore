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
-- Table structure for table `tl_plc_tags`
--

DROP TABLE IF EXISTS `tl_plc_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tl_plc_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) DEFAULT '50',
  `tag` varchar(50) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `ui_label` varchar(50) DEFAULT NULL,
  `description` varchar(128) DEFAULT NULL,
  `classification` varchar(50) DEFAULT NULL,
  `ehouse` varchar(50) DEFAULT NULL,
  `units` varchar(10) DEFAULT NULL,
  `plant_id` int(11) DEFAULT NULL,
  `is_qc_plant_setting` tinyint(1) NOT NULL DEFAULT '0',
  `is_kpi` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `create_user_id` int(11) DEFAULT NULL,
  `modify_date` datetime DEFAULT NULL,
  `modify_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tl_plc_tags`
--

LOCK TABLES `tl_plc_tags` WRITE;
/*!40000 ALTER TABLE `tl_plc_tags` DISABLE KEYS */;
INSERT INTO `tl_plc_tags` VALUES (1,50,'A5CV07','Allen.EH2.Silicore.Beltscales.A5CV07','Needs Definition','NULL','Needs Definition','EH2','ND',31,0,1,1,'2018-05-21 11:36:11',25,NULL,NULL),(2,50,'A5CV08','Allen.EH2.Silicore.Beltscales.A5CV08','Needs Definition','NULL','Needs Definition','EH2','ND',31,0,0,1,'2018-05-21 11:36:13',25,NULL,NULL),(3,50,'A8CV01','Allen.EH4.Silicore.Beltscales.A8CV01','Needs Definition','NULL','Needs Definition','EH4','ND',31,0,0,1,'2018-05-21 11:36:15',25,NULL,NULL),(4,50,'A8CV02','Allen.EH4.Silicore.Beltscales.A8CV02','Needs Definition','NULL','Needs Definition','EH4','ND',31,0,0,1,'2018-05-21 11:36:17',25,NULL,NULL),(5,50,'A8CV06','Allen.EH4.Silicore.Beltscales.A8CV06','Needs Definition','NULL','Needs Definition','EH4','ND',31,0,0,1,'2018-05-21 11:36:19',25,NULL,NULL),(6,50,'A8CV10','Allen.EH4.Silicore.Beltscales.A8CV10','Needs Definition','NULL','Needs Definition','EH4','ND',31,0,0,1,'2018-05-21 11:36:21',25,NULL,NULL),(7,50,'A9CV02','Allen.EH4.Silicore.Beltscales.A9CV02','Needs Definition','NULL','Needs Definition','EH4','ND',31,0,0,1,'2018-05-21 11:36:23',25,NULL,NULL),(8,50,'a1BF01_FS_Ton','Allen.EH1.Global.a1BF01_FS_Ton.ACC','Needs Definition','NULL','Needs Definition','EH1','ND',31,0,0,1,'2018-05-21 11:36:25',25,NULL,NULL),(9,50,'A1CV01','Allen.EH1.Silicore.Beltscales.A1CV01','Needs Definition','NULL','Needs Definition','EH1','ND',31,0,0,1,'2018-05-21 11:36:27',25,NULL,NULL),(10,50,'A1CV02','Allen.EH1.Silicore.Beltscales.A1CV02','Needs Definition','NULL','Needs Definition','EH1','ND',31,0,0,1,'2018-05-21 11:36:29',25,NULL,NULL),(11,50,'A5CV01','Allen.EH2.Silicore.Beltscales.A5CV01','Needs Definition','NULL','Needs Definition','EH2','ND',31,0,0,1,'2018-05-21 11:36:31',25,NULL,NULL),(12,50,'A5CV03','Allen.EH2.Silicore.Beltscales.A5CV03','Needs Definition','NULL','Needs Definition','EH2','ND',31,0,0,1,'2018-05-21 11:36:33',25,NULL,NULL),(13,50,'A5CV06','Allen.EH2.Silicore.Beltscales.A5CV06','Needs Definition','NULL','Needs Definition','EH2','ND',31,0,0,1,'2018-05-21 11:36:35',25,NULL,NULL),(14,50,'ACC','Allen.EH1.Global.a1Cv01_Scl_Tons_Counter.ACC','Needs Definition','NULL','Needs Definition','EH1','ND',31,0,0,1,'2018-07-09 09:20:01',25,NULL,NULL),(15,50,'CD','Allen.EH1.Global.a1Cv01_Scl_Tons_Counter.CD','Needs Definition','NULL','Needs Definition','EH1','ND',31,0,0,1,'2018-07-09 09:20:09',25,NULL,NULL),(16,50,'Control','Allen.EH1.Global.a1Cv01_Scl_Tons_Counter.Control','Needs Definition','NULL','Needs Definition','EH1','ND',31,0,0,1,'2018-07-09 09:20:12',25,NULL,NULL),(17,50,'PRE','Allen.EH1.Global.a1Cv01_Scl_Tons_Counter.PRE','Needs Definition','NULL','Needs Definition','EH1','ND',31,0,0,1,'2018-07-09 09:20:14',25,NULL,NULL),(18,50,'a5Cv03_WT.Out_Value','Allen.EH2.Global.a5Cv03_WT.Out_Value','Needs Definition','NULL','Needs Definition','EH2','ND',31,0,0,1,'2018-07-17 14:30:02',25,NULL,NULL),(19,50,'a5Cv04_WT.Out_Value','Allen.EH2.Global.a5Cv04_WT.Out_Value','Wet Plant Feed','NULL','Needs Definition','EH2','ND',31,0,0,1,'2018-07-17 14:30:11',25,NULL,NULL),(20,50,'a5Cv07_WT.Out_Value','Allen.EH2.Global.a5Cv07_WT.Out_Value','Hopper Feed','NULL','Needs Definition','EH2','ND',31,0,0,1,'2018-07-17 14:30:14',25,NULL,NULL),(21,50,'a5Cv08_WT.Out_Value','Allen.EH2.Global.a5Cv08_WT.Out_Value','Stacker Feed','NULL','Needs Definition','EH2','ND',31,0,0,1,'2018-07-17 14:30:18',25,NULL,NULL),(22,50,'a8Cv06_WT.Out_Value','Allen.EH4.Global.a8Cv06_WT.Out_Value','Rotary Output','NULL','Needs Definition','EH4','ND',31,0,0,1,'2018-07-17 14:30:22',25,NULL,NULL),(23,50,'a9Cv02_WT.Out_Value','Allen.EH4.Global.a9Cv02_WT.Out_Value','Silo Output','NULL','Needs Definition','EH4','ND',31,0,0,1,'2018-07-17 14:30:25',25,NULL,NULL),(24,50,'A5CV04','Allen.EH2.Silicore.Beltscales.A5CV04','Needs Definition',NULL,'Needs Definition','EH2','ND',31,0,0,NULL,'2018-07-18 14:50:03',25,NULL,NULL),(25,50,'Out_Value','Allen.EH4.Global.a9Cv02_WT.Out_Value','Needs Definition',NULL,'Needs Definition','EH4','ND',31,0,0,NULL,'2020-04-13 11:09:50',25,NULL,NULL),(26,50,'A5CV04','Allen.EH2.Silicore.Beltscales.A5CV04','Needs Definition',NULL,'Needs Definition','EH2','ND',31,0,0,NULL,'2020-04-13 11:09:59',25,NULL,NULL),(27,50,'A5CV06','Allen.EH2.Silicore.Beltscales.A5CV06','Needs Definition',NULL,'Needs Definition','EH2','ND',31,0,0,NULL,'2020-04-13 11:13:54',25,NULL,NULL),(28,50,'ACC','Allen.EH1.Global.a1Cv01_Scl_Tons_Counter.ACC','Needs Definition',NULL,'Needs Definition','EH1','ND',31,0,0,NULL,'2020-08-03 15:20:52',25,NULL,NULL),(29,50,'A5CV07','Allen.EH2.Silicore.Beltscales.A5CV07','Needs Definition',NULL,'Needs Definition','EH2','ND',31,0,0,NULL,'2020-08-03 15:20:52',25,NULL,NULL),(30,50,'A5CV04','Allen.EH2.Silicore.Beltscales.A5CV04','Needs Definition',NULL,'Needs Definition','EH2','ND',31,0,0,NULL,'2020-08-03 15:30:43',25,NULL,NULL);
/*!40000 ALTER TABLE `tl_plc_tags` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-01-17 13:58:51
