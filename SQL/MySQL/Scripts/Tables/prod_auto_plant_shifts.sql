/*******************************************************************************************************************************************
 * File Name: prod_auto_plant_shifts.sql
 * Project: Silicore
 * Description: 
 * Notes: 
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 06/28/2017|kkuehn|KACE:17349 - Initial creation
 * 
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `prod_auto_plant_shifts`;

CREATE TABLE `prod_auto_plant_shifts` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `prod_area_id` int(3) NOT NULL,
  `prod_area` varchar(64) NOT NULL,
  `plant_id` int(3) NOT NULL,
  `date` date NOT NULL,
  `date_short` bigint(8) NOT NULL,
  `shift` varchar(5) NOT NULL,
  `start_dt` datetime NOT NULL,
  `start_dt_short` bigint(11) NOT NULL,
  `end_dt` datetime DEFAULT NULL,
  `end_dt_short` bigint(11) DEFAULT NULL,
  `operator` varchar(32) NOT NULL,
  `duration_minutes` int(5) NOT NULL,
  `duration` decimal(5,2) NOT NULL,
  `uptime` decimal(5,2) NOT NULL,
  `uptime_percent` decimal(5,4) NOT NULL,
  `downtime` decimal(5,2) NOT NULL,
  `downtime_percent` decimal(5,4) NOT NULL,
  `idletime` decimal(5,2) NOT NULL,
  `idletime_percent` decimal(5,4) NOT NULL,
  `is_removed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `plant_id` (`plant_id`),
  KEY `date_short` (`date_short`)
) ENGINE=InnoDB AUTO_INCREMENT=19694 DEFAULT CHARSET=latin1;



