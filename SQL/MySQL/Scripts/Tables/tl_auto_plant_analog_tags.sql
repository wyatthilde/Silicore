/*******************************************************************************************************************************************
 * File Name: tl_auto_plant_analog_tags.sql
 * Project: smashbox
 * Description: This table stores the performance thresholds for Sieve sizes by Location.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 09/06/2017|mnutsch|KACE:17959 - Initial creation
 * 
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `tl_auto_plant_analog_tags`;

CREATE TABLE `tl_auto_plant_analog_tags` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `device` varchar(50) DEFAULT NULL,
  `classification` varchar(50) DEFAULT NULL,
  `tag` varchar(50) DEFAULT NULL,
  `tag_plc` varchar(50) DEFAULT NULL,
  `units` varchar(10) DEFAULT NULL,
  `plant_id` int(3) DEFAULT NULL,
  `is_mir` tinyint(1) NOT NULL DEFAULT '0',
  `is_kpi` tinyint(1) NOT NULL DEFAULT '0',
  `is_hidden` tinyint(1) NOT NULL DEFAULT '0',
  `is_removed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag_UNIQUE` (`tag`),
  UNIQUE KEY `tag_plc_UNIQUE` (`tag_plc`)
) ENGINE=InnoDB AUTO_INCREMENT=286 DEFAULT CHARSET=latin1;