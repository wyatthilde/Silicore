
/*******************************************************************************************************************************************
 * File Name: prod_plant_production.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 10/30/2017|whildebrandt|KACE:16787 - Added table to silicore site for website functionality
 *
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `prod_plant_production`;

CREATE TABLE `prod_plant_production` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `plant_id` int(3) NOT NULL,
  `shift_date` date NOT NULL,
  `shift` varchar(5) NOT NULL,
  `product_id` int(3) NOT NULL,
  `tons` int(5) NOT NULL,
  `duration` decimal(5,2) NOT NULL DEFAULT '12.00',
  `uptime` decimal(5,2) DEFAULT NULL,
  `uptime_percent` decimal(5,4) DEFAULT NULL,
  `downtime_minutes` int(5) NOT NULL DEFAULT '0.00',
  `downtime` decimal(5,2) DEFAULT NULL,
  `downtime_percent` decimal(5,4) DEFAULT NULL,
  `downtime_reason` varchar(255) DEFAULT NULL,
  `idletime_minutes` int(5) NOT NULL DEFAULT '0.00',
  `idletime` decimal(5,2) NOT NULL DEFAULT '0.00',
  `idletime_percent` decimal(5,4) NOT NULL DEFAULT '0',
  `create_dt` datetime DEFAULT NULL,
  `edit_dt` datetime DEFAULT NULL,
  `user_id` bigint(20) NOT NULL,
  `is_removed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `date` (`shift_date`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22349 DEFAULT CHARSET=latin1;