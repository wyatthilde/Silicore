
/*******************************************************************************************************************************************
 * File Name: prod_dispatch_loads.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/10/2017|whildebrandt|KACE:16787 - Initial creation
 *
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `prod_dispatch_loads`;

CREATE TABLE `prod_dispatch_loads` (
  `id` int(11) NOT NULL,
  `load_no` varchar(20) NOT NULL,
  `description` varchar(50) DEFAULT NULL,
  `po_id` bigint(20) DEFAULT NULL,
  `po_no` varchar(20) DEFAULT NULL,
  `po_modifier` varchar(6) DEFAULT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `customer` varchar(50) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `material_no` varchar(20) DEFAULT NULL,
  `customer_product_id` bigint(20) DEFAULT NULL,
  `pounds` decimal(8,1) DEFAULT NULL,
  `tons` decimal(5,2) DEFAULT NULL,
  `site_id` int(11) DEFAULT NULL,
  `destination_id` bigint(20) DEFAULT NULL,
  `destination` varchar(50) DEFAULT NULL,
  `estimated_arrival_date` date DEFAULT NULL,
  `estimated_arrival_dt` datetime DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `delivery_dt` datetime DEFAULT NULL,
  `delivery_dt_original` datetime DEFAULT NULL,
  `delivery_dt_utc` datetime DEFAULT NULL,
  `expected_start_dt_utc` datetime DEFAULT NULL,
  `expected_end_dt_utc` datetime DEFAULT NULL,
  `priority` tinyint(2) NOT NULL DEFAULT '10',
  `is_roll_forward` varchar(1) NOT NULL DEFAULT 'N',
  `roll_forward_end_date` date DEFAULT NULL,
  `roll_forward_end_date_utc` date DEFAULT NULL,
  `carrier_id` bigint(20) DEFAULT NULL,
  `carrier` varchar(64) DEFAULT NULL,
  `vehicle_no` int(11) DEFAULT NULL,
  `driver_id` bigint(20) DEFAULT NULL,
  `driver_user_id` bigint(20) DEFAULT NULL,
  `ticket_ok_status_code` varchar(1) DEFAULT NULL,
  `tax_code_id` varchar(15) NOT NULL DEFAULT 'EXEMPT',
  `freight_fob` varchar(1) NOT NULL DEFAULT 'P',
  `edit_status_code` varchar(1) NOT NULL DEFAULT 'N',
  `sent_dt` datetime DEFAULT NULL,
  `create_dt` datetime NOT NULL,
  `create_user_id` bigint(20) DEFAULT NULL,
  `edit_dt` datetime DEFAULT NULL,
  `edit_user_id` bigint(20) DEFAULT NULL,
  `manual_edit_dt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `material_no` (`material_no`),
  KEY `customer_id` (`customer_id`),
  KEY `delivery_date` (`delivery_date`),
  KEY `driver_id` (`driver_id`),
  KEY `carrier_id` (`carrier_id`),
  KEY `edit_status_code` (`edit_status_code`),
  KEY `po_id` (`po_id`),
  KEY `ticket_ok_status_code` (`ticket_ok_status_code`),
  KEY `product_id` (`product_id`),
  KEY `vehicle_no` (`vehicle_no`),
  KEY `site_id` (`site_id`),
  KEY `driver_user_id` (`driver_user_id`),
  KEY `destination_id` (`destination_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


