
/*******************************************************************************************************************************************
 * File Name: prod_sites.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/10/2017|whildebrandt|KACE:16787 - Initial creation
 *
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `prod_sites`;

CREATE TABLE `prod_sites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(50) NOT NULL,
  `type_code` varchar(1) DEFAULT NULL,
  `contains_employees` varchar(1) DEFAULT NULL,
  `sort_order` int(3) NOT NULL,
  `is_removed` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1000 DEFAULT CHARSET=latin1;



