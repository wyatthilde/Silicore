
/*******************************************************************************************************************************************
 * File Name: prod_products.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 10/24/2017|whildebrandt|KACE:16787 - Initial creation
 *
 ******************************************************************************************************************************************/
DROP TABLE IF EXISTS `prod_products`;

CREATE TABLE `prod_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plant_id` int(3) NOT NULL,
  `tag_id` bigint(20) DEFAULT NULL,
  `tag` varchar(32) DEFAULT NULL,
  `product_final_id` bigint(20) DEFAULT NULL,
  `description` varchar(128) NOT NULL,
  `classification` varchar(32) DEFAULT NULL,
  `is_target` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int(3) NOT NULL,
  `is_removed` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tag` (`tag`),
  KEY `plant_id` (`plant_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;



