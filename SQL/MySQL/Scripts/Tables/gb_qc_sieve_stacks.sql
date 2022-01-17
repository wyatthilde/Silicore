/* * *****************************************************************************************************************************************
 * File Name: gb_qc_sieve_stacks.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 06/23/2017|mnutsch|KACE:xxxxx - Initial creation
 * 08/04/2017|mnutsch|KACE:17803 - Updated sort order based on feedback from Ryan Banning in QC.
 * 08/16/2017|mnutsch|KACE:17957 - Added new Sieve Stacks for Cresson from Granbury.
 * 
 * **************************************************************************************************************************************** */

DROP TABLE IF EXISTS `gb_qc_sieve_stacks`;

CREATE TABLE `gb_qc_sieve_stacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(64) NOT NULL,
  `main_site_id` int(11) DEFAULT NULL,
  `sort_order` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_camsizer` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_index` (`description`,`main_site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2', 'Canty', '10', '6', '0', '1');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('4', 'Sieve Set A', '10', '14', '0', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('33', 'Sieve Set K old v2', '10', '53', '0', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('14', 'Sieve Set K (40/70)', '10', '54', '0', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('15', 'Sieve Set L', '10', '58', '0', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('16', 'Sieve Set M', '10', '62', '0', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('17', 'Sieve Set N', '10', '66', '0', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('18', 'Sieve Set O', '10', '70', '0', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('19', 'Sieve Set P', '10', '74', '0', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('20', 'Sieve Set Q', '10', '78', '0', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('34', 'Sieve Set Z (30/50) old', '10', '95', '0', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('35', 'Fine Sample Sieve 1 old', '10', '102', '0', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('36', 'Fine Sample Sieve 2 old', '10', '106', '0', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('37', 'Fine Sample Sieve 3 old', '10', '110', '0', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('38', 'Fine Sample Sieve 4 old', '10', '114', '0', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('1', 'Camsizer (Wet Plant & 100)', '10', '10', '1', '1');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('22', 'Camsizer (Dry Plant 40/70)', '10', '20', '1', '1');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('47', 'Camsizer (Oversize)', '10', '30', '1', '1');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('46', 'Sieve Set A (C4)', '10', '40', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('5', 'Sieve Set B', '10', '50', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('6', 'Sieve Set C', '10', '60', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('7', 'Sieve Set D', '10', '70', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('8', 'Sieve Set E', '10', '80', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('9', 'Sieve Set F', '10', '90', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('10', 'Sieve Set G', '10', '100', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('11', 'Sieve Set H', '10', '110', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('12', 'Sieve Set I', '10', '120', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('13', 'Sieve Set J', '10', '130', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('54', 'Sieve Set K (C4)', '10', '140', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('49', 'Fine Sample Sieve 1', '10', '150', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('50', 'Fine Sample Sieve 2', '10', '160', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('52', 'Fine Sample Sieve 3', '10', '170', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('53', 'Fine Sample Sieve 4', '10', '180', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('39', 'Fine Sample Sieve 5', '10', '190', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('40', 'Fine Sample Sieve 6', '10', '200', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('41', 'Fine Sample Sieve 7', '10', '210', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('30', 'Sieve Set R (40/70)', '10', '220', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('31', 'Sieve Set S (40/70)', '10', '230', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('32', 'Sieve Set T (40/70)', '10', '240', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('45', 'Sieve Set U (40/70)', '10', '250', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('48', 'Sieve Set Z (30/50)', '10', '260', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('3', 'Master Set (40/70)', '10', '270', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('21', 'Master Set (100)', '10', '280', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('43', 'Master (Fine)', '10', '290', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('42', 'Camsizer (Fine)', '10', '300', '1', '1');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('51', 'Camsizer (Extended)', '10', '310', '1', '1');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('44', 'Test 170', '10', '320', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('23', 'Sieve Set A', '30', '10', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('24', 'Sieve Set B', '30', '14', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('25', 'Sieve Set C', '30', '18', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('26', 'Sieve Set R', '30', '22', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('27', 'Sieve Set S', '30', '26', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('28', 'Sieve Set T', '30', '30', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('29', 'Sieve Set ASTM (20/40)', '30', '34', '1', '0');

INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2002', 'Canty', '20', '6', '0', '1');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2004', 'Sieve Set A', '20', '14', '0', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2033', 'Sieve Set K old v2', '20', '53', '0', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2014', 'Sieve Set K (40/70)', '20', '54', '0', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2015', 'Sieve Set L', '20', '58', '0', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2016', 'Sieve Set M', '20', '62', '0', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2017', 'Sieve Set N', '20', '66', '0', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2018', 'Sieve Set O', '20', '70', '0', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2019', 'Sieve Set P', '20', '74', '0', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2020', 'Sieve Set Q', '20', '78', '0', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2034', 'Sieve Set Z (30/50) old', '20', '95', '0', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2035', 'Fine Sample Sieve 1 old', '20', '102', '0', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2036', 'Fine Sample Sieve 2 old', '20', '106', '0', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2037', 'Fine Sample Sieve 3 old', '20', '110', '0', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2038', 'Fine Sample Sieve 4 old', '20', '114', '0', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2001', 'Camsizer (Wet Plant & 100)', '20', '10', '1', '1');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2022', 'Camsizer (Dry Plant 40/70)', '20', '20', '1', '1');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2047', 'Camsizer (Oversize)', '20', '30', '1', '1');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2046', 'Sieve Set A (C4)', '20', '40', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2005', 'Sieve Set B', '20', '50', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2006', 'Sieve Set C', '20', '60', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2007', 'Sieve Set D', '20', '70', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2008', 'Sieve Set E', '20', '80', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2009', 'Sieve Set F', '20', '90', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2010', 'Sieve Set G', '20', '100', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2011', 'Sieve Set H', '20', '110', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2012', 'Sieve Set I', '20', '120', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2013', 'Sieve Set J', '20', '130', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2054', 'Sieve Set K (C4)', '20', '140', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2049', 'Fine Sample Sieve 1', '20', '150', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2050', 'Fine Sample Sieve 2', '20', '160', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2052', 'Fine Sample Sieve 3', '20', '170', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2053', 'Fine Sample Sieve 4', '20', '180', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2039', 'Fine Sample Sieve 5', '20', '190', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2040', 'Fine Sample Sieve 6', '20', '200', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2041', 'Fine Sample Sieve 7', '20', '210', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2030', 'Sieve Set R (40/70)', '20', '220', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2031', 'Sieve Set S (40/70)', '20', '230', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2032', 'Sieve Set T (40/70)', '20', '240', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2045', 'Sieve Set U (40/70)', '20', '250', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2048', 'Sieve Set Z (30/50)', '20', '260', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2003', 'Master Set (40/70)', '20', '270', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2021', 'Master Set (100)', '20', '280', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2043', 'Master (Fine)', '20', '290', '1', '0');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2042', 'Camsizer (Fine)', '20', '300', '1', '1');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2051', 'Camsizer (Extended)', '20', '310', '1', '1');
INSERT INTO `gb_qc_sieve_stacks` (`id`, `description`, `main_site_id`, `sort_order`, `is_active`, `is_camsizer`) VALUES ('2044', 'Test 170', '20', '320', '1', '0');
