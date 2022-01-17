/************************************************************************************************************************************
 * File Name: silicore_site_schema.sql
 * Project: Silicore
 * Author: kkuehn
 * Date Created: Jun 14, 2017[7:04:49 PM]
 * Description: Main silicore_site DB schema construction script. This file should be maintained and updated throughout the life of 
 *              the Silicore application. All element creation scripts should be prefaced with their associated drop commands.
 * Notes: The format of this script should organize all area/department specific elements together within their appropriate sections.
 *        of the script. The sections should be organized as follows:
 *        1) Create all tables
 *        2) Create all constraints, keys and triggers
 *        3) Create all Stored Procedures (sprocs)
 *      
 *        All stored procedures should have associated stand-alone testing scripts for testing execution using any variations of 
 *        parameters that can be sent to the procedures. These testing scripts will  be run from either the command line or from 
 *        a GUI tool like MySQL Workbench, and will be able to be run to verify successful completion of the scripts with expected 
 *        results. The sproc testing process will be completely separate from, and not dependent on, running the front-end of the 
 *        application.
 ************************************************************************************************************************************/

/*============================================================================================================ BEGIN TABLE CREATION */
/*------------------------------------------------------------------------------------------------------------ Begin 'main_' Tables */

DROP TABLE IF EXISTS `main_users`;

CREATE TABLE `main_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `first_name` varchar(32) NOT NULL,
  `last_name` varchar(32) NOT NULL,
  `display_name` varchar(64) DEFAULT NULL,
  `email` varchar(128) NOT NULL,
  `company` varchar(32) NOT NULL DEFAULT 'Vista Sand',
  `main_department_id` int(11) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `last_logged` datetime DEFAULT NULL,
  `start_date` date NOT NULL,
  `separation_date` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `require_password_reset` tinyint(1) NOT NULL DEFAULT '0',
  `password_reset_token` varchar(64) NULL,
  `password_token_expiration` DATETIME NULL,
  `qc_labtech` tinyint(1) NOT NULL DEFAULT '1',
  `qc_sampler` tinyint(1) NOT NULL DEFAULT '1',
  `qc_operator` tinyint(1) NOT NULL DEFAULT '1',
  `user_type_id` int(11),
  `manager_id` int(11),
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

insert into `main_users` (username,email,display_name,main_department_id,first_name,last_name,company,password,start_date,is_active)
values
('acortez','acortez@vistasand.com','Amos Cortez','4','Amos','Cortez','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','0'),
('bkeith','bkeith@maalt.com','Ben Keith','2','Ben','Keith','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','1'),
('bhousley','BHousley@vistasand.com','Bramwell Housley','4','Bramwell','Housley','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','0'),
('clockhart','clockhart@maalt.com','Carlyle Lockhart','1','Carlyle','Lockhart','Maalt','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','0'),
('chughes','chughes@vistasand.com','Christopher Hughes','4','Christopher','Hughes','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','0'),
('ddenicus','ddenicus@vistasand.com','Danny Denicus','4','Danny','Denicus','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','0'),
('hbromandi','hamedbromandi32@gmail.com','Hamed Bromandi','4','Hamed','Bromandi','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','0'),
('jprice','jprice@vistasand.com','Jacob Price','4','Jacob','Price','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','0'),
('jdrew','joe@vistasand.com','Joe Drew','4','Joe','Drew','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','0'),
('jlandes','jlandes@vistasand.com','John Landes','4','John','Landes','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','0'),
('kkuehn','kkuehn@vistasand.com','Karl Kuehn','2','Karl','Kuehn','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','1'),
('ktaylor','ktaylor@vistasand.com','Kenneth Taylor','2','Kenneth','Taylor','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','1'),
('mballesteros','mballesteros@vistasand.com','Mario Ballesteros','4','Mario','Ballesteros','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','0'),
('mnutsch','mnutsch@vistasand.com','Matt Nutsch','2','Matt','Nutsch','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','1'),
('rbanning','ryan@vistasand.com','Ryan Banning','4','Ryan','Banning','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','0'),
('sheidari','saeed_645@yahoo.com','Saeid Heidari','4','Saeid','Heidari','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','0'),
('sbonfiglio','stephen@vistasand.com','Stephen Bonfiglio','1','Stephen','Bonfiglio','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','0'),
('tsherman','tsherman@vistasand.com','Terry Sherman','4','Terry','Sherman','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','0'),
('tsikes','travis@vistasand.com','Travis Sikes','4','Travis','Sikes','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','0'),
('cjohnson','chad@vistasand.com','Chad Johnson','7','Chad','Johnson','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','0'),
('mfleet','mfleet@vistasand.com','Michael Fleet','3','Michael','Fleet','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','0'),
('pilott','paul.ilott@ilottconsulting.com','Paul Ilott','3','Paul','Ilott','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','0'),
('wsingmaster','wsingmaster@vistasand.com','William Singmaster','3','William','Singmaster','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','0'),
('npeterson','NPeterson@vistasand.com','Nate Peterson','3','Nate','Peterson','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','0');

DROP TABLE IF EXISTS `main_user_types`;

CREATE TABLE `main_user_types` (
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

DROP TABLE IF EXISTS `main_user_permissions`;

CREATE TABLE `main_user_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `permission` varchar(32) NOT NULL,
  `permission_level` int(11) NOT NULL,
  `site` varchar(32) NOT NULL,
  `created_datetime` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified_datetime` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `created_by` varchar(32) NULL,
  `modified_by` varchar(32) NULL,
  `company` varchar(32) NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_permission_site_UNIQUE` (`user_id`, `permission`, `site`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

insert into `main_user_permissions` (user_id, permission, permission_level, site, created_by, company)
values
('14','qc','40','granbury','mnutsch', 'vista'),
('14','accounting','40','granbury','mnutsch', 'vista'),
('14','production','40','granbury','mnutsch', 'vista'),
('14','operations','40','granbury','mnutsch', 'vista'),
('14','logistics','40','granbury','mnutsch', 'vista'),
('14','safety','40','granbury','mnutsch', 'vista'),
('14','development','40','granbury','mnutsch', 'vista'),
('14','hr','40','granbury','mnutsch', 'vista'),
('14','loadout','40','granbury','mnutsch', 'vista'),
('14','general','40','granbury','mnutsch', 'vista'),
('11','qc','40','granbury','mnutsch', 'vista'),
('11','accounting','40','granbury','mnutsch', 'vista'),
('11','production','40','granbury','mnutsch', 'vista'),
('11','operations','40','granbury','mnutsch', 'vista'),
('11','logistics','40','granbury','mnutsch', 'vista'),
('11','safety','40','granbury','mnutsch', 'vista'),
('11','development','40','granbury','mnutsch', 'vista'),
('11','hr','40','granbury','mnutsch', 'vista'),
('11','general','40','granbury','mnutsch', 'vista'),
('11','loadout','40','granbury','mnutsch', 'vista'),
('12','qc','40','granbury','mnutsch', 'vista'),
('12','accounting','40','granbury','mnutsch', 'vista'),
('12','production','40','granbury','mnutsch', 'vista'),
('12','operations','40','granbury','mnutsch', 'vista'),
('12','logistics','40','granbury','mnutsch', 'vista'),
('12','safety','40','granbury','mnutsch', 'vista'),
('12','development','40','granbury','mnutsch', 'vista'),
('12','hr','40','granbury','mnutsch', 'vista'),
('12','general','40','granbury','mnutsch', 'vista'),
('12','loadout','40','granbury','mnutsch', 'vista'),
('2','qc','40','granbury','mnutsch', 'vista'),
('2','accounting','40','granbury','mnutsch', 'vista'),
('2','production','40','granbury','mnutsch', 'vista'),
('2','operations','40','granbury','mnutsch', 'vista'),
('2','logistics','40','granbury','mnutsch', 'vista'),
('2','safety','40','granbury','mnutsch', 'vista'),
('2','development','40','granbury','mnutsch', 'vista'),
('2','hr','40','granbury','mnutsch', 'vista'),
('2','general','40','granbury','mnutsch', 'vista'),
('2','loadout','40','granbury','mnutsch', 'vista');

DROP TABLE IF EXISTS `main_sites`;

CREATE TABLE `main_sites` (
  `id` int(11) NOT NULL,
  `description` varchar(64) NOT NULL,
  `type_code` varchar(2) DEFAULT NULL,
  `contains_employees` varchar(1) DEFAULT NULL,
  `local_network` varchar(15) DEFAULT NULL,
  `sort_order` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# INSERT LEGACY BACKOFFICE DATA HERE

INSERT INTO `main_sites` (`id`, `description`, `type_code`, `contains_employees`, `sort_order`, `is_active`) VALUES ('10', 'Granbury', 'C', 'Y', '0', '1');
INSERT INTO `main_sites` (`id`, `description`, `type_code`, `contains_employees`, `sort_order`, `is_active`) VALUES ('11', 'Maalt North', 'C', 'N', '100', '1');
INSERT INTO `main_sites` (`id`, `description`, `type_code`, `contains_employees`, `sort_order`, `is_active`) VALUES ('12', 'Maalt South', 'C', 'N', '200', '1');
INSERT INTO `main_sites` (`id`, `description`, `type_code`, `contains_employees`, `sort_order`, `is_active`) VALUES ('13', 'Maalt Cleburne', 'C', 'N', '300', '1');
INSERT INTO `main_sites` (`id`, `description`, `type_code`, `contains_employees`, `sort_order`, `is_active`) VALUES ('14', 'Maalt Gardendale', 'C', 'N', '310', '1');
INSERT INTO `main_sites` (`id`, `description`, `type_code`, `contains_employees`, `sort_order`, `is_active`) VALUES ('15', 'Maalt Big Spring', 'C', 'N', '320', '1');
INSERT INTO `main_sites` (`id`, `description`, `type_code`, `contains_employees`, `sort_order`, `is_active`) VALUES ('16', 'Maalt Enid', 'C', 'N', '330', '1');
INSERT INTO `main_sites` (`id`, `description`, `type_code`, `contains_employees`, `sort_order`, `is_active`) VALUES ('17', 'Maalt Sweetwater', 'C', 'N', '340', '1');
INSERT INTO `main_sites` (`id`, `description`, `type_code`, `contains_employees`, `sort_order`, `is_active`) VALUES ('18', 'Maalt Dilley', 'C', 'N', '350', '1');
INSERT INTO `main_sites` (`id`, `description`, `type_code`, `contains_employees`, `sort_order`, `is_active`) VALUES ('19', 'Maalt Pecos', 'C', 'Y', '360', '1');
INSERT INTO `main_sites` (`id`, `description`, `type_code`, `contains_employees`, `sort_order`, `is_active`) VALUES ('20', 'Cresson', 'S', 'Y', '400', '1');
INSERT INTO `main_sites` (`id`, `description`, `type_code`, `contains_employees`, `sort_order`, `is_active`) VALUES ('25', 'Maalt Big Lake', 'C', 'N', '450', '1');
INSERT INTO `main_sites` (`id`, `description`, `type_code`, `contains_employees`, `sort_order`, `is_active`) VALUES ('30', 'Fort Stockon', 'C', 'Y', '500', '1');
INSERT INTO `main_sites` (`id`, `description`, `type_code`, `contains_employees`, `sort_order`, `is_active`) VALUES ('40', 'Maalt Corporate', 'O', 'Y', '1000', '1');
INSERT INTO `main_sites` (`id`, `description`, `type_code`, `contains_employees`, `sort_order`, `is_active`) VALUES ('50', 'Tolar', 'C', 'Y', '50', '1');
INSERT INTO `main_sites` (`id`, `description`, `type_code`, `contains_employees`, `sort_order`, `is_active`) VALUES ('210', 'Momentive', 'C', 'N', '600', '1');
INSERT INTO `main_sites` (`id`, `description`, `type_code`, `contains_employees`, `sort_order`, `is_active`) VALUES ('700', 'Tidewater San Angelo', 'C', 'N', '700', '1');
INSERT INTO `main_sites` (`id`, `description`, `type_code`, `contains_employees`, `sort_order`, `is_active`) VALUES ('701', 'Pinnacle San Angelo', 'C', 'N', '701', '1');
INSERT INTO `main_sites` (`id`, `description`, `type_code`, `contains_employees`, `sort_order`, `is_active`) VALUES ('999', 'Unknown/Customer', 'C', 'N', '999', '1');

# update main_sites set local_network = '192.168.3' where id = 30; # Fort Stockton
update main_sites set local_network = '192.168.97' where id = 10; # Granbury
update main_sites set local_network = '192.168.22' where id = 20; # Cresson
update main_sites set local_network = '10.221.14' where id = 30; # Fort Stockton
update main_sites set local_network = '192.168.88' where id = 40; # Maalt Corporate
update main_sites set local_network = '192.168.XXX' where id = 50; # Tolar (TBD)

DROP TABLE IF EXISTS `main_shifts`;

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

DROP TABLE IF EXISTS `main_plants`;

CREATE TABLE `main_plants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `main_site_id` int(11) NULL,
  `name` varchar(64) DEFAULT NULL,
  `name_short` varchar(16) DEFAULT NULL,
  `description` varchar(256) DEFAULT NULL,
  `sort_order` int(11) NULL,
  `tceq_max_tpy` int(11) DEFAULT NULL,
  `tceq_max_tph` int(11) DEFAULT NULL,
  `tceq_max_upy` int(11) DEFAULT NULL,
  `tceq_moisture_rate` decimal(5,2) NOT NULL DEFAULT '0.00',
  `tecq_description` varchar(256) DEFAULT NULL,
  `tceq_notes` varchar(512) DEFAULT NULL,
  `tceq_sort_order` int(11) NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# INSERT LEGACY BACKOFFICE DATA HERE
INSERT INTO `main_plants` (`id`, `main_site_id`, `name`, `name_short`, `description`, `sort_order`, `tceq_max_tpy`, `tceq_max_tph`, `tceq_max_upy`, `tceq_moisture_rate`, `tecq_description`, `tceq_notes`, `tceq_sort_order`, `is_active`) VALUES ('1', '10', 'Pit', 'Pit', 'Pit', '0', NULL, NULL, NULL, '0.05', NULL, '', '0', '0');
INSERT INTO `main_plants` (`id`, `main_site_id`, `name`, `name_short`, `description`, `sort_order`, `tceq_max_tpy`, `tceq_max_tph`, `tceq_max_upy`, `tceq_moisture_rate`, `tecq_description`, `tceq_notes`, `tceq_sort_order`, `is_active`) VALUES ('3', '10', 'Wet Plant 2', 'Wet Plant 2', 'Wet Plant 2', '6', '2500000', '350', '7000', '0.07', 'Wet Plant #2 (New)', '', '6', '1');
INSERT INTO `main_plants` (`id`, `main_site_id`, `name`, `name_short`, `description`, `sort_order`, `tceq_max_tpy`, `tceq_max_tph`, `tceq_max_upy`, `tceq_moisture_rate`, `tecq_description`, `tceq_notes`, `tceq_sort_order`, `is_active`) VALUES ('4', '10', 'Wet Plant 1', 'Wet Plant 1', 'Wet Plant 1', '2', '2500000', '350', '7000', '0.05', 'Wet Plant #1 (Old)', '', '2', '1');
INSERT INTO `main_plants` (`id`, `main_site_id`, `name`, `name_short`, `description`, `sort_order`, `tceq_max_tpy`, `tceq_max_tph`, `tceq_max_upy`, `tceq_moisture_rate`, `tecq_description`, `tceq_notes`, `tceq_sort_order`, `is_active`) VALUES ('5', '10', 'Dry Plant (Rotary)', 'Old Rotary', 'Dry Plant (Rotary)', '100', '1400000', '200', '7000', '0.05', 'Drying Plant #3 (Rotary)[Removed]', '', '100', '0');
INSERT INTO `main_plants` (`id`, `main_site_id`, `name`, `name_short`, `description`, `sort_order`, `tceq_max_tpy`, `tceq_max_tph`, `tceq_max_upy`, `tceq_moisture_rate`, `tecq_description`, `tceq_notes`, `tceq_sort_order`, `is_active`) VALUES ('6', '10', 'Carrier 1', 'Carrier 1', 'Carrier 1', '10', '750000', '110', '7000', '0.05', 'Drying Plant #1 (Carrier #1)', '', '10', '1');
INSERT INTO `main_plants` (`id`, `main_site_id`, `name`, `name_short`, `description`, `sort_order`, `tceq_max_tpy`, `tceq_max_tph`, `tceq_max_upy`, `tceq_moisture_rate`, `tecq_description`, `tceq_notes`, `tceq_sort_order`, `is_active`) VALUES ('7', '10', 'Rotary 1', 'Rotary 1', 'Rotary 1', '16', '1500000', '300', '5000', '0.05', 'Drying Plant #3 (Rotary)', '', '16', '1');
INSERT INTO `main_plants` (`id`, `main_site_id`, `name`, `name_short`, `description`, `sort_order`, `tceq_max_tpy`, `tceq_max_tph`, `tceq_max_upy`, `tceq_moisture_rate`, `tecq_description`, `tceq_notes`, `tceq_sort_order`, `is_active`) VALUES ('8', '10', 'Carrier 2', 'Carrier 2', 'Carrier 2', '12', '750000', '110', '7000', '0.05', 'Drying Plant #4 (Carrier #2)', '', '12', '1');



DROP TABLE IF EXISTS `main_page_help`;

CREATE TABLE `main_page_help` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(64) NOT NULL,
  `department` varchar(64) NOT NULL,
  `text` varchar(1024) DEFAULT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

insert into `main_page_help` (page, department, text)
values
('main.php','General','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
('profile.php','General','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
('main.php','QC','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
('main.php','Production','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
('main.php','Loadout','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
('main.php','Logistics','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
('main.php','Safety','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
('main.php','Accounting','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
('main.php','HR','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
('main.php','Development','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
('hrchecklist.php','HR','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
('quicklinks.php','General','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
('updatepagehelp.php','Development','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
('analyticsdashboard.php','Development','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');



/*-------------------------------------------------------------------------------------------------------------- End 'main_' Tables */

/*-------------------------------------------------------------------------------------------------------------- Begin 'ui_' Tables */



/*---------------------------------------------------------------------------------------------------------------- End 'ui_' Tables */

/*------------------------------------------------------------------------------------------------------ Begin Site-Specific Tables */
/*-------------------------------------------------------------------------------------------------------------- Begin 'gb_' Tables */



/*---------------------------------------------------------------------------------------------------------------- End 'gb_' Tables */
/*-------------------------------------------------------------------------------------------------------------- Begin 'tl_' Tables */



/*---------------------------------------------------------------------------------------------------------------- End 'tl_' Tables */
/*-------------------------------------------------------------------------------------------------------------- Begin 'wt_' Tables */



/*---------------------------------------------------------------------------------------------------------------- End 'wt_' Tables */
/*-------------------------------------------------------------------------------------------------------- End Site-Specific Tables */
/*============================================================================================================== END TABLE CREATION */

/*======================================================================================================= BEGIN CONSTRAINT CREATION */
/*-------------------------------------------------------------------------------------------------------------- Begin Foreign Keys */



/*---------------------------------------------------------------------------------------------------------------- End Foreign Keys */
/*========================================================================================================= END CONSTRAINT CREATION */

/*========================================================================================================== BEGIN TRIGGER CREATION */



/*============================================================================================================ END TRIGGER CREATION */

/*================================================================================================= BEGIN STORED PROCEDURE CREATION */



/*=================================================================================================== END STORED PROCEDURE CREATION */