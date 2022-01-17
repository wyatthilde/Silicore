/*******************************************************************************************************************************************
 * File Name: gb_qc_k_value_records.sql
 * Project: Silicore
 * Description: This table will store QC K Value records.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 07/14/2017|mnutsch|KACE:17366 - Initial creation
 * 
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `gb_qc_k_value_records`;

CREATE TABLE `gb_qc_k_value_records` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sample_id` int(11) NOT NULL,
  `k_value_id` int(11) NOT NULL,
  `pan_number` int(11) NOT NULL,
  `value` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=latin1;


