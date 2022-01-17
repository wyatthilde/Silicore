
/*******************************************************************************************************************************************
 * File Name: prod_products_final.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/09/2017|whildebrandt|KACE:16787 - Created table prod_products_final
 *
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `prod_products_final`;

CREATE TABLE `prod_products_final` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cyma_product_id` varchar(30) NOT NULL,
  `cyma_product_line_id` int(11) DEFAULT NULL,
  `transcore_product_no` varchar(30) NOT NULL,
  `description` varchar(50) NOT NULL,
  `type_code` varchar(1) NOT NULL DEFAULT 'A',
  `cyma_account` varchar(32) DEFAULT NULL,
  `stcc` bigint(20) DEFAULT NULL,
  `stcc_description` varchar(50) DEFAULT NULL,
  `units` varchar(16) DEFAULT 'tons',
  `color_code_hex` varchar(6) DEFAULT NULL,
  `sort_order` int(3) NOT NULL,
  `is_removed` tinyint(1) NOT NULL,
  `cyma_create_date` date DEFAULT NULL,
  `cyma_edit_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cyma_product_id` (`cyma_product_id`),
  UNIQUE KEY `transcore_product_no` (`transcore_product_no`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=latin1;



