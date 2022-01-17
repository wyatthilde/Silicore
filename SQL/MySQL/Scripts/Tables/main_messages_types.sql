/*******************************************************************************************************************************************
 * File Name: main_messages_types.sql
 * Project: Sandbox
 * Author: kkuehn
 * Date Created: Jan 16, 2017[2:28:15 PM]
 * Description: 
 * Notes: 
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `sandbox`.`main_messages_types`;

CREATE TABLE `sandbox`.`main_messages_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` varchar(256) DEFAULT NULL,
  `priority` int(11) NOT NULL DEFAULT '4',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

insert into main_messages_types (name,description,priority)
values
('status','standard status notifications from batch scripts or explicit UI interaction',3),
('alert','standard alert targeted at a specific recipient group',2),
('critical','critical level alert targeted at multiple groups with high importance',1),
('news','random messages aimed at team building, light info or marketing',4);

# ADD CONSTRAINTS, FOREIGN KEYS, INDEXES, ETC.


