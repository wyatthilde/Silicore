/*******************************************************************************************************************************************
 * File Name: newSQLTemplate.sql
 * Project: Silicore
 * Description: This table stores a list of Plants used by the application.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * ?/?/?|kkuehn|KACE:xxxxx - Initial creation
 * 6/28/2017|mnutsch|KACE:xxxxx - Removed references to an old database name.
 * 7/13/2017|mnutsch|KACE:17366 - Corrected a typo in a column name.
 * 08/16/2017|kkuehn|KACE:10499 - Added 'Railyard' as a Cresson plant
 * 
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `main_plants`;

CREATE TABLE `main_plants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `main_site_id` int(11) NULL,
  `name` varchar(64) DEFAULT NULL,
  `name_short` varchar(16) DEFAULT NULL,
  `description` varchar(256) DEFAULT NULL,
  `sort_order` int(11) NULL,
  `tceq_max_tpy` int(11) DEFAULT NULL,
  `tceq_max_tph` int(11) DEFAULT NULL,
  `tceq_max_upy` int(11) DEFAULT NULL,
  `tceq_moisture_rate` decimal(5,2) NOT NULL DEFAULT '0.00',
  `tceq_description` varchar(256) DEFAULT NULL,
  `tceq_notes` varchar(512) DEFAULT NULL,
  `tceq_sort_order` int(11) NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# INSERT LEGACY BACKOFFICE DATA HERE
INSERT INTO `main_plants` (`id`, `main_site_id`, `name`, `name_short`, `description`, `sort_order`, `tceq_max_tpy`, `tceq_max_tph`, `tceq_max_upy`, `tceq_moisture_rate`, `tceq_description`, `tceq_notes`, `tceq_sort_order`, `is_active`) VALUES ('1', '10', 'Pit', 'Pit', 'Pit', '0', NULL, NULL, NULL, '0.05', NULL, '', '0', '0');
INSERT INTO `main_plants` (`id`, `main_site_id`, `name`, `name_short`, `description`, `sort_order`, `tceq_max_tpy`, `tceq_max_tph`, `tceq_max_upy`, `tceq_moisture_rate`, `tceq_description`, `tceq_notes`, `tceq_sort_order`, `is_active`) VALUES ('3', '10', 'Wet Plant 2', 'Wet Plant 2', 'Wet Plant 2', '6', '2500000', '350', '7000', '0.07', 'Wet Plant #2 (New)', '', '6', '1');
INSERT INTO `main_plants` (`id`, `main_site_id`, `name`, `name_short`, `description`, `sort_order`, `tceq_max_tpy`, `tceq_max_tph`, `tceq_max_upy`, `tceq_moisture_rate`, `tceq_description`, `tceq_notes`, `tceq_sort_order`, `is_active`) VALUES ('4', '10', 'Wet Plant 1', 'Wet Plant 1', 'Wet Plant 1', '2', '2500000', '350', '7000', '0.05', 'Wet Plant #1 (Old)', '', '2', '1');
INSERT INTO `main_plants` (`id`, `main_site_id`, `name`, `name_short`, `description`, `sort_order`, `tceq_max_tpy`, `tceq_max_tph`, `tceq_max_upy`, `tceq_moisture_rate`, `tceq_description`, `tceq_notes`, `tceq_sort_order`, `is_active`) VALUES ('5', '10', 'Dry Plant (Rotary)', 'Old Rotary', 'Dry Plant (Rotary)', '100', '1400000', '200', '7000', '0.05', 'Drying Plant #3 (Rotary)[Removed]', '', '100', '0');
INSERT INTO `main_plants` (`id`, `main_site_id`, `name`, `name_short`, `description`, `sort_order`, `tceq_max_tpy`, `tceq_max_tph`, `tceq_max_upy`, `tceq_moisture_rate`, `tceq_description`, `tceq_notes`, `tceq_sort_order`, `is_active`) VALUES ('6', '10', 'Carrier 1', 'Carrier 1', 'Carrier 1', '10', '750000', '110', '7000', '0.05', 'Drying Plant #1 (Carrier #1)', '', '10', '1');
INSERT INTO `main_plants` (`id`, `main_site_id`, `name`, `name_short`, `description`, `sort_order`, `tceq_max_tpy`, `tceq_max_tph`, `tceq_max_upy`, `tceq_moisture_rate`, `tceq_description`, `tceq_notes`, `tceq_sort_order`, `is_active`) VALUES ('7', '10', 'Rotary 1', 'Rotary 1', 'Rotary 1', '16', '1500000', '300', '5000', '0.05', 'Drying Plant #3 (Rotary)', '', '16', '1');
INSERT INTO `main_plants` (`id`, `main_site_id`, `name`, `name_short`, `description`, `sort_order`, `tceq_max_tpy`, `tceq_max_tph`, `tceq_max_upy`, `tceq_moisture_rate`, `tceq_description`, `tceq_notes`, `tceq_sort_order`, `is_active`) VALUES ('8', '10', 'Carrier 2', 'Carrier 2', 'Carrier 2', '12', '750000', '110', '7000', '0.05', 'Drying Plant #4 (Carrier #2)', '', '12', '1');
INSERT INTO `main_plants` (`id`, `main_site_id`, `name`, `name_short`, `description`, `sort_order`, `tceq_max_tpy`, `tceq_max_tph`, `tceq_max_upy`, `tceq_moisture_rate`, `tceq_description`, `tceq_notes`, `tceq_sort_order`, `is_active`) VALUES ('9', '10', 'Unknown', 'Unknown', 'Unknown', '100', '750000', '110', '7000', '0.05', 'Unknown', '', '100', '1');
INSERT INTO `main_plants` (`id`, `main_site_id`, `name`, `name_short`, `description`, `sort_order`, `tceq_max_tpy`, `tceq_max_tph`, `tceq_max_upy`, `tceq_moisture_rate`, `tceq_description`, `tceq_notes`, `tceq_sort_order`, `is_active`) VALUES ('10', '20', 'Railyard', 'Railyard', 'Cresson Railyard', '200', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, '1');


# ADD CONSTRAINTS, FOREIGN KEYS, INDEXES, ETC.

select * from main_plants;

