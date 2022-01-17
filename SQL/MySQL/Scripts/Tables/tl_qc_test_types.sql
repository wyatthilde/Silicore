 /*******************************************************************************************************************************************
 * File Name: tl_qc_test_types.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 09/06/2017|mnutsch|KACE:17959 - Initial creation
 * 
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `tl_qc_test_types`;

CREATE TABLE `tl_qc_test_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(64) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

insert into tl_qc_test_types (description,sort_order,is_active)
values
('Inhibited',16,1),
('Test',4,1),
('Retest',8,1),
('Misc',12,1),
('Calibration',20,1),
('Repeatability',10,1);

