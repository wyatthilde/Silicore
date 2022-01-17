
/*******************************************************************************************************************************************
 * File Name: gb_plc_shifts.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/15/2017|whildebrandt|KACE:19563 - created table gp_plc_shifts for a new plc tables
 * 11/29/2017|whildebrandt|KACE:19563 - added xfer_id to shifts table
 ******************************************************************************************************************************************/
DROP TABLE IF EXISTS `gb_plc_shifts`;
CREATE TABLE `gb_plc_shifts` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `prod_area_id` int(3) NOT NULL,
  `prod_area` varchar(64) NOT NULL,
  `plant_id` int(3) NOT NULL,
  `date` date NOT NULL,
  `shift` varchar(5) NOT NULL,
  `start_dt` datetime NOT NULL,
  `end_dt` datetime DEFAULT NULL,
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
  `Xfer_id` bigint(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;



