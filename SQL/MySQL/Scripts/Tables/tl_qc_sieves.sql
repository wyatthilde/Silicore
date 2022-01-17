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

DROP TABLE IF EXISTS `tl_qc_sieves`;

CREATE TABLE `tl_qc_sieves` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sieve_stack_id` int(11) DEFAULT NULL,
  `screen` varchar(16) NOT NULL,
  `start_weight` decimal(5,1) DEFAULT NULL,
  `sort_order` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `create_date` datetime DEFAULT NULL,
  `create_user_id` int(11) DEFAULT NULL,
  `edit_date` datetime DEFAULT NULL,
  `edit_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;