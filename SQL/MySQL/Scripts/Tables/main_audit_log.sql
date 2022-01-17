/************************************************************************************************************************************
 * File Name: main_audit_log.sql
 * Project: Sandbox
 * Author: kkuehn
 * Date Created: Jan 13, 2017[5:27:47 PM]
 * Description: 
 * Notes: 
 /***********************************************************************************************************************************/

DROP TABLE IF EXISTS `main_audit_log`;

CREATE TABLE `main_audit_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` datetime NOT NULL,
  `data_source` varchar(64) NOT NULL,
  `user_id` int(11) NOT NULL,
  `data_string` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# ADD CONSTRAINTS, FOREIGN KEYS, INDEXES, ETC.



