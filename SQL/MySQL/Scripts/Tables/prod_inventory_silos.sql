
/*******************************************************************************************************************************************
 * File Name: prod_inventory_silos.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/10/2017|whildebrandt|KACE:16787 - Initial creation
 *
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `prod_inventory_silos`;

CREATE TABLE `prod_inventory_silos` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `dt` datetime NOT NULL,
  `dt_short` bigint(11) DEFAULT NULL,
  `site_id` int(11) DEFAULT '10',
  `silo_id` int(11) DEFAULT NULL,
  `customer_id` bigint(20) NOT NULL DEFAULT '38',
  `product_id` int(11) DEFAULT NULL,
  `volume` decimal(5,4) DEFAULT NULL,
  `feet_remaining` decimal(5,2) DEFAULT NULL,
  `tons` decimal(8,2) DEFAULT NULL,
  `loads` decimal(5,1) DEFAULT NULL,
  `is_hour_first_reading` tinyint(1) DEFAULT '0',
  `manual_edit_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_index` (`dt`,`site_id`,`silo_id`),
  KEY `is_hour_first_reading` (`is_hour_first_reading`),
  KEY `edit_dt` (`manual_edit_date`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1902981 DEFAULT CHARSET=latin1;

