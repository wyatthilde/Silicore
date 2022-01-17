
/*******************************************************************************************************************************************
 * File Name: gb_plc_downtime.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/15/2017|whildebrandt|KACE:19563 - created table gb_plc_downtime for new plc tables
 *
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `gb_plc_downtime`;

CREATE TABLE `gb_plc_downtime` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `shift_id` bigint(20) NOT NULL,
  `start_dt` datetime NOT NULL,
  `end_dt` datetime NOT NULL,
  `end_dt_short` bigint(11) NOT NULL,
  `duration_minutes` int(5) NOT NULL,
  `duration` decimal(5,2) NOT NULL,
  `reason` varchar(64) DEFAULT NULL,
  `device_name` varchar(255) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `is_scheduled` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `end_dt_short` (`end_dt_short`)
) ENGINE=InnoDB AUTO_INCREMENT=12017 DEFAULT CHARSET=latin1;



