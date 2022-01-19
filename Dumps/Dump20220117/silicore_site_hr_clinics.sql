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
-- Table structure for table `hr_clinics`
--

DROP TABLE IF EXISTS `hr_clinics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hr_clinics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `address` varchar(64) NOT NULL,
  `city` varchar(24) NOT NULL,
  `state` varchar(2) DEFAULT NULL,
  `zip` varchar(8) DEFAULT NULL,
  `longitude` float DEFAULT NULL,
  `latitude` float DEFAULT NULL,
  `phone_number` varchar(16) DEFAULT NULL,
  `fax_number` varchar(16) DEFAULT NULL,
  `email_address` varchar(32) DEFAULT NULL,
  `create_user_id` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hr_clinics`
--

LOCK TABLES `hr_clinics` WRITE;
/*!40000 ALTER TABLE `hr_clinics` DISABLE KEYS */;
INSERT INTO `hr_clinics` VALUES (1,'Valley Day & Night Clinic','305 E. Expressway','Mission','TX','78572',-98.3253,26.2159,'956-585-7401','956-580-4317',NULL,NULL,NULL),(2,'A-Dependable Drug & Alcohol','710 N Main','Dilley','TX','78017',-99.1672,28.6696,'830-963-9110','830-963-9132',NULL,NULL,NULL),(3,'A-Dependable Drug Testing','1002 S Stockton Ave','Monahans','TX','79756',-102.891,31.584,'432-943-2910','',NULL,NULL,NULL),(4,'Analyzing Solutions of TX','3529 Contrary Creek Rd','Granbury','TX','76048',-97.7826,32.4027,'817-573-2030','817-573-1413',NULL,NULL,NULL),(5,'Any Lab Test Now','3270 Sherwood Way','San Angelo','TX','76901',-100.478,31.4466,'325-227-6804','325-227-6806',NULL,NULL,NULL),(6,'Avalon Urgent Care LTD','805 Hill Blvd','Granbury','TX','76048',-97.7735,32.4361,'817-579-7557','',NULL,NULL,NULL),(7,'CAD Services','1315 Del Rio Blvd','El Paso','TX','78852',-100.498,28.7217,'830-773-4333','830-773-4334',NULL,NULL,NULL),(8,'CARE NOW','2700 Horne St','Fort Worth','TX','76107',-97.408,32.733,'817-570-7995','',NULL,NULL,NULL),(9,'CONCENTRA / ARLINGTON','511 E Interstate 20','Arlington','TX','76014',-97.6598,32.742,'817-261-5166','',NULL,NULL,NULL),(10,'CONCENTRA / ARLINGTON','2160 E. Lamar Blvd','Arlington','TX','76006',-97.0744,32.7626,'972-988-0441','972-641-0054',NULL,NULL,NULL),(11,'CONCENTRA / BURLESON','811 NE Albury Rd','Burleson','TX','76028',-97.0743,32.8575,'817-293-7311','',NULL,NULL,NULL),(12,'CONCENTRA / FOSSIL CREEK','4060 Sandshell Drive','Fort Worth','TX','76137',-97.3094,32.861,'817-306-9777','817-306-9780',NULL,NULL,NULL),(13,'CONCENTRA / FTW -Forest Park','2500 West Fwy','Fort Worth','TX','76102',-97.2254,32.8703,'817-882-8700','817-882-8707',NULL,NULL,NULL),(14,'CONCENTRA / MESQUITE','4928 Samuell Blvd','MESQUITE','TX','75149',-96.6707,32.7924,'214-328-1400','214-328-2884',NULL,NULL,NULL),(15,'CONCENTRA / SAN ANTONIO I-35','3453 N I-35','San Antonio','TX','78219',-98.4301,29.4459,'210-226-7767','210-226-9656',NULL,NULL,NULL),(16,'CONCENTRA / SAN ANTONIO -Quincy','400 East Quincy','San Antonio','TX','78215',-98.4793,29.4413,'210-472-0211','210-472-0214',NULL,NULL,NULL),(17,'Artesia Drug and Alcohol Screening','315 Washington','Artesia','NM','88210',-104.4,32.8357,'575-746-3404','',NULL,NULL,NULL),(18,'Drug Screen Compliance','614 C N. Main St','Fort Stockton','TX','79735',-102.879,30.8901,'432-336-8805','',NULL,NULL,NULL),(19,'Entero Services Drug Screening','112 S. Jackson St','Enid','OK','73701',-97.8891,36.3966,'580-234-8585','580-234-8585',NULL,NULL,NULL),(20,'Industrial Health Services','2402 West Pierce St.','Carlsbad','NM','88220',-104.257,32.442,'575-887-8764','',NULL,NULL,NULL),(21,'First Physicians  - Covers Goldsmith','3051 E. Unversity BLVD','Odessa','TX','79762',-102.355,31.8739,'432-203-9798','432-362-1589',NULL,NULL,NULL),(22,'Lakeside Physicians','601 Fall Creek  Hwy','Granbury','TX','76049',-97.6968,32.4703,'817-326-3900','',NULL,NULL,NULL),(23,'Integriss Bass Occupational','401 S. 3rd Street','Enid','OK','73701',-97.8752,36.393,'580-548-1112','',NULL,NULL,NULL),(24,'LAREDO OCCUPATIONAL CENTER','9114 McPherson  St.','Laredo','TX','78045',-99.48,27.594,'956-568-3638','956-568-3665',NULL,NULL,NULL),(25,'MCH -Family Health Clinic','540 W. 5th st.  Suite 300','Odessa','TX','79761',-102.375,31.8461,'432-640-3007','',NULL,NULL,NULL),(26,'Medical City/Arlington / Formerly Plaza','3301 Matlock Rd.','Arlingotn','TX','76015',-97.1129,32.6922,'817-465-3241','',NULL,NULL,NULL),(27,'Medical City/Fort Worth / Formerly Plaza','900 8th Ave.','Fort Worth','TX','76104',-97.3451,32.7357,'817-336-2100','',NULL,NULL,NULL),(28,'Medical Clinic of Devine','1250 State Highway 173','Devine','TX','78016',-98.8891,29.1227,'830-665-2876','',NULL,NULL,NULL),(29,'Medina Community Hospital','3100 Ave E','Hondo','TX','78861',-99.1345,29.335,'830-426-7700','',NULL,NULL,NULL),(30,'Medical Center Health Systems','500 W 4th St.','Odessa','TX','79761',-102.374,31.845,'432-640-6000','',NULL,NULL,NULL),(31,'Melody\'s Southwest Consortioum','300 E. 3rd. Street','San Angelo','TX','76903',-100.434,31.4702,'325-658-9966','325-658-0000',NULL,NULL,NULL),(32,'Mobile Drug Testing Group','405 Sheridan Trail','Irving','TX','75063',-96.9516,32.9324,'214-280-0101','214-260-1122',NULL,NULL,NULL),(33,'Mobile Safety & Consutlation','314 W. Mermod St.','Carlsbad','NM','88220',-104.23,32.4204,'575-234-0393','',NULL,NULL,NULL),(34,'Nova Health Care Center / East','13469 East Freeway','Houston','TX','77015',-95.1149,29.5675,'713-453-7788','713-453-3424',NULL,NULL,NULL),(35,'Nova Health Care Center / Katy','11621-A Katy Freeway','Houston','TX','77079',-95.588,29.7841,'832-399-5300','832-399-5301',NULL,NULL,NULL),(36,'Nova Health Care Centers / GRAND PRAIRIE','2045 N Hwy 360 Ste','Grand Prairie','TX','75050',-97.0612,32.7791,'972-623-1111','972-623-1105',NULL,NULL,NULL),(37,'Nova Medical Center / EL PASO','10961 Gateway Blvd.','El Paso','TX','79935',-106.336,31.7474,'915-245-3131','915-245-3132',NULL,NULL,NULL),(38,'Nova Medical Center/ MESQUITE','1900 Oates Drive S','MESQUITE','TX','75150',-96.6302,32.8372,'972-698-7700','972-698-7702',NULL,NULL,NULL),(39,'Nova Medical Centers  / ODESSA','2711 N. Grandview Ave.','Odessa','TX','79762',-102.347,31.8758,'432-279-1401','432-279-1402',NULL,NULL,NULL),(40,'Nova Medical Centers / AUSTIN','8868 Research Blvd','Austin','TX','78758',-97.7215,30.3703,'512-615-3000','512-615-3001',NULL,NULL,NULL),(41,'Nova Medical Centers/ FORT WORTH','1106 Alston Ave.','Fort Worth','TX','76104',-97.334,32.7373,'817-332-0660','817-332-0770',NULL,NULL,NULL),(42,'Occupational Health Solution','3645 Western Center','Fort Worth','TX','76137',-97.2722,32.8577,'817-306-9200','817-306-0329',NULL,NULL,NULL),(43,'Pecos Drug Testing','1309 W 3rd St','Pecos','TX','79772',-103.508,31.4214,'432-445-4878','432-445-4835',NULL,NULL,NULL),(44,'Reagan Memorial Hospital','1300 North Main','Big Lake','TX','76932',-98.6633,29.4214,'325-884-2561','325-884-5869',NULL,NULL,NULL),(45,'Reeves Rehab Safety Train','105 Westland','San Angelo','TX','76901',-100.466,31.4531,'325-340-4020','325-617-7809',NULL,NULL,NULL),(46,'Safety Depot  Clinic','611 2nd Street','Big Lake','TX','76932',-101.459,31.1916,'325-884-2838','',NULL,NULL,NULL),(47,'San Angelo Community Medical Center','3501 Knickerbocker Rd.','San Angelo','TX','76904',-100.47,31.4178,'325-949-9511','',NULL,NULL,NULL),(48,'Shannon Occupational  Medicine & Injury','2626 North Bryant','San Angelo','TX','76903',-100.461,31.4836,'325-481-2375','325-481-2374',NULL,NULL,NULL),(49,'TX MedClinic #18519','Hwy 151 / Loop 410','San Antonio','TX','78245',-98.6589,29.4388,'210-682-5577','',NULL,NULL,NULL),(50,'TX MedClinic #22530','SW Military Dr.','San Antonio','TX','78224',-98.5357,29.3562,'210-334-0385','',NULL,NULL,NULL),(51,'Valir Outpatient Clinics LLC.','225 W.Owen K Garriott Rd.','Enid','OK','73701',-97.8802,36.3908,'210-334-0385','',NULL,NULL,NULL),(52,'Valley Day & Night Clinic','305 E. Expressway','Mission','TX','78572',-98.3704,26.2186,'956-585-7401','956-580-4317',NULL,NULL,NULL),(53,'Weatherford Regional Medical Center','5141 E. I-20 Service Road North','Willow Park','TX','76087',-97.699,32.7552,'682-582-1000','',NULL,NULL,NULL),(54,'Wendover Family Medicine','4222 Wendover Ave. Suite 600','Odessa','TX','79762',-102.345,31.8918,'432-552-5656','',NULL,NULL,NULL),(55,'West TX Rehab Center- OZONA','908 1st Street','Ozona','TX','76943',-101.206,30.7203,'325-392-9872','325-234-5370',NULL,NULL,NULL),(56,'West TX Rehab Center -WTRC','3001 S. Jackson','San Angelo','TX','76904',-100.456,31.4335,'325-223-6370','325-223-6327',NULL,NULL,NULL),(57,'Wet Tech Safety and Rental','102 Frio St.','Cotulla','TX','78014',-99.2352,28.4379,'830-879-3400','830-879-3401',NULL,NULL,NULL);
/*!40000 ALTER TABLE `hr_clinics` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-01-17 14:01:20
