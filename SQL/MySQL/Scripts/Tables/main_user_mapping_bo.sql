/*******************************************************************************************************************************************
 * File Name: main_user_mapping_bo.sql
 * Project: Silicore
 * Description: This table contains mapping of user ID's between the Silicore and Back Office computer systems.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 07/24/2017|mnutsch|KACE:17366 - Initial creation
 * 
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `main_user_mapping_bo`;

CREATE TABLE `main_user_mapping_bo` 
(
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `silicore_user_id` int(11) NOT NULL,
  `back_office_user_id` int(11) NOT NULL,  
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`silicore_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

insert into `main_user_mapping_bo` (silicore_user_id, back_office_user_id)
values
(1, 689),
(2, 452),
(3, 748),
(4, 555),
(5, 589),
(7, 425),
(8, 321),
(11, 603),
(12, 538),
(13, 752),
(14, 742),
(15, 25),
(16, 388),
(17, 745),
(18, 28),
(20, 118),
(21, 361),
(22, 600),
(23, 654),
(24, 261), 
(25, 762);
