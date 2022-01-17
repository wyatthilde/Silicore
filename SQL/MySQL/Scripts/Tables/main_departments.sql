/* * *****************************************************************************************************************************************
 * File Name: main_departments.sql
 * Project: Silicore
 * Description: This table lists the departments of the company.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 01/13/2017|kkuehn|KACE:10499 - Initial creation.
 * 05/30/2017|mnutsch|KACE:(move tables/files from gbdevserver2 to smashbox) - Initial creation based on previous files.
 * 07/28/2017|mnutsch|KACE:17366 - Added IT department.
 * 
 * **************************************************************************************************************************************** */

DROP TABLE IF EXISTS `main_departments`;

CREATE TABLE `main_departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `name_code` varchar(2) NOT NULL,
  `description` varchar(256) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

# INSERT DATA

insert into main_departments (name,name_code,description)
values
('General','GN','General (ALL) department'),
('Development','DV','Design/Programming department'),
('Production','PR','Plant production department'),
('QC','QC','Quality Control/Lab department'),
('Loadout','OP','Loadout department'),
('Logistics','LG','Logistics department'),
('Accounting','AC','Accounting department'),
('Safety','SF','Safety management department'),
('HR','HR','Human Resources department'),
('IT','IT','Information Technology department');

# ADD CONSTRAINTS, FOREIGN KEYS, INDEXES, ETC.

