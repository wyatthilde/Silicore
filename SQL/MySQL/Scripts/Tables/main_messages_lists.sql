/*******************************************************************************************************************************************
 * File Name: main_messages_lists.sql
 * Project: Sandbox
 * Author: kkuehn
 * Date Created: Jan 16, 2017[2:30:34 PM]
 * Description: 
 * Notes: main_code_id will hold the code id that determines if the email_string is a sender or recipient. 
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `sandbox`.`main_messages_lists`;

CREATE TABLE `main_messages_lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `main_code_id` INT(11), 
  `name` varchar(32) NOT NULL,
  `description` varchar(256),
  `email_string` varchar(512) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

insert into main_messages_lists (name,email_string)
values
('Development Karl','kkuehn@vistasand.com'),
('Test Karl','kkuehn@vistasand.com'),
('Development Ken','ktaylor@vistasand.com');

# ADD CONSTRAINTS, FOREIGN KEYS, INDEXES, ETC.



