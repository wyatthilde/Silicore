/*******************************************************************************************************************************************
 * File Name: tl_qc_sieve_stacks.sql
 * Project: smashbox
 * Description: This table stores the performance thresholds for Sieve sizes by Location.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 09/06/2017|mnutsch|KACE:17959 - Initial creation
 * 
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `tl_qc_sieve_stacks`;

CREATE TABLE `tl_qc_sieve_stacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(64) NOT NULL,
  `main_site_id` int(11) DEFAULT NULL,
  `sort_order` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_camsizer` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_index` (`description`,`main_site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;