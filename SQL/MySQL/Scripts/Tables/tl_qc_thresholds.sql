/*******************************************************************************************************************************************
 * File Name: tl_qc_thresholds.sql
 * Project: smashbox
 * Description: This table stores the performance thresholds for Sieve sizes by Location.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 09/06/2017|mnutsch|KACE:17959 - Initial creation
 * 
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `tl_qc_thresholds`;

CREATE TABLE `tl_qc_thresholds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `screen` varchar(16) NOT NULL,
  `location_id` int(11) DEFAULT NULL,
  `low_threshold` double NOT NULL,
  `high_threshold` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;