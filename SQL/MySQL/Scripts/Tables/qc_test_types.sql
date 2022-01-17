/*******************************************************************************************************************************************
 * File Name: qc_test_types.sql
 * Project: Sandbox
 * Author: kkuehn
 * Date Created: Jan 12, 2017[4:50:05 PM]
 * Description: 
 * Notes: 
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `sandbox`.`qc_test_types`;

CREATE TABLE `sandbox`.`qc_test_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(64) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

# INSERT LEGACY BACKOFFICE DATA HERE
insert into qc_test_types (description,sort_order,is_active)
values
('Inhibited',16,1),
('Test',4,1),
('Retest',8,1),
('Misc',12,1),
('Calibration',20,1),
('Repeatability',10,1);

# ADD CONSTRAINTS, FOREIGN KEYS, INDEXES, ETC.

