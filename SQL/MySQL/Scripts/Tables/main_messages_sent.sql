/*******************************************************************************************************************************************
 * File Name: main_messages_sent.sql
 * Project: Sandbox
 * Author: kkuehn
 * Date Created: Jan 16, 2017[2:31:16 PM]
 * Description: 
 * Notes: 
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `sandbox`.`main_messages_sent`;

CREATE TABLE `sandbox`.`main_messages_sent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sent_timestamp` datetime NOT NULL,
  `main_message_id` int(11) DEFAULT NULL,
  `custom_sender` varchar(128) DEFAULT NULL,
  `custom_recipients` varchar(512) DEFAULT NULL,
  `custom_subject` varchar(128) DEFAULT NULL,
  `custom_body_content` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# ADD CONSTRAINTS, FOREIGN KEYS, INDEXES, ETC.