
/*******************************************************************************************************************************************
 * File Name: prod_products_customers.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/09/2017|whildebrandt|KACE:16787 - Created prod_products_customers
 *
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `prod_products_customers`;

CREATE TABLE `prod_products_customers` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(20) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_no` varchar(20) NOT NULL,
  `description` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customer_id` (`customer_id`,`product_no`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=397 DEFAULT CHARSET=latin1;

