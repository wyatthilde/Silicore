
/*******************************************************************************************************************************************
 * File Name: prod_carriers.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/09/2017|whildebrandt|KACE:16787- Created table prod_carriers
 *
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `prod_carriers`;

CREATE TABLE `prod_carriers` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `description` varchar(50) NOT NULL,
  `billing_name` varchar(50) NOT NULL,
  `address_line1` varchar(50) DEFAULT NULL,
  `address_line2` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(25) DEFAULT NULL,
  `zip` varchar(15) DEFAULT NULL,
  `company_phone` varchar(25) DEFAULT NULL,
  `company_fax` varchar(25) DEFAULT NULL,
  `contact_name` varchar(50) DEFAULT NULL,
  `contact_phone` varchar(25) DEFAULT NULL,
  `create_dt` datetime DEFAULT NULL,
  `create_user_id` bigint(20) DEFAULT NULL,
  `edit_dt` datetime DEFAULT NULL,
  `edit_user_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `description_UNIQUE` (`description`)
) ENGINE=InnoDB AUTO_INCREMENT=19138 DEFAULT CHARSET=latin1;


