
/*******************************************************************************************************************************************
 * File Name: gb_plc_idletime.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/15/2017|whildebrandt|KACE:19563 - created table gb_plc_idletime for new plc tables
 * 11/29/2017|whildebrandt|KACE:19563 - added xfer_id to idletime table
 ******************************************************************************************************************************************/
DROP TABLE IF EXISTS `gb_plc_idletime`;
CREATE TABLE `gb_plc_idletime` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `shift_id` bigint(20) NOT NULL,
  `start_dt` datetime NOT NULL,
  `end_dt` datetime NOT NULL,
  `duration_minutes` int(5) NOT NULL,
  `duration` decimal(5,2) NOT NULL,
  `reason` varchar(64) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `end_dt_short` (`end_dt_short`),
  `Xfer_id` bigint(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


