
/*******************************************************************************************************************************************
 * File Name: gb_plc_runtime.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/15/2017|whildebrandt|KACE:19563 - created table gb_plc_runtime for new plc tables
 * 11/29/2017|whildebrandt|KACE:19563 - added xfer_id to gb_plc_runtime table
 ******************************************************************************************************************************************/
DROP TABLE IF EXISTS `gb_plc_runtime`;
CREATE TABLE `gb_plc_runtime` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `shift_id` bigint(20) DEFAULT NULL,
  `duration_minutes` int(5) DEFAULT NULL,
  `duration` decimal(5,2) DEFAULT NULL,
  `device` varchar(64) DEFAULT NULL,
  `tag_id` bigint(20) DEFAULT NULL,
  `tag` varchar(32) DEFAULT NULL,
  `create_dt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `date` (`duration_minutes`),
  `Xfer_id` bigint(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

