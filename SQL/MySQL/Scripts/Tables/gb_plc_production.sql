
/*******************************************************************************************************************************************
 * File Name: gb_plc_production.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/15/2017|whildebrandt|KACE:19563 - created table gb_plc_production for new plc tables
 * 11/29/2017|whildebrandt|KACE:19563 - added xfer_id to production table
 ******************************************************************************************************************************************/
DROP TABLE IF EXISTS `gb_plc_production`;
CREATE TABLE `gb_plc_production` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `shift_id` bigint(20) DEFAULT NULL,
  `tons` int(5) DEFAULT NULL,
  `tag_id` bigint(20) NOT NULL,
  `tag` varchar(32) DEFAULT NULL,
  `product_id` int(3) DEFAULT NULL,
  `product` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_index` (`shift_id`,`tons`,`tag_id`,`tag`,`product_id`,`product`),
  `Xfer_id` bigint(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;