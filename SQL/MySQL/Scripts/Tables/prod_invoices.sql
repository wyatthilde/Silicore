
/*******************************************************************************************************************************************
 * File Name: prod_invoices.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/10/2017|whildebrandt|KACE:16787 - Initial creation
 *
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `prod_invoices`;

CREATE TABLE `prod_invoices` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `invoice_no` varchar(20) DEFAULT NULL,
  `invoice_no_instance` int(2) NOT NULL DEFAULT '1',
  `type_code` varchar(45) NOT NULL DEFAULT 'D',
  `status` varchar(1) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `po_id` bigint(20) DEFAULT NULL,
  `po_billing_instance` int(11) DEFAULT NULL,
  `qty` decimal(10,2) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `price_unit` varchar(5) NOT NULL DEFAULT 'ton',
  `amount` decimal(10,2) DEFAULT NULL,
  `invoice_path` varchar(50) DEFAULT NULL,
  `void_status_code` varchar(1) NOT NULL DEFAULT 'A',
  `constraint_override_dt` datetime DEFAULT NULL,
  `constraint_override_user_id` bigint(20) DEFAULT NULL,
  `create_dt` datetime DEFAULT NULL,
  `create_user_id` bigint(20) DEFAULT NULL,
  `edit_dt` datetime DEFAULT NULL,
  `edit_user_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `date` (`date`),
  KEY `ticket_nos` (`amount`),
  KEY `invoice_no` (`invoice_no`),
  KEY `po_id` (`po_id`),
  KEY `void_status_code` (`void_status_code`)
) ENGINE=InnoDB AUTO_INCREMENT=12549 DEFAULT CHARSET=latin1;

