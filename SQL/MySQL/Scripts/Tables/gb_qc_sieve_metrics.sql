/*******************************************************************************************************************************************
 * File Name: qc_sieve_metrics.sql
 * Project: Sandbox
 * Author: kkuehn, mnutsch
 * Date Created: 6-15-2017
 * Description: 
 * Notes: 
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `gb_qc_sieve_metrics`;

CREATE TABLE `gb_qc_sieve_metrics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `screen` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

# INSERT LEGACY BACKOFFICE DATA HERE
insert into gb_qc_sieve_metrics (screen)
values
('30'),
('40'),
('45'),
('50'),
('60'),
('70');

# ADD CONSTRAINTS, FOREIGN KEYS, INDEXES, ETC.

