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
-- Table structure for table `prod_auto_plant_idletime`
--

DROP TABLE IF EXISTS `prod_auto_plant_idletime`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prod_auto_plant_idletime` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `shift_id` bigint(20) NOT NULL,
  `start_dt` datetime NOT NULL,
  `end_dt` datetime NOT NULL,
  `end_dt_short` bigint(11) NOT NULL,
  `duration_minutes` int(5) NOT NULL,
  `duration` decimal(5,2) NOT NULL,
  `reason` varchar(64) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `end_dt_short` (`end_dt_short`)
) ENGINE=InnoDB AUTO_INCREMENT=2278 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prod_auto_plant_idletime`
--

LOCK TABLES `prod_auto_plant_idletime` WRITE;
/*!40000 ALTER TABLE `prod_auto_plant_idletime` DISABLE KEYS */;
INSERT INTO `prod_auto_plant_idletime` VALUES (2054,16351,'2017-01-01 17:02:34','2017-01-01 17:28:34',20170101172,26,0.43,'Full Silos',''),(2055,16359,'2017-01-01 17:39:07','2017-01-01 23:23:07',20170101232,344,5.73,'Full Silos',''),(2056,16359,'2017-01-02 02:15:07','2017-01-02 05:32:07',20170102053,197,3.28,'Full Silos',''),(2057,16365,'2017-01-02 05:42:00','2017-01-02 17:33:00',20170102173,711,11.85,'Full Silos',''),(2058,16369,'2017-01-02 17:34:22','2017-01-03 05:32:22',20170103053,718,11.97,'Full Silos',''),(2059,16375,'2017-01-03 05:42:27','2017-01-03 15:28:27',20170103152,586,9.77,'Full Silos',''),(2060,16387,'2017-01-04 11:57:44','2017-01-04 14:21:44',20170104142,144,2.40,'Other','gas'),(2061,16421,'2017-01-06 09:27:37','2017-01-06 09:41:37',20170106094,14,0.23,'Other','temp'),(2062,16423,'2017-01-06 13:42:15','2017-01-06 13:51:15',20170106135,9,0.15,'Weather',''),(2063,16425,'2017-01-06 06:15:37','2017-01-06 18:32:37',20170106183,737,12.28,'Weather',''),(2064,16441,'2017-01-06 18:42:19','2017-01-07 07:05:19',20170107070,743,12.38,'Weather',''),(2065,16446,'2017-01-07 07:15:57','2017-01-07 18:09:57',20170107180,654,10.90,'Weather',''),(2066,16453,'2017-01-07 18:20:32','2017-01-08 08:44:32',20170108084,864,14.40,'Weather',''),(2067,16457,'2017-01-08 11:41:01','2017-01-08 12:14:01',20170108121,33,0.55,'Weather',''),(2068,16457,'2017-01-08 12:14:51','2017-01-08 12:17:51',20170108121,3,0.05,'Weather',''),(2069,16457,'2017-01-08 12:19:49','2017-01-08 12:24:49',20170108122,5,0.08,'Weather',''),(2070,16457,'2017-01-08 12:25:29','2017-01-08 12:34:29',20170108123,9,0.15,'Weather',''),(2071,16457,'2017-01-08 12:35:22','2017-01-08 12:43:22',20170108124,8,0.13,'Weather',''),(2072,16457,'2017-01-08 12:47:10','2017-01-08 13:44:10',20170108134,57,0.95,'Weather',''),(2073,16464,'2017-01-08 08:56:47','2017-01-08 14:01:47',20170108140,305,5.08,'Weather',''),(2074,16457,'2017-01-08 13:45:56','2017-01-08 14:09:56',20170108140,24,0.40,'Weather',''),(2075,16457,'2017-01-08 16:31:27','2017-01-08 17:19:27',20170108171,48,0.80,'Weather',''),(2076,16455,'2017-01-08 05:40:41','2017-01-08 17:35:41',20170108173,715,11.92,'Weather',''),(2077,16464,'2017-01-08 14:32:17','2017-01-08 18:11:17',20170108181,219,3.65,'Weather',''),(2078,16469,'2017-01-08 18:21:22','2017-01-08 18:44:22',20170108184,23,0.38,'Weather',''),(2079,16465,'2017-01-08 17:46:47','2017-01-08 19:31:47',20170108193,105,1.75,'Other','wether'),(2080,16562,'2017-01-15 13:19:21','2017-01-15 17:24:21',20170115172,245,4.08,'Full Silos',''),(2081,16568,'2017-01-15 17:35:34','2017-01-16 05:28:34',20170116052,713,11.88,'Full Silos',''),(2082,16574,'2017-01-15 18:57:16','2017-01-16 09:54:16',20170116095,897,14.95,'Surge Pile High',''),(2083,16580,'2017-01-16 05:39:38','2017-01-16 17:30:38',20170116173,711,11.85,'Full Silos',''),(2084,16584,'2017-01-16 17:41:32','2017-01-17 05:35:32',20170117053,714,11.90,'Full Silos',''),(2085,16591,'2017-01-17 05:47:10','2017-01-17 09:37:10',20170117093,230,3.83,'Other','sales met'),(2086,16591,'2017-01-17 17:04:24','2017-01-17 17:30:24',20170117173,26,0.43,'Material Change',''),(2087,16597,'2017-01-17 06:56:44','2017-01-17 17:30:44',20170117173,634,10.57,'Full Silos',''),(2088,16605,'2017-01-18 05:41:25','2017-01-18 09:04:25',20170118090,203,3.38,'Full Silos',''),(2089,16605,'2017-01-18 09:09:39','2017-01-18 09:11:39',20170118091,2,0.03,'Other','wet material'),(2090,16605,'2017-01-18 16:18:25','2017-01-18 17:28:25',20170118172,70,1.17,'Full Silos',''),(2091,16613,'2017-01-18 17:38:44','2017-01-19 05:33:44',20170119053,715,11.92,'Material Change',''),(2092,16621,'2017-01-19 07:44:21','2017-01-19 07:47:21',20170119074,3,0.05,'Other','temp'),(2093,16613,'2017-01-19 05:34:35','2017-01-19 07:51:35',20170119075,137,2.28,'Full Silos',''),(2094,16613,'2017-01-19 15:01:21','2017-01-19 17:32:21',20170119173,151,2.52,'Full Silos',''),(2095,16629,'2017-01-19 17:43:13','2017-01-20 05:31:13',20170120053,708,11.80,'Full Silos',''),(2096,16637,'2017-01-20 05:41:59','2017-01-20 17:30:59',20170120173,709,11.82,'Full Silos',''),(2097,16638,'2017-01-20 14:23:32','2017-01-20 18:09:32',20170120180,226,3.77,'Other','SCHEDULED MAINT'),(2098,16648,'2017-01-21 05:40:49','2017-01-21 17:33:49',20170121173,713,11.88,'Full Silos',''),(2099,16656,'2017-01-21 17:44:27','2017-01-22 04:35:27',20170122043,651,10.85,'Full Silos',''),(2100,16656,'2017-01-22 04:39:40','2017-01-22 04:41:40',20170122044,2,0.03,'Full Silos',''),(2101,16656,'2017-01-22 05:26:39','2017-01-22 05:31:39',20170122053,5,0.08,'Full Silos',''),(2102,16663,'2017-01-22 05:41:45','2017-01-22 06:13:45',20170122061,32,0.53,'Full Silos',''),(2103,16709,'2017-01-25 19:04:43','2017-01-25 19:08:43',20170125190,4,0.07,'Full Silos',''),(2104,16709,'2017-01-25 19:09:27','2017-01-25 19:15:27',20170125191,6,0.10,'Full Silos',''),(2105,16709,'2017-01-25 19:17:02','2017-01-25 19:23:02',20170125192,6,0.10,'Full Silos',''),(2106,16709,'2017-01-25 19:22:02','2017-01-25 19:23:02',20170125192,1,0.02,'Full Silos',''),(2107,16709,'2017-01-25 19:24:51','2017-01-25 20:44:51',20170125204,80,1.33,'Full Silos',''),(2108,16716,'2017-01-25 18:13:32','2017-01-26 00:43:32',20170126004,390,6.50,'Other','sch. maint.'),(2109,16709,'2017-01-26 05:20:44','2017-01-26 05:29:44',20170126052,9,0.15,'Full Silos',''),(2110,16717,'2017-01-26 12:15:35','2017-01-26 14:44:35',20170126144,149,2.48,'Shutdown Plant','maintenance'),(2111,16730,'2017-01-26 17:40:43','2017-01-27 05:33:43',20170127053,713,11.88,'Other','schedualed'),(2112,16736,'2017-01-27 05:44:23','2017-01-27 07:25:23',20170127072,101,1.68,'Full Silos',''),(2113,16735,'2017-01-27 11:09:53','2017-01-27 17:35:53',20170127173,386,6.43,'Shutdown Plant','maintenace'),(2114,16736,'2017-01-27 17:32:31','2017-01-27 17:36:31',20170127173,4,0.07,'Other','gate 2 fail to close'),(2115,16754,'2017-01-28 21:40:34','2017-01-29 05:30:34',20170129053,470,7.83,'Full Silos',''),(2116,16762,'2017-01-29 06:29:05','2017-01-29 17:32:05',20170129173,663,11.05,'Full Silos',''),(2117,16767,'2017-01-29 23:20:06','2017-01-29 23:46:06',20170129234,26,0.43,'Other','box full'),(2118,16771,'2017-01-29 17:43:02','2017-01-30 05:33:02',20170130053,710,11.83,'Shutdown Plant',''),(2119,16778,'2017-01-30 05:34:35','2017-01-30 12:57:35',20170130125,443,7.38,'Full Silos',''),(2120,16778,'2017-01-30 13:55:37','2017-01-30 17:29:37',20170130172,214,3.57,'Full Silos',''),(2121,16781,'2017-01-30 08:23:17','2017-01-30 17:30:17',20170130173,547,9.12,'Full Silos',''),(2122,16794,'2017-01-30 17:40:20','2017-01-30 23:11:20',20170130231,331,5.52,'Shutdown Plant',''),(2123,16787,'2017-01-30 17:40:39','2017-01-31 05:35:39',20170131053,715,11.92,'Loadout Bins Full',''),(2124,16797,'2017-01-31 05:46:52','2017-01-31 17:33:52',20170131173,707,11.78,'Full Silos',''),(2125,16800,'2017-01-31 15:39:32','2017-01-31 17:34:32',20170131173,115,1.92,'Full Silos',''),(2126,16803,'2017-01-31 17:44:10','2017-02-01 05:34:10',20170201053,710,11.83,'Full Silos',''),(2127,16804,'2017-02-01 05:33:27','2017-02-01 05:34:27',20170201053,1,0.02,'Material Change',''),(2128,16806,'2017-01-31 17:44:41','2017-02-01 05:34:41',20170201053,710,11.83,'Full Silos',''),(2129,16810,'2017-02-01 05:44:39','2017-02-01 06:57:39',20170201065,73,1.22,'Full Silos',''),(2130,16810,'2017-02-01 10:20:29','2017-02-01 17:29:29',20170201172,429,7.15,'Full Silos',''),(2131,16813,'2017-02-01 05:44:53','2017-02-01 17:29:53',20170201172,705,11.75,'Full Silos',''),(2132,16818,'2017-02-01 17:40:13','2017-02-02 05:38:13',20170202053,718,11.97,'Full Silos',''),(2133,16819,'2017-02-01 17:40:21','2017-02-02 05:39:21',20170202053,719,11.98,'Full Silos',''),(2134,16826,'2017-02-02 05:38:43','2017-02-02 10:11:43',20170202101,273,4.55,'Full Silos',''),(2135,16829,'2017-02-02 05:49:46','2017-02-02 10:54:46',20170202105,305,5.08,'Full Silos',''),(2136,16848,'2017-02-04 05:40:02','2017-02-04 17:30:02',20170204173,710,11.83,'Full Silos',''),(2137,16864,'2017-02-05 05:40:28','2017-02-05 17:30:28',20170205173,710,11.83,'Full Silos',''),(2138,16881,'2017-02-06 05:40:39','2017-02-06 17:34:39',20170206173,714,11.90,'Full Silos',''),(2139,16898,'2017-02-07 05:40:29','2017-02-07 17:29:29',20170207172,709,11.82,'Full Silos',''),(2140,16902,'2017-02-07 06:52:32','2017-02-07 18:23:32',20170207182,691,11.52,'Shutdown Plant','Scheduled'),(2141,16908,'2017-02-07 18:54:35','2017-02-08 05:20:35',20170208052,626,10.43,'Shutdown Plant',''),(2142,16910,'2017-02-08 05:40:23','2017-02-08 17:29:23',20170208172,709,11.82,'Full Silos',''),(2143,16914,'2017-02-08 17:39:31','2017-02-09 05:30:31',20170209053,711,11.85,'Full Silos',''),(2144,16923,'2017-02-09 05:56:43','2017-02-09 17:34:43',20170209173,698,11.63,'Full Silos',''),(2145,16936,'2017-02-09 17:44:29','2017-02-10 05:31:29',20170210053,707,11.78,'Full Silos',''),(2146,16944,'2017-02-10 05:59:50','2017-02-10 17:30:50',20170210173,691,11.52,'Full Silos',''),(2147,16952,'2017-02-10 17:41:19','2017-02-11 05:32:19',20170211053,711,11.85,'Full Silos',''),(2148,16964,'2017-02-11 07:23:05','2017-02-11 13:15:05',20170211131,352,5.87,'Full Silos',''),(2149,16961,'2017-02-11 05:33:45','2017-02-11 17:31:45',20170211173,718,11.97,'Full Silos',''),(2150,16983,'2017-02-12 05:47:54','2017-02-12 14:03:54',20170212140,496,8.27,'Full Silos',''),(2151,16983,'2017-02-12 16:11:00','2017-02-12 16:51:00',20170212165,40,0.67,'Full Silos',''),(2152,17016,'2017-02-14 04:36:22','2017-02-14 05:31:22',20170214053,55,0.92,'Weather',''),(2153,17019,'2017-02-14 00:13:29','2017-02-14 05:32:29',20170214053,319,5.32,'Other','c18'),(2154,17050,'2017-02-15 12:27:22','2017-02-15 14:28:22',20170215142,121,2.02,'Empty Plant',''),(2155,17050,'2017-02-15 14:29:40','2017-02-15 14:34:40',20170215143,5,0.08,'Empty Plant',''),(2156,17136,'2017-02-18 18:04:27','2017-02-19 05:36:27',20170219053,692,11.53,'Other','idle'),(2157,17177,'2017-02-19 05:47:30','2017-02-19 17:38:30',20170219173,711,11.85,'Full Silos',''),(2158,17200,'2017-02-20 05:43:50','2017-02-20 06:49:50',20170220064,66,1.10,'Full Silos',''),(2159,17200,'2017-02-20 12:49:42','2017-02-20 17:33:42',20170220173,284,4.73,'Full Silos',''),(2160,17222,'2017-02-20 17:45:01','2017-02-21 05:48:01',20170221054,723,12.05,'Full Silos',''),(2161,17243,'2017-02-21 05:59:20','2017-02-21 17:42:20',20170221174,703,11.72,'Full Silos',''),(2162,17242,'2017-02-21 06:47:39','2017-02-21 17:42:39',20170221174,655,10.92,'Full Silos',''),(2163,17245,'2017-02-21 17:52:36','2017-02-22 05:29:36',20170222052,697,11.62,'Full Silos',''),(2164,17247,'2017-02-21 23:26:47','2017-02-22 05:29:47',20170222052,363,6.05,'Full Silos',''),(2165,17253,'2017-02-22 05:40:10','2017-02-22 07:21:10',20170222072,101,1.68,'Full Silos',''),(2166,17253,'2017-02-22 16:30:04','2017-02-22 17:38:04',20170222173,68,1.13,'Full Silos',''),(2167,17268,'2017-02-22 17:47:57','2017-02-22 19:51:57',20170222195,124,2.07,'Full Silos',''),(2168,17275,'2017-02-23 12:11:48','2017-02-23 17:33:48',20170223173,322,5.37,'Shutdown Plant','plant maintnance'),(2169,17314,'2017-02-24 13:01:43','2017-02-24 14:49:43',20170224144,108,1.80,'Shutdown Plant','maintenance'),(2170,17314,'2017-02-24 17:11:09','2017-02-24 17:30:09',20170224173,19,0.32,'Other','gas'),(2171,17333,'2017-02-25 08:08:59','2017-02-25 17:34:59',20170225173,566,9.43,'Full Silos',''),(2172,17349,'2017-02-25 17:45:35','2017-02-25 19:17:35',20170225191,92,1.53,'Full Silos',''),(2173,17369,'2017-02-27 05:43:22','2017-02-27 07:01:22',20170227070,78,1.30,'Full Silos',''),(2174,17369,'2017-02-27 17:22:54','2017-02-27 17:31:54',20170227173,9,0.15,'Full Silos',''),(2175,17402,'2017-02-28 12:30:13','2017-02-28 17:31:13',20170228173,301,5.02,'Full Silos',''),(2176,17419,'2017-03-01 05:45:57','2017-03-01 17:28:57',20170301172,703,11.72,'Full Silos',''),(2177,17424,'2017-03-01 23:15:32','2017-03-01 23:24:32',20170301232,9,0.15,'Full Silos',''),(2178,17453,'2017-03-02 19:40:41','2017-03-03 05:32:41',20170303053,592,9.87,'Full Silos',''),(2179,17468,'2017-03-03 05:43:25','2017-03-03 17:25:25',20170303172,702,11.70,'Full Silos',''),(2180,17475,'2017-03-03 17:35:59','2017-03-04 05:30:59',20170304053,715,11.92,'Full Silos',''),(2181,17483,'2017-03-04 05:41:13','2017-03-04 17:33:13',20170304173,712,11.87,'Full Silos',''),(2182,17516,'2017-03-04 17:43:16','2017-03-04 18:36:16',20170304183,53,0.88,'Full Silos',''),(2183,17538,'2017-03-06 05:41:55','2017-03-06 17:22:55',20170306172,701,11.68,'Full Silos',''),(2184,17633,'2017-03-11 17:29:46','2017-03-11 17:34:46',20170311173,5,0.08,'Startup Plant',''),(2185,17644,'2017-03-12 13:05:44','2017-03-12 15:58:44',20170312155,173,2.88,'Other','gas issues'),(2186,17644,'2017-03-12 15:59:51','2017-03-12 16:31:51',20170312163,32,0.53,'Other','gas issues'),(2187,17655,'2017-03-13 05:40:58','2017-03-13 15:47:58',20170313154,607,10.12,'Full Silos',''),(2188,17673,'2017-03-14 05:25:06','2017-03-14 05:29:06',20170314052,4,0.07,'Other','idk'),(2189,17684,'2017-03-14 10:06:29','2017-03-14 17:41:29',20170314174,455,7.58,'Full Silos',''),(2190,17705,'2017-03-14 17:51:39','2017-03-15 02:35:39',20170315023,524,8.73,'Full Silos',''),(2191,17703,'2017-03-14 22:29:11','2017-03-15 05:31:11',20170315053,422,7.03,'Full Silos',''),(2192,17704,'2017-03-14 22:24:39','2017-03-15 05:31:39',20170315053,427,7.12,'Full Silos',''),(2193,17705,'2017-03-15 04:49:00','2017-03-15 05:32:00',20170315053,43,0.72,'Full Silos',''),(2194,17714,'2017-03-15 05:41:30','2017-03-15 07:37:30',20170315073,116,1.93,'Full Silos',''),(2195,17714,'2017-03-15 07:38:26','2017-03-15 07:46:26',20170315074,8,0.13,'Full Silos',''),(2196,17756,'2017-03-17 15:07:45','2017-03-17 17:23:45',20170317172,136,2.27,'Full Silos',''),(2197,17762,'2017-03-17 17:34:44','2017-03-18 05:29:44',20170318052,715,11.92,'Full Silos',''),(2198,17770,'2017-03-18 05:39:23','2017-03-18 17:31:23',20170318173,712,11.87,'Full Silos',''),(2199,17789,'2017-03-18 17:42:03','2017-03-19 05:39:03',20170319053,717,11.95,'Full Silos',''),(2200,17811,'2017-03-19 05:48:48','2017-03-19 09:36:48',20170319093,228,3.80,'Full Silos',''),(2201,17896,'2017-03-22 22:50:53','2017-03-23 02:05:53',20170323020,195,3.25,'Full Silos',''),(2202,17945,'2017-03-25 21:47:13','2017-03-25 22:50:13',20170325225,63,1.05,'Full Silos',''),(2203,17945,'2017-03-26 05:33:23','2017-03-26 05:42:23',20170326054,9,0.15,'Full Silos',''),(2204,18083,'2017-04-01 23:32:45','2017-04-02 05:24:45',20170402052,352,5.87,'Full Silos',''),(2205,18091,'2017-04-02 09:00:42','2017-04-02 17:28:42',20170402172,508,8.47,'Full Silos',''),(2206,18094,'2017-04-02 06:52:55','2017-04-02 17:28:55',20170402172,636,10.60,'Full Silos',''),(2207,18111,'2017-04-02 17:38:47','2017-04-03 05:30:47',20170403053,712,11.87,'Full Silos',''),(2208,18113,'2017-04-02 17:38:55','2017-04-03 05:30:55',20170403053,712,11.87,'Full Silos',''),(2209,18121,'2017-04-03 05:41:53','2017-04-03 09:13:53',20170403091,212,3.53,'Full Silos',''),(2210,18118,'2017-04-03 08:45:29','2017-04-03 17:43:29',20170403174,538,8.97,'Full Silos',''),(2211,18159,'2017-04-05 02:28:12','2017-04-05 05:29:12',20170405052,181,3.02,'Full Silos',''),(2212,18169,'2017-04-05 07:10:45','2017-04-05 17:02:45',20170405170,592,9.87,'Other','scheduled'),(2213,18166,'2017-04-05 12:18:42','2017-04-05 17:25:42',20170405172,307,5.12,'Full Silos',''),(2214,18171,'2017-04-06 03:32:13','2017-04-06 05:32:13',20170406053,120,2.00,'Full Silos',''),(2215,18181,'2017-04-06 08:22:05','2017-04-06 17:56:05',20170406175,574,9.57,'Full Silos',''),(2216,18275,'2017-04-12 17:47:16','2017-04-12 20:51:16',20170412205,184,3.07,'Full Silos',''),(2217,18289,'2017-04-14 01:22:36','2017-04-14 05:29:36',20170414052,247,4.12,'Full Silos',''),(2218,18307,'2017-04-14 07:17:52','2017-04-14 17:30:52',20170414173,613,10.22,'Full Silos',''),(2219,18320,'2017-04-15 06:49:39','2017-04-15 17:27:39',20170415172,638,10.63,'Full Silos',''),(2220,18332,'2017-04-15 17:37:19','2017-04-16 05:28:19',20170416052,711,11.85,'Full Silos',''),(2221,18342,'2017-04-16 05:38:18','2017-04-16 12:14:18',20170416121,396,6.60,'Full Silos',''),(2222,18384,'2017-04-18 07:46:00','2017-04-18 13:07:00',20170418130,321,5.35,'Full Silos',''),(2223,18401,'2017-04-19 05:59:17','2017-04-19 14:17:17',20170419141,498,8.30,'Full Silos',''),(2224,18438,'2017-04-21 17:54:21','2017-04-21 18:01:21',20170421180,7,0.12,'Full Silos',''),(2225,18448,'2017-04-21 18:11:13','2017-04-21 20:20:13',20170421202,129,2.15,'Full Silos',''),(2226,18448,'2017-04-22 03:27:25','2017-04-22 05:32:25',20170422053,125,2.08,'Full Silos',''),(2227,18528,'2017-04-26 06:54:14','2017-04-26 17:33:14',20170426173,639,10.65,'Full Silos',''),(2228,18531,'2017-04-26 17:43:21','2017-04-27 05:39:21',20170427053,716,11.93,'Full Silos',''),(2229,18540,'2017-04-27 05:49:31','2017-04-27 14:46:31',20170427144,537,8.95,'Full Silos',''),(2230,18537,'2017-04-27 12:50:36','2017-04-27 17:30:36',20170427173,280,4.67,'Other','problems with new construction at OWP'),(2231,18562,'2017-04-28 09:40:39','2017-04-28 17:31:39',20170428173,471,7.85,'Full Silos',''),(2232,18567,'2017-04-28 16:19:52','2017-04-28 17:31:52',20170428173,72,1.20,'Full Silos',''),(2233,18588,'2017-04-29 01:27:22','2017-04-29 05:28:22',20170429052,241,4.02,'Full Silos',''),(2234,18589,'2017-04-28 21:53:30','2017-04-29 05:28:30',20170429052,455,7.58,'Full Silos',''),(2235,18600,'2017-04-29 12:50:13','2017-04-29 17:29:13',20170429172,279,4.65,'Full Silos',''),(2236,18608,'2017-04-29 20:31:58','2017-04-30 05:29:58',20170430052,538,8.97,'Full Silos',''),(2237,18652,'2017-05-01 09:25:53','2017-05-01 09:51:53',20170501095,26,0.43,'Material Change',''),(2238,18654,'2017-05-01 09:46:02','2017-05-01 13:58:02',20170501135,252,4.20,'Full Silos',''),(2239,18654,'2017-05-01 15:33:59','2017-05-01 15:37:59',20170501153,4,0.07,'Material Change',''),(2240,18654,'2017-05-01 15:42:02','2017-05-01 15:44:02',20170501154,2,0.03,'Material Change',''),(2241,18652,'2017-05-01 17:01:03','2017-05-01 17:35:03',20170501173,34,0.57,'Material Change',''),(2242,18752,'2017-05-07 08:14:07','2017-05-07 08:18:07',20170507081,4,0.07,'Emptying Bin',''),(2243,18764,'2017-05-09 05:30:26','2017-05-09 05:31:26',20170509053,1,0.02,'Other','l'),(2244,18798,'2017-05-11 17:10:25','2017-05-11 17:29:25',20170511172,19,0.32,'Shutdown Plant',''),(2245,18862,'2017-05-15 04:39:53','2017-05-15 05:36:53',20170515053,57,0.95,'Other','gas valve malfunction'),(2246,18863,'2017-05-14 21:16:17','2017-05-15 05:37:17',20170515053,501,8.35,'Full Silos',''),(2247,18896,'2017-05-16 13:54:01','2017-05-16 13:56:01',20170516135,2,0.03,'Other','gas'),(2248,18896,'2017-05-16 13:58:24','2017-05-16 14:01:24',20170516140,3,0.05,'Other','gas'),(2249,18896,'2017-05-16 14:03:47','2017-05-16 14:06:47',20170516140,3,0.05,'Other','gas'),(2250,18896,'2017-05-16 14:09:23','2017-05-16 14:12:23',20170516141,3,0.05,'Other','gas'),(2251,18896,'2017-05-16 14:14:31','2017-05-16 14:16:31',20170516141,2,0.03,'Other','other'),(2252,18896,'2017-05-16 14:19:46','2017-05-16 14:20:46',20170516142,1,0.02,'Other','gas'),(2253,18896,'2017-05-16 14:23:44','2017-05-16 14:32:44',20170516143,9,0.15,'Other','gas'),(2254,18896,'2017-05-16 14:34:43','2017-05-16 14:40:43',20170516144,6,0.10,'Other','gas'),(2255,18896,'2017-05-16 14:46:30','2017-05-16 14:52:30',20170516145,6,0.10,'Other','gas'),(2256,18900,'2017-05-16 17:39:25','2017-05-17 05:38:25',20170517053,719,11.98,'Full Silos',''),(2257,18969,'2017-05-18 07:27:22','2017-05-18 17:55:22',20170518175,628,10.47,'Other','Maintenance'),(2258,18975,'2017-05-19 05:57:53','2017-05-19 17:31:53',20170519173,694,11.57,'Other','regulator bad'),(2259,19001,'2017-05-22 05:19:24','2017-05-22 05:32:24',20170522053,13,0.22,'Startup Plant',''),(2260,19018,'2017-05-22 08:42:32','2017-05-22 14:07:32',20170522140,325,5.42,'Other','schedauled'),(2261,19021,'2017-05-22 17:41:43','2017-05-22 20:10:43',20170522201,149,2.48,'Full Silos',''),(2262,19022,'2017-05-23 03:21:25','2017-05-23 05:26:25',20170523052,125,2.08,'Full Silos',''),(2263,19075,'2017-05-26 09:12:10','2017-05-26 14:17:10',20170526141,305,5.08,'Full Silos',''),(2264,19173,'2017-05-31 11:03:52','2017-05-31 11:24:52',20170531112,21,0.35,'Other','elecrtical malffunction'),(2265,19174,'2017-05-31 06:56:25','2017-05-31 17:35:25',20170531173,639,10.65,'Other','Scheduled Maint.'),(2266,19232,'2017-06-05 05:56:58','2017-06-05 06:02:58',20170605060,6,0.10,'Full Silos',''),(2267,19233,'2017-06-05 05:32:38','2017-06-05 06:03:38',20170605060,31,0.52,'Full Silos',''),(2268,19424,'2017-06-16 05:24:48','2017-06-16 05:33:48',20170616053,9,0.15,'Surge Pile High',''),(2269,19497,'2017-06-20 10:07:56','2017-06-20 17:52:56',20170620175,465,7.75,'Electrical Maintenance',''),(2270,19534,'2017-06-23 05:51:45','2017-06-23 14:58:45',20170623145,547,9.12,'Shutdown Plant','down day'),(2271,19534,'2017-06-23 14:59:46','2017-06-23 15:08:46',20170623150,9,0.15,'Shutdown Plant','down day'),(2272,19534,'2017-06-23 15:09:56','2017-06-23 15:14:56',20170623151,5,0.08,'Shutdown Plant','down day'),(2273,19534,'2017-06-23 15:16:45','2017-06-23 15:20:45',20170623152,4,0.07,'Shutdown Plant','down day'),(2274,19534,'2017-06-23 15:22:08','2017-06-23 15:27:08',20170623152,5,0.08,'Shutdown Plant','down day'),(2275,19574,'2017-06-24 09:19:52','2017-06-24 09:20:52',20170624092,1,0.02,'Material Change',''),(2276,19650,'2017-06-28 05:05:32','2017-06-28 07:04:32',20170628070,119,1.98,'Shutdown Plant',''),(2277,19662,'2017-06-28 11:31:38','2017-06-28 11:38:38',20170628113,7,0.12,'Other','temp out');
/*!40000 ALTER TABLE `prod_auto_plant_idletime` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-01-17 13:56:42
