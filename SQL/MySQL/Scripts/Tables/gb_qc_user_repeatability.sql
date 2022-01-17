/*******************************************************************************************************************************************
 * File Name: gb_qc_user_repeatability.sql
 * Project: Sandbox
 * Author: mnutsch
 * Date Created: 6-26-2017
 * Description: 
 * Notes: 
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `gb_qc_user_repeatability`;

CREATE TABLE `gb_qc_user_repeatability` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `repeatability_counter` int(11) NOT NULL DEFAULT '100',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

