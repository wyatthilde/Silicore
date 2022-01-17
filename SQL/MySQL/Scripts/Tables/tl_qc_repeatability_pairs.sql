/*******************************************************************************************************************************************
 * File Name: tl_qc_repeatability_pairs.sql
 * Project: smashbox
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 09/05/2017|mnutsch|KACE:17959 - Initial creation
 * 
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `tl_qc_repeatability_pairs`;

CREATE TABLE `tl_qc_repeatability_pairs` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `original_sample` bigint(20) NOT NULL,
  `repeated_sample` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_index` (`original_sample`,`repeated_sample`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=latin1;


