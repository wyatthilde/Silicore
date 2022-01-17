
/*******************************************************************************************************************************************
 * File Name: prod_customers.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/09/2017|whildebrandt|KACE:16787 - Created table prod_customers
 *
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `prod_customers`;

CREATE TABLE `prod_customers` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `description` varchar(30) NOT NULL,
  `billing_name` varchar(30) NOT NULL,
  `address_line1` varchar(30) DEFAULT NULL,
  `address_line2` varchar(30) DEFAULT NULL,
  `city` varchar(25) DEFAULT NULL,
  `state` varchar(25) DEFAULT NULL,
  `zip` varchar(15) DEFAULT NULL,
  `company_phone` varchar(25) DEFAULT NULL,
  `company_fax` varchar(25) DEFAULT NULL,
  `contact_name` varchar(20) DEFAULT NULL,
  `contact_phone` varchar(25) DEFAULT NULL,
  `cyma_custid` varchar(15) NOT NULL,
  `cyma_typeid` varchar(6) DEFAULT 'SAND',
  `cyma_locationid` varchar(25) DEFAULT NULL,
  `cyma_terms_code` varchar(6) DEFAULT NULL,
  `cyma_account` varchar(24) DEFAULT NULL,
  `cyma_ar_account` varchar(24) DEFAULT '1030000',
  `cyma_sales_account` varchar(24) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `create_dt` datetime DEFAULT NULL,
  `create_user_id` bigint(20) DEFAULT NULL,
  `edit_dt` datetime DEFAULT NULL,
  `edit_user_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `description` (`description`),
  UNIQUE KEY `cyma_custid` (`cyma_custid`)
) ENGINE=InnoDB AUTO_INCREMENT=11904 DEFAULT CHARSET=latin1;


