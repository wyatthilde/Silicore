/*******************************************************************************************************************************************
 * File Name: gb_qc_k_values.sql
 * Project: Sandbox
 * Author: mnutsch
 * Date Created: 6-9-2017
 * Description: This table holds QC k value options.
 * Notes: Copied from an existing BackOffice table.
 *        The database table should be prefixed with the plant abbreviation: gb_ = granbury, etc.
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `gb_qc_k_values`;

CREATE TABLE `gb_qc_k_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(50) NOT NULL,
  `value` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_index` (`description`,`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=latin1;

INSERT INTO `gb_qc_k_values` (`id`,`description`,`value`) VALUES (1,'4K',4);
INSERT INTO `gb_qc_k_values` (`id`,`description`,`value`) VALUES (2,'5K',5);
INSERT INTO `gb_qc_k_values` (`id`,`description`,`value`) VALUES (3,'6K',6);
INSERT INTO `gb_qc_k_values` (`id`,`description`,`value`) VALUES (4,'7K',7);
INSERT INTO `gb_qc_k_values` (`id`,`description`,`value`) VALUES (5,'8K',8);
INSERT INTO `gb_qc_k_values` (`id`,`description`,`value`) VALUES (6,'9K',9);
INSERT INTO `gb_qc_k_values` (`id`,`description`,`value`) VALUES (7,'10K',10);
INSERT INTO `gb_qc_k_values` (`id`,`description`,`value`) VALUES (8,'11K',11);
INSERT INTO `gb_qc_k_values` (`id`,`description`,`value`) VALUES (9,'12K',12);
INSERT INTO `gb_qc_k_values` (`id`,`description`,`value`) VALUES (10,'13K',13);
INSERT INTO `gb_qc_k_values` (`id`,`description`,`value`) VALUES (11,'14K',14);
INSERT INTO `gb_qc_k_values` (`id`,`description`,`value`) VALUES (12,'15K',15);
INSERT INTO `gb_qc_k_values` (`id`,`description`,`value`) VALUES (13,'16K',16);
INSERT INTO `gb_qc_k_values` (`id`,`description`,`value`) VALUES (14,'17K',17);
