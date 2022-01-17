/*******************************************************************************************************************************************
 * File Name: gb_qc_sieve_stacks.sql
 * Project: Sandbox
 * Author: mnutsch
 * Date Created: 5-11-2017
 * Description: 
 * Notes: 
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `sandbox`.`gb_qc_sieve_stacks`;

CREATE TABLE `sandbox`.`gb_qc_sieve_stacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(64) NOT NULL,
  `main_site_id` int(11) DEFAULT NULL,
  `sort_order` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_index` (`description`,`main_site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# INSERT LEGACY BACKOFFICE DATA HERE
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Camsizer (Wet Plant & 100)', '10', '10', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Canty', '10', '6', '0');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Master Set (40/70)', '10', '998', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Sieve Set A', '10', '14', '0');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Sieve Set B', '10', '18', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Sieve Set C', '10', '22', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Sieve Set D', '10', '26', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Sieve Set E', '10', '30', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Sieve Set F', '10', '34', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Sieve Set G', '10', '38', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Sieve Set H', '10', '42', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Sieve Set I', '10', '46', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Sieve Set J', '10', '50', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Sieve Set K (40/70)', '10', '54', '0');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Sieve Set L', '10', '58', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Sieve Set M', '10', '62', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Sieve Set N', '10', '66', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Sieve Set O', '10', '70', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Sieve Set P', '10', '74', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Sieve Set Q', '10', '78', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Master Set (100)', '10', '999', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Camsizer (Dry Plant 40/70)', '10', '11', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Sieve Set A', '30', '10', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Sieve Set B', '30', '14', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Sieve Set C', '30', '18', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Sieve Set R', '30', '22', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Sieve Set S', '30', '26', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Sieve Set T', '30', '30', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Sieve Set ASTM (20/40)', '30', '34', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Sieve Set R (40/70)', '10', '82', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Sieve Set S (40/70)', '10', '86', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Sieve Set T (40/70)', '10', '90', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Sieve Set K', '10', '53', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Sieve Set Z (30/50) old', '10', '95', '0');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Fine Sample Sieve 1 old', '10', '102', '0');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Fine Sample Sieve 2 old', '10', '106', '0');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Fine Sample Sieve 3  ', '10', '110', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Fine Sample Sieve 4', '10', '114', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Fine Sample Sieve 5', '10', '118', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Fine Sample Sieve 6', '10', '122', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Fine Sample Sieve 7', '10', '126', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Camsizer (Fine)', '10', '12', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Master (Fine)', '10', '1000', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Test 170', '10', '128', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Sieve Set U (40/70)', '10', '91', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Sieve Set A (C4)', '10', '14', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Camsizer (Oversize)', '10', '13', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Sieve Set Z (30/50)', '10', '95', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Fine Sample Sieve 1', '10', '103', '1');
INSERT INTO `sandbox`.`gb_qc_sieve_stacks` (`description`, `main_site_id`, `sort_order`, `is_active`) VALUES ('Fine Sample Sieve 2', '10', '107', '1');

