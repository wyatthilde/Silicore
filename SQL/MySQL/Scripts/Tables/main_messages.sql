/*******************************************************************************************************************************************
 * File Name: main_messages_messages.sql
 * Project: Sandbox
 * Author: kkuehn
 * Date Created: Jan 16, 2017[2:31:43 PM]
 * Description: 
 * Notes: 
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `sandbox`.`main_messages`;

CREATE TABLE `sandbox`.`main_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `description` varchar(256) DEFAULT NULL,
  `main_messages_type_id` int(11) DEFAULT NULL,
  `main_messages_list_id_to` int(11) DEFAULT NULL,
  `main_messages_list_id_from` int(11) DEFAULT NULL,
  `subject` varchar(128) DEFAULT NULL,
  `body` varchar(2048) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# ADD DATA



# ADD CONSTRAINTS, FOREIGN KEYS, INDEXES, ETC.

