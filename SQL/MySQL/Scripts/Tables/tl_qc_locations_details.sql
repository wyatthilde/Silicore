 /*******************************************************************************************************************************************
 * File Name: tl_qc_locations_details.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 09/05/2017|mnutsch|KACE:17959 - Initial creation
 * 
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `tl_qc_locations_details`;

CREATE TABLE `tl_qc_locations_details` (
  `id` int(11) NOT NULL,
  `qc_location_id` int(11) NOT NULL,
  `description` varchar(256) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

