/************************************************************************************************************************************
 * File Name: main_shifts.sql
 * Project: Sandbox
 * Author: kkuehn
 * Date Created: Jan 13, 2017[6:18:05 PM]
 * Description: 
 * Notes: 
 /***********************************************************************************************************************************/

DROP TABLE IF EXISTS `sandbox`.`main_shifts`;

CREATE TABLE `main_shifts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `name_sequential` varchar(16) DEFAULT NULL,
  `description` varchar(256) DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `duration_hours` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# INSERT DATA


# ADD CONSTRAINTS, FOREIGN KEYS, INDEXES, ETC.

