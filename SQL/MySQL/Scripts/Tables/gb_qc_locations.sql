/* * *****************************************************************************************************************************************
 * File Name: qc_locations.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 0?/0?/201?|kkuehn|KACE:10499 - Initial creation
 * 06/28/2017|mnutsch|KACE:xxxxx - Continued development
 * 08/04/2017|mnutsch|KACE:17803 - Reworked the sort order of existing records. Added new records.
 * 08/16/2017|kkuehn|KACE:10499 - Added 'Pit Sample' as a location for GB plant 'Unknown'. Moved 'Rail Car 40/70' and 'Rail Car 100' from 
 *                                GB carrier plant to Cresson Railyard plant.
 * 
 * **************************************************************************************************************************************** */

DROP TABLE IF EXISTS `gb_qc_locations`;

CREATE TABLE `gb_qc_locations` (
  `id` int(11) NOT NULL,
  `description` varchar(256) NOT NULL,
  `main_site_id` int(11) DEFAULT NULL,
  `main_plant_id` int(11) NOT NULL,
  `main_product_id` int(11) DEFAULT NULL,
  `type_code` varchar(2) DEFAULT NULL,
  `is_split_sample_only` tinyint(1) DEFAULT '0',
  `email_list_id` int(11) DEFAULT NULL,
  `is_send_email` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `plant_id` (`main_plant_id`),
  KEY `site_id` (`main_site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# INSERT LEGACY BACKOFFICE DATA HERE
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('0', 'NA', '0', '0', '0', 'S', '0', '0', '0', '0', '0');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('100', 'Inhibited Sample', '0', '0', '0', 'S', '0', '0', '0', '1000', '0');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('1', 'Feed Rows', '10', '0', '0', 'S', '0', '0', '0', '1', '0');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('2', 'Wet Plant Feed', '10', '3', '3', 'S', '0', '0', '0', '30', '0');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('30', 'Wet Plant Feed (Slurry)', '10', '3', '3', 'S', '0', '0', '0', '30', '0');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('68', 'UFR 200 Belt Composite', '10', '3', '0', 'S', '0', '0', '1', '345', '0');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('29', 'Old Wet Plant Cyclones', '10', '4', '0', 'S', '0', '0', '0', '0', '0');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('12', 'Rotary Feed', '10', '5', '9', 'S', '0', '0', '0', '64', '0');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('13', 'Rotary 100', '10', '5', '10', 'S', '1', '15', '1', '66', '0');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('57', 'Carrier Vehicle/Truck 100', '10', '6', '0', 'S', '0', '0', '0', '340', '0');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('48', 'Core Samples', '10', '0', '0', 'S', '0', '0', '0', '20', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('18', 'Pit', '10', '1', '0', 'S', '0', '0', '0', '10', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('127', 'Wet Plant Belt Feed', '10', '3', '3', 'S', '0', '0', '0', '31', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('31', 'Wet Plant Cyclones 1-2 Feed', '10', '3', '3', 'S', '0', '4', '1', '40', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('3', 'Wet Plant C4 (Coarse)', '10', '3', '4', 'S', '0', '3', '1', '50', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('4', 'Wet Plant C7 (Fine)', '10', '3', '5', 'S', '0', '0', '1', '60', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('5', 'Wet Plant Hydro 1 Over', '10', '3', '0', 'S', '0', '0', '0', '70', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('6', 'Wet Plant Hydro 2 Over', '10', '3', '0', 'S', '0', '0', '0', '80', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('63', 'Wet Plant Hydro 1 B Over', '10', '3', '0', 'S', '0', '0', '0', '85', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('65', 'Wet Plant Hydro 2 B Over', '10', '3', '0', 'S', '0', '0', '0', '86', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('7', 'Wet Plant Hydro 1 Under', '10', '3', '0', 'S', '0', '0', '0', '90', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('8', 'Wet Plant Hydro 2 Under', '10', '3', '0', 'S', '0', '0', '0', '91', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('64', 'Wet Plant Hydro 1 B Under', '10', '3', '0', 'S', '0', '0', '0', '92', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('66', 'Wet Plant Hydro 2 B Under', '10', '3', '0', 'S', '0', '0', '0', '93', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('69', 'UFR 200 (NWP)', '10', '3', '21', 'S', '0', '0', '1', '100', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('9', 'Wet Plant Moisture Rate', '10', '3', '0', 'M', '0', '0', '0', '105', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('33', 'Wet Plant Cyclone 1 Under', '10', '3', '0', 'S', '0', '0', '0', '110', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('34', 'Wet Plant Cyclone 2 Under', '10', '3', '0', 'S', '0', '0', '0', '120', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('35', 'Wet Plant Cyclone 1 B Under', '10', '3', '0', 'S', '0', '0', '0', '130', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('36', 'Wet Plant Cyclone 2 B Under', '10', '3', '0', 'S', '0', '0', '0', '140', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('45', 'Wet Plant Cyclone 5 Under', '10', '3', '0', 'S', '0', '0', '0', '150', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('46', 'Wet Plant Cyclone 6 Under', '10', '3', '0', 'S', '0', '0', '0', '160', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('47', 'Wet Plant Cyclone 7 Under', '10', '3', '0', 'S', '0', '0', '0', '170', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('60', 'Wet Plant Cyclone 8 Under', '10', '3', '0', 'S', '0', '0', '0', '173', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('62', 'Wet Plant Cyclone 9 Under', '10', '3', '0', 'S', '0', '0', '0', '176', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('58', 'Wet Plant Cyclones 8-9 Feed', '10', '3', '0', 'S', '0', '0', '0', '179', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('27', 'Wet Plant Cyclones 1-2 Over', '10', '3', '15', 'S', '0', '0', '0', '190', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('28', 'Wet Plant Cyclones 3-6 Over', '10', '3', '15', 'S', '0', '0', '0', '200', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('59', 'Wet Plant Cyclone 8 Over', '10', '3', '0', 'S', '0', '0', '0', '211', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('61', 'Wet Plant Cyclone 9 Over', '10', '3', '0', 'S', '0', '0', '0', '213', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('32', 'Wet Plant Cyclones 3-4 Feed', '10', '3', '0', 'S', '0', '0', '0', '220', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('128', 'Old Wet Plant Belt Feed', '10', '4', '6', 'S', '0', '0', '0', '225', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('19', 'Old Wet Plant Feed A', '10', '4', '6', 'S', '0', '4', '1', '230', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('131', 'Old Wet Plant Feed B', '10', '4', '6', 'S', '0', '4', '1', '231', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('20', 'Old Wet Plant Coarse Side A', '10', '4', '7', 'S', '0', '0', '1', '232', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('22', 'Old Wet Plant Coarse Side B', '10', '4', '7', 'S', '0', '0', '1', '240', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('21', 'Old Wet Plant Fine Side A', '10', '4', '8', 'S', '0', '0', '1', '250', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('23', 'Old Wet Plant Fine Side B', '10', '4', '8', 'S', '0', '0', '1', '260', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('132', 'Pump 6', '10', '4', '0', 'S', '0', '0', '0', '265', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('70', 'UFR 200 (OWP)', '10', '4', '0', 'S', '0', '0', '1', '270', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('25', 'Old Wet Plant Hydro Side A Over', '10', '4', '0', 'S', '0', '0', '0', '275', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('26', 'Old Wet Plant Hydro Side B Over', '10', '4', '0', 'S', '0', '0', '0', '280', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('38', 'Old Wet Plant Cyclone 1 Tails Side A', '10', '4', '0', 'S', '0', '0', '0', '290', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('39', 'Old Wet Plant Cyclone 2 Tails Side A', '10', '4', '0', 'S', '0', '0', '0', '300', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('40', 'Old Wet Plant Cyclone 3 Tails Side A', '10', '4', '0', 'S', '0', '0', '0', '310', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('41', 'Old Wet Plant Cyclones 1-2 Tails Side B', '10', '4', '0', 'S', '0', '0', '0', '315', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('42', 'Old Wet Plant Cyclones 4-5 Over Side B', '10', '4', '0', 'S', '0', '0', '0', '320', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('37', 'Old Wet Plant Cyclone 1 Feed Side B', '10', '4', '6', 'S', '0', '0', '0', '330', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('11', 'Carrier Feed 40/70', '10', '6', '11', 'S', '1', '0', '1', '10', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('14', 'Carrier 140 40/70', '10', '6', '0', 'S', '1', '0', '0', '20', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('104', 'Carrier 140 40/70 (L)', '10', '6', '0', 'S', '1', '0', '0', '30', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('105', 'Carrier 140 40/70 (R)', '10', '6', '0', 'S', '1', '0', '0', '40', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('16', 'Carrier 145 40/70', '10', '6', '0', 'S', '1', '0', '0', '50', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('112', 'Carrier 145 40/70 (L)', '10', '6', '0', 'S', '1', '0', '0', '60', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('113', 'Carrier 145 40/70 (R)', '10', '6', '0', 'S', '1', '0', '0', '70', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('101', 'Carrier 40/70 Lab Composite', '10', '6', '13', 'S', '1', '15', '1', '80', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('54', 'Carrier 40/70 Silo', '10', '6', '13', 'S', '0', '40', '1', '90', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('108', 'Carrier 140 Fine', '10', '6', '0', 'S', '1', '0', '0', '100', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('106', 'Carrier 140 Fine (L)', '10', '6', '0', 'S', '1', '0', '0', '110', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('107', 'Carrier 140 Fine (R)', '10', '6', '0', 'S', '1', '0', '0', '120', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('116', 'Carrier 145 Fine', '10', '6', '0', 'S', '1', '0', '0', '130', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('114', 'Carrier 145 Fine (L)', '10', '6', '0', 'S', '1', '0', '0', '140', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('115', 'Carrier 145 Fine (R)', '10', '6', '0', 'S', '1', '0', '0', '150', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('111', 'Carrier 140 OS', '10', '6', '0', 'S', '1', '0', '0', '160', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('109', 'Carrier 140 OS (L)', '10', '6', '0', 'S', '1', '0', '0', '170', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('110', 'Carrier 140 OS (R)', '10', '6', '0', 'S', '1', '0', '0', '180', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('119', 'Carrier 145 OS', '10', '6', '0', 'S', '1', '0', '0', '190', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('117', 'Carrier 145 OS (L)', '10', '6', '0', 'S', '1', '0', '0', '200', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('118', 'Carrier 145 OS (R)', '10', '6', '0', 'S', '1', '0', '0', '210', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('133', 'Carrier Trash Belt', '10', '6', '0', 'S', '1', '0', '0', '220', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('24', 'Carrier Feed 100', '10', '6', '12', 'S', '1', '0', '0', '230', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('55', 'Carrier 100', '10', '6', '14', 'S', '0', '15', '1', '240', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('15', 'Carrier 140 100', '10', '6', '0', 'S', '1', '0', '0', '250', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('17', 'Carrier 145 100', '10', '6', '0', 'S', '1', '0', '0', '260', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('56', 'Generic Sample', '10', '6', '0', 'S', '0', '0', '1', '270', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('67', 'Hardie Moisture Sample', '10', '6', '0', 'M', '0', '43', '1', '280', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('53', 'Carrier Baghouse', '10', '6', '0', 'S', '0', '0', '1', '290', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('120', 'Rail Car 40/70', '20', '10', '0', 'S', '1', '0', '0', '300', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('121', 'Rail Car 100', '20', '10', '0', 'S', '1', '0', '0', '310', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('122', 'Truck 40/70', '10', '6', '0', 'S', '1', '0', '0', '320', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('123', 'Truck 100', '10', '6', '0', 'S', '1', '0', '0', '330', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('49', 'Rotary Feed', '10', '7', '16', 'S', '0', '0', '1', '440', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('50', 'Rotary 100', '10', '7', '17', 'S', '1', '37', '1', '450', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('51', 'Rotary Discharge', '10', '7', '0', 'S', '1', '0', '1', '460', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('52', 'Rotary Baghouse', '10', '7', '0', 'S', '0', '0', '1', '470', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('103', 'Carrier 2 Feed', '10', '8', '22', 'S', '1', '15', '1', '10', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('102', 'Carrier 2 100 Silo', '10', '8', '22', 'S', '1', '15', '1', '20', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('124', 'Carrier 2 40/70', '10', '8', '0', 'S', '1', '15', '1', '30', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('125', 'Carrier 2 OS', '10', '8', '0', 'S', '1', '15', '1', '40', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('126', 'Carrier 2 Baghouse', '10', '8', '0', 'S', '1', '15', '1', '50', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('130', 'Core Sample', '10', '9', '6', 'S', '0', '0', '0', '900', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('129', 'Unknown', '10', '9', '6', 'S', '0', '0', '0', '1000', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('43', 'Track 1', '30', '0', '0', 'S', '1', '0', '0', '300', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('44', 'Track 2', '30', '0', '0', 'S', '1', '0', '0', '305', '1');
INSERT INTO `gb_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('134', 'Pit Sample', '10', '9', '0', 'S', '0', '0', '0', '910', '1');

# ADD AUTO_INCREMENT to id column, then set auto_increment to start at 129 (128 is last ID in legacy data) on the table
set session sql_mode='NO_AUTO_VALUE_ON_ZERO';
ALTER TABLE `gb_qc_locations` CHANGE COLUMN `id` `id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `gb_qc_locations` AUTO_INCREMENT = 131;
set session sql_mode='';

# Test insert to check the auto-increment
/*
INSERT INTO `gb_qc_locations` 
(`description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) 
VALUES ('NA', NULL, '0', NULL, 'S', '0', NULL, '0', '0', '0');
*/

# ADD CONSTRAINTS, FOREIGN KEYS, INDEXES, ETC.

select * from gb_qc_locations;


