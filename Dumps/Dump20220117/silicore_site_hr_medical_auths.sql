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
-- Table structure for table `hr_medical_auths`
--

DROP TABLE IF EXISTS `hr_medical_auths`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hr_medical_auths` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hr_clinic_id` int(11) NOT NULL,
  `hr_applicant_employee_code` varchar(11) NOT NULL,
  `hr_auth_reason_id` int(11) NOT NULL,
  `is_dot` tinyint(1) NOT NULL,
  `comments` varchar(128) DEFAULT NULL,
  `file_path` varchar(64) DEFAULT NULL,
  `status_code_id` int(11) NOT NULL DEFAULT '1',
  `result_code_id` int(11) NOT NULL DEFAULT '1',
  `check_up_code_id` int(11) NOT NULL DEFAULT '1',
  `paid_date` datetime DEFAULT NULL,
  `create_user_id` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  `modify_user_id` int(11) DEFAULT NULL,
  `modify_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hr_clinic_id` (`hr_clinic_id`),
  KEY `hr_auth_reason_id` (`hr_auth_reason_id`),
  CONSTRAINT `hr_medical_auths_ibfk_1` FOREIGN KEY (`hr_clinic_id`) REFERENCES `hr_clinics` (`id`),
  CONSTRAINT `hr_medical_auths_ibfk_2` FOREIGN KEY (`hr_auth_reason_id`) REFERENCES `hr_medical_auth_reasons` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hr_medical_auths`
--

LOCK TABLES `hr_medical_auths` WRITE;
/*!40000 ALTER TABLE `hr_medical_auths` DISABLE KEYS */;
INSERT INTO `hr_medical_auths` VALUES (1,2,'0001',15,0,'','../../Files/HR/Medical/Authorizations/1-2.pdf',4,1,1,'2019-06-01 00:00:00',121,'2019-07-01 15:42:23',121,'2019-07-01 15:43:19');
/*!40000 ALTER TABLE `hr_medical_auths` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-01-17 13:58:15
