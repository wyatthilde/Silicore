/************************************************************************************************************************************
 * File Name: main_codes.sql
 * Project: Sandbox
 * Author: kkuehn
 * Date Created: Jan 13, 2017[5:31:49 PM]
 * Description: 
 * Notes: 
 /***********************************************************************************************************************************/

DROP TABLE IF EXISTS `sandbox`.`main_codes`;

CREATE TABLE `main_codes` (
  `id` int(11) NOT NULL DEFAULT '1',
  `type` varchar(32) DEFAULT NULL,
  `code` varchar(2) NOT NULL,
  `name` varchar(64) DEFAULT NULL,
  `description` varchar(256) DEFAULT NULL,
  `display_color` varchar(64) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# ADD CONSTRAINTS, FOREIGN KEYS, INDEXES, ETC.

