
/*******************************************************************************************************************************************
 * File Name: prod_purchase_orders.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/10/2017|whildebrandt|KACE:16787 - Initial creation
 *
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `prod_purchase_orders`;

CREATE TABLE `prod_purchase_orders` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `po_no` varchar(20) NOT NULL,
  `site_id` int(11) NOT NULL DEFAULT '10',
  `second_site_id` int(11) DEFAULT NULL,
  `destination_id` bigint(20) DEFAULT NULL,
  `transfer_site_id` int(11) DEFAULT NULL,
  `rail_carrier_id` bigint(20) DEFAULT NULL,
  `expected_ship_date` date DEFAULT NULL,
  `driver_pay_shift_rate` decimal(10,2) DEFAULT NULL,
  `driver_pay_load_rate` decimal(10,2) DEFAULT NULL,
  `rail_car_release_email_list_id` bigint(20) DEFAULT NULL,
  `customer_id` bigint(20) NOT NULL,
  `customer` varchar(64) NOT NULL,
  `date_issued` date NOT NULL,
  `date_closed` date DEFAULT NULL,
  `status_code` varchar(1) DEFAULT NULL,
  `allow_before_issued` varchar(1) NOT NULL DEFAULT 'N',
  `allow_after_closed` varchar(1) NOT NULL DEFAULT 'N',
  `product_id` int(11) NOT NULL,
  `product` varchar(32) NOT NULL,
  `customer_product_id` bigint(20) DEFAULT NULL,
  `pounds_ordered` int(11) NOT NULL,
  `tons_ordered` decimal(8,2) NOT NULL,
  `pounds_limit` int(11) NOT NULL,
  `enforce_pounds_limit_code` varchar(1) NOT NULL DEFAULT 'N',
  `tons_limit` decimal(8,2) NOT NULL,
  `allow_overload` varchar(1) NOT NULL DEFAULT 'Y',
  `freight_fob` varchar(1) NOT NULL DEFAULT 'P',
  `price` decimal(10,2) NOT NULL,
  `price_unit` varchar(5) DEFAULT NULL,
  `comments` text,
  `trucking_per_load_cost` decimal(10,2) DEFAULT NULL,
  `transload_per_ton_cost` decimal(10,2) DEFAULT NULL,
  `rail_freight_per_car_cost` decimal(10,2) DEFAULT NULL,
  `rail_car_per_car_cost` decimal(10,2) DEFAULT NULL,
  `create_dt` datetime DEFAULT NULL,
  `create_user_id` bigint(20) DEFAULT NULL,
  `edit_dt` datetime DEFAULT NULL,
  `edit_user_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `po_no` (`po_no`),
  KEY `customer_id` (`customer_id`),
  KEY `product_id` (`product_id`),
  KEY `customer_product_id` (`customer_product_id`),
  KEY `site_id` (`site_id`),
  KEY `transfer_site_id` (`transfer_site_id`),
  KEY `status_code` (`status_code`),
  KEY `rail_car_release_email_list_id` (`rail_car_release_email_list_id`),
  CONSTRAINT `prod_purchase_orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `prod_customers` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `prod_purchase_orders_ibfk_2` FOREIGN KEY (`customer_product_id`) REFERENCES `prod_products_customers` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `prod_purchase_orders_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `prod_products_final` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `prod_purchase_orders_ibfk_4` FOREIGN KEY (`rail_car_release_email_list_id`) REFERENCES `prod_email_lists` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12250 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;



