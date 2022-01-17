
/*******************************************************************************************************************************************
 * File Name: gb_qc_sample_groups.sql
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 02/06/2018|whildebrandt|KACE:20787 - Initial creation
 *
 ******************************************************************************************************************************************/
DROP TABLE IF EXISTS `gb_qc_sample_groups`;
CREATE TABLE `gb_qc_sample_groups` 
(
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`create_date` datetime, 
	`create_user_id` int(11),
	`modify_date` datetime,
	`modify_user_id` int(11),
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


