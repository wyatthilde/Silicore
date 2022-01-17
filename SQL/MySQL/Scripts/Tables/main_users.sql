/*******************************************************************************************************************************************
 * File Name: main_users.sql
 * Project: Silicore
 * Description: This table will store all Silicore users.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 01/13/2017|kkuehn|KACE:10499 - Initial creation
 * 03/07/2017|mnutsch|KACE:16211 - modification
 * 06/13/2017|mnutsch|KACE:17366 - modification
 * 07/14/2017|mnutsch|KACE:17366 - added 'unknown' user
 * 08/11/2017|mnutsch|KACE:17916 - added additional users
 * 08/15/2017|mnutsch|KACE:17957 - updated users.
 * 
 ******************************************************************************************************************************************/

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
('kmiller','kmiller@vistasand.com','Kelton Miller','4','Kelton','Miller','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','1'),
('tlevasseur','tlevasseur@vistasand.com','Troy LeVasseur','4','Troy','LeVasseur','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','1'),
('jmoseley','jmoseley@vistasand.com','John Moseley','4','John','Moseley','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','1'),
('jfowler','jfowler@vistasand.com','Justin Fowler','4','Justin','Fowler','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','1'),
('wmercer','wmercer@vistasand.com','Wyatt Mercer','4','Wyatt','Mercer','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','1'),
('acortez','acortez@vistasand.com','Amos Cortez','4','Amos','Cortez','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','0'),
('bkeith','bkeith@maalt.com','Ben Keith','2','Ben','Keith','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','1'),
('bhousley','BHousley@vistasand.com','Bramwell Housley','4','Bramwell','Housley','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','0'),
('clockhart','clockhart@maalt.com','Carlyle Lockhart','1','Carlyle','Lockhart','Maalt','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','0'),
('chughes','chughes@vistasand.com','Christopher Hughes','4','Christopher','Hughes','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','0'),
('ddenicus','ddenicus@vistasand.com','Danny Denicus','4','Danny','Denicus','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','0'),
('hbromandi','hbromandi@vistasand.com','Hamed Bromandi','4','Hamed','Bromandi','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','0'),
('jprice','jprice@vistasand.com','Jacob Price','4','Jacob','Price','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','0'),
('jdrew','joe@vistasand.com','Joe Drew','4','Joe','Drew','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','0'),
('jlandes','jlandes@vistasand.com','John Landes','4','John','Landes','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','0'),
('kkuehn','kkuehn@vistasand.com','Karl Kuehn','2','Karl','Kuehn','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','1'),
('ktaylor','ktaylor@vistasand.com','Kenneth Taylor','2','Kenneth','Taylor','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','1'),
('mballesteros','mballesteros@vistasand.com','Mario Ballesteros','4','Mario','Ballesteros','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','0'),
('mnutsch','mnutsch@vistasand.com','Matt Nutsch','2','Matt','Nutsch','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','1'),
('rbanning','rbanning@vistasand.com','Ryan Banning','4','Ryan','Banning','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','0'),
('sheidari','Sheidari@vistasand.com','Saeid Heidari','4','Saeid','Heidari','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','0'),
('sbonfiglio','stephen@vistasand.com','Stephen Bonfiglio','1','Stephen','Bonfiglio','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','0'),
('tsherman','tsherman@vistasand.com','Terry Sherman','4','Terry','Sherman','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','0'),
('tsikes','travis@vistasand.com','Travis Sikes','4','Travis','Sikes','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','0'),
('cjohnson','chad@vistasand.com','Chad Johnson','7','Chad','Johnson','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','0'),
('mfleet','mfleet@vistasand.com','Michael Fleet','3','Michael','Fleet','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','0'),
('pilott','paul.ilott@ilottconsulting.com','Paul Ilott','3','Paul','Ilott','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','0'),
('wsingmaster','wsingmaster@vistasand.com','William Singmaster','3','William','Singmaster','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','0'),
('npeterson','NPeterson@vistasand.com','Nate Peterson','3','Nate','Peterson','Vista Sand','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','2013-03-13','0'),
('nolliff', 'Nikk', 'Olliff', 'Olliff', 'nolliff@vistasand.com', 'Vista Sand', '2', '$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S', '2017-07-21 13:32:20', '2013-03-13', NULL, '1'),
('unknown', 'unknown', 'unknown', 'unknown', 'unknown@vistasand.com', 'Vista Sand', '2', '$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S', '2017-07-21 13:32:20', '2013-03-13', NULL, '1');


