/*******************************************************************************************************************************************
 * File Name: prod_auto_plant_runtime.sql
 * Project: Silicore
 * Description: 
 * Notes: 
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 06/28/2017|kkuehn|KACE:17349 - Initial creation
 * 
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `prod_auto_plant_runtime`;

CREATE TABLE `prod_auto_plant_runtime` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `shift_id` bigint(20) DEFAULT NULL,
  `duration_minutes` int(5) DEFAULT NULL,
  `duration` decimal(5,2) DEFAULT NULL,
  `device` varchar(64) DEFAULT NULL,
  `tag_id` bigint(20) DEFAULT NULL,
  `tag` varchar(32) DEFAULT NULL,
  `create_dt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `date` (`duration_minutes`)
) ENGINE=InnoDB AUTO_INCREMENT=75601011 DEFAULT CHARSET=latin1;



