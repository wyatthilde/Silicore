
/*******************************************************************************************************************************************
 * File Name: gb_plc_analog_data_dryer_temp.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/15/2017|whildebrandt|KACE:19563 - created table gb_plc_analog_data_dryer_temp for new plc tables
 * 11/29/2017|whildebrandt|KACE:19563 - altered table to include xfer and removed short date 
 ******************************************************************************************************************************************/
DROP TABLE IF EXISTS `gb_plc_analog_data_dryer_temp`;

CREATE TABLE `gb_plc_analog_data_dryer_temp` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tag_id` bigint(20) NOT NULL,
  `tag_plc` varchar(50) DEFAULT NULL,
  `value` decimal(16,4) DEFAULT NULL,
  `dt` datetime DEFAULT NULL,
  `Xfer_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_index` (`tag_id`,`tag_plc`,`value`,`dt`),
  KEY `dt` (`dt`),
  KEY `tag_id` (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

