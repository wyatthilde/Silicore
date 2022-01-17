 /*******************************************************************************************************************************************
 * File Name: tl_qc_locations.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 09/05/2017|mnutsch|KACE:17959 - Initial creation
 * 
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `tl_qc_locations`;

CREATE TABLE `tl_qc_locations` (
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
INSERT INTO `tl_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('0', 'NA', '50', '0', '0', 'S', '0', '0', '0', '0', '1');
INSERT INTO `tl_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('1', 'Inhibited Sample', '50', '0', '0', 'S', '0', '0', '0', '1000', '1');
INSERT INTO `tl_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('2', 'Belt Feed', '50', '11', '0', 'S', '0', '0', '0', '50', '1');
INSERT INTO `tl_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('3', 'Primary Cyclone Feed', '50', '12', '0', 'S', '0', '0', '0', '100', '1');
INSERT INTO `tl_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('4', 'Primary Cyclone Unders', '50', '12', '0', 'S', '0', '0', '0', '150', '1');
INSERT INTO `tl_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('5', 'Primary Cyclone Overs', '50', '12', '0', 'S', '0', '0', '0', '200', '1');
INSERT INTO `tl_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('6', 'Attrition Cell Discharge', '50', '12', '0', 'S', '0', '0', '0', '250', '1');
INSERT INTO `tl_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('7', 'Secondary Cyclone Overs', '50', '12', '0', 'S', '0', '0', '0', '300', '1');
INSERT INTO `tl_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('8', 'Wet Plant Product', '50', '12', '0', 'S', '0', '0', '0', '350', '1');
INSERT INTO `tl_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('9', 'UFR Feed', '50', '13', '0', 'S', '0', '0', '0', '400', '1');
INSERT INTO `tl_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('10', 'UFR Product', '50', '13', '0', 'S', '0', '0', '0', '450', '1');
INSERT INTO `tl_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('12', 'Press Cake Moisture', '50', '13', '0', 'S', '0', '0', '0', '500', '1');
INSERT INTO `tl_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('13', 'Rotary Feed', '50', '14', '0', 'S', '0', '0', '0', '550', '1');
INSERT INTO `tl_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('14', 'Rotary 2 Feed', '50', '14', '0', 'S', '0', '0', '0', '600', '1');
INSERT INTO `tl_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('15', 'Baghouse Fines', '50', '14', '0', 'S', '0', '0', '0', '650', '1');
INSERT INTO `tl_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('16', 'Dry Mill Trash', '50', '14', '0', 'S', '0', '0', '0', '700', '1');
INSERT INTO `tl_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('17', '100 Mesh Product', '50', '14', '0', 'S', '0', '0', '0', '750', '1');
INSERT INTO `tl_qc_locations` (`id`, `description`, `main_site_id`, `main_plant_id`, `main_product_id`, `type_code`, `is_split_sample_only`, `email_list_id`, `is_send_email`, `sort_order`, `is_active`) VALUES ('18', 'Rail Car 100 Mesh', '50', '15', '0', 'S', '0', '0', '0', '800', '1');


