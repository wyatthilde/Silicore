/*******************************************************************************************************************************************
 * File Name: prod_auto_plant_production.sql
 * Project: Silicore
 * Description: 
 * Notes: 
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 06/28/2017|kkuehn|KACE:17349 - Initial creation
 * 
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `prod_auto_plant_production`;

CREATE TABLE `prod_auto_plant_production` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `shift_id` bigint(20) DEFAULT NULL,
  `tons` int(5) DEFAULT NULL,
  `tag_id` bigint(20) NOT NULL,
  `tag` varchar(32) DEFAULT NULL,
  `product_id` int(3) DEFAULT NULL,
  `product` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_index` (`shift_id`,`tons`,`tag_id`,`tag`,`product_id`,`product`)
) ENGINE=InnoDB AUTO_INCREMENT=111559 DEFAULT CHARSET=latin1;



