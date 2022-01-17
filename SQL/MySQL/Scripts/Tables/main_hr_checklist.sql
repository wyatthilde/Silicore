/*******************************************************************************************************************************************
 * File Name: main_hr_checklist.sql
 * Project: silicore
 * Description: Creation script for table to be used in the HR Checklist.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 08/18/2017|ktaylor|KACE:16070 - Initial creation
 * 08/21/2017|kkuehn|KACE:16070 - Added drop clause
 ******************************************************************************************************************************************/
DROP TABLE IF EXISTS `main_hr_checklist`;


  CREATE TABLE `main_hr_checklist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `employee_id` varchar(45) NULL,
  `department_id` int(11) NOT NULL,
  `manager` varchar(45) NULL,
  `site_id` int(11) NOT NULL,
  `silicore_account_requested` tinyint(1) NULL,
  `silicore_account_model` varchar(45) NULL,
  `email_account_requested` tinyint(1) NULL,
  `cell_phone_requested` tinyint(1) NULL,
  `laptop_requested` tinyint(1) NULL,
  `desktop_requested` tinyint(1) NULL,
  `monitors_requested` varchar(45) NULL,
  `tablet_requested` tinyint(1) NULL,
  `two_way_radio_requested` tinyint(1) NULL,
  `special_software_requested` varchar(45) NULL,
  `comments` varchar(1024) NULL,
  `create_date` datetime NOT NULL,
  `create_user_id` int(11) NOT NULL,
  `edit_date` datetime NULL,
  `edit_user_id` int(11) NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;