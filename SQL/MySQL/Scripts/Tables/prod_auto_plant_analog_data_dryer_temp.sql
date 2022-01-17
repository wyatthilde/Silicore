/*******************************************************************************************************************************************
 * File Name: prod_auto_plant_analog_data_dryer_temp.sql
 * Project: Silicore
 * Description: 
 * Notes: 
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 06/28/2017|kkuehn|KACE:17349 - Initial creation
 * 
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `prod_auto_plant_analog_data_dryer_temp`;

CREATE TABLE `prod_auto_plant_analog_data_dryer_temp` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tag_id` bigint(20) NOT NULL,
  `tag_plc` varchar(50) DEFAULT NULL,
  `value` decimal(16,4) DEFAULT NULL,
  `dt` datetime DEFAULT NULL,
  `dt_short` bigint(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_index` (`tag_id`,`tag_plc`,`value`,`dt`),
  KEY `dt` (`dt`),
  KEY `tag_id` (`tag_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34608635 DEFAULT CHARSET=latin1;


