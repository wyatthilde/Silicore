
/*******************************************************************************************************************************************
 * File Name: gb_plc_analog_data.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/15/2017|whildebrandt|KACE:19563 - created table gb_plc_analog_data for new plc tables
 *
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `gb_plc_analog_data`;
CREATE TABLE `gb_plc_analog_data` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tag_id` bigint(20) NOT NULL,
  `tag_plc` varchar(50) DEFAULT NULL,
  `value` decimal(16,4) DEFAULT NULL,
  `dt` datetime DEFAULT NULL,
  `dt_short` bigint(11) DEFAULT NULL,
  `interval_seconds` int(7) NOT NULL DEFAULT '600',
  `email_sent_dt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_index` (`tag_id`,`tag_plc`,`value`,`dt`),
  KEY `dt` (`dt`),
  KEY `tag_id` (`tag_id`),
  `Xfer_id` bigint(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=982661 DEFAULT CHARSET=latin1;
