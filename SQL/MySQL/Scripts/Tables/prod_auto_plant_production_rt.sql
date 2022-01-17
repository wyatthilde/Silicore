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

DROP TABLE IF EXISTS `prod_auto_plant_production_rt`;

CREATE TABLE `prod_auto_plant_production_rt` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `plant_id` int(3) DEFAULT NULL,
  `product_id` int(3) DEFAULT NULL,
  `tag_id` bigint(20) DEFAULT NULL,
  `tag` varchar(32) DEFAULT NULL,
  `dt` datetime DEFAULT NULL,
  `tons_running_total` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `tag` (`tag`),
  KEY `dt` (`dt`)
) ENGINE=InnoDB AUTO_INCREMENT=1336188 DEFAULT CHARSET=latin1;



