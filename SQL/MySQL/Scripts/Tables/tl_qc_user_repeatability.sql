 /*******************************************************************************************************************************************
 * File Name: tl_qc_user_repeatability.sql
 * Project: Silicore
 * Description: This table stores the repeatability count for each user
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 09/06/2017|mnutsch|KACE:17959 - Initial creation
 * 
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `tl_qc_user_repeatability`;

CREATE TABLE `tl_qc_user_repeatability` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `repeatability_counter` int(11) NOT NULL DEFAULT '100',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
