
/*******************************************************************************************************************************************
 * File Name: prod_rail_car_releases.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/10/2017|whildebrandt|KACE:16787 - Initial creation
 *
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `prod_rail_car_releases`;

CREATE TABLE `prod_rail_car_releases` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `release_no` bigint(20) DEFAULT NULL,
  `release_no_instance` int(2) NOT NULL DEFAULT '1',
  `date` date DEFAULT NULL,
  `po_id` bigint(20) DEFAULT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `car_count` int(11) DEFAULT NULL,
  `net_pounds` int(11) DEFAULT NULL,
  `net_tons` decimal(10,2) DEFAULT NULL,
  `spot_request` varchar(255) DEFAULT NULL,
  `path` varchar(50) DEFAULT NULL,
  `void_status_code` varchar(1) NOT NULL DEFAULT 'A',
  `create_dt` datetime DEFAULT NULL,
  `create_user_id` bigint(20) DEFAULT NULL,
  `edit_dt` datetime DEFAULT NULL,
  `edit_user_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `release_no_idx` (`release_no`),
  KEY `po_id_idx` (`po_id`),
  KEY `customer_id_idx` (`customer_id`),
  KEY `product_id_idx` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3371 DEFAULT CHARSET=latin1;



