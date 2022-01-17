
/*******************************************************************************************************************************************
 * File Name: gb_plc_analog_tags.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/15/2017|whildebrandt|KACE:19563 - created table gb_plc_analog_tags for new plc tables
 *
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `gb_plc_analog_tags`;

CREATE TABLE `gb_plc_analog_tags` (
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
) ENGINE=InnoDB AUTO_INCREMENT=302 DEFAULT CHARSET=latin1;


