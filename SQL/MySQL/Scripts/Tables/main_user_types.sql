/*******************************************************************************************************************************************
 * File Name: main_user_types.sql
 * Project: Sandbox
 * Author: kkuehn
 * Date Created: Jan 17, 2017[5:12:11 PM]
 * Description: 
 * Notes: This table will denote the various levels of user types: admin, owner, manager, developer, standard, etc. Will allow us to maintain
 * area/level access based on user login composites.
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `sandbox`.`main_user_types`;

CREATE TABLE `sandbox`.`main_user_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `description` varchar(256) DEFAULT NULL,
  `value` int(11) NOT NULL DEFAULT '100',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# Insert data


insert into main_user_types (name,description,value)
values
('Standard','Regular employees',100),
('Shift Lead','Shift-level managers',200),
('Manager','Department-level managers',300),
('Director','Multi-department managers',400),
('Administrator','Global site administrators (full rights)',500);

# ADD CONSTRAINTS, FOREIGN KEYS, INDEXES, ETC.
