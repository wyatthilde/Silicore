/* * *****************************************************************************************************************************************
 * File Name: main_sites.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 01/13/2017|kkuehn|KACE:10499 - Initial creation 
 * 08/02/2017|mnutsch|KACE:17366 - Removed old database name and added a record.
 * 08/16/2017|kkuehn|KACE:10499 - Repurposed 'contains_employees' to 'is_vista_site'. Added 'is_qc_samples_site' for filtering. Added new
 *                                and/or missing sites.
 * 
 * **************************************************************************************************************************************** */


DROP TABLE IF EXISTS `main_sites`;

CREATE TABLE `main_sites` (
  `id` int(11) NOT NULL,
  `description` varchar(64) NOT NULL,
  `is_vista_site` tinyint(1) NOT NULL,
  `is_qc_samples_site` tinyint(1) NOT NULL,
  `local_network` varchar(15) DEFAULT NULL,
  `sort_order` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# INSERT LEGACY BACKOFFICE DATA HERE

INSERT INTO `main_sites` (`id`,`description`,`is_vista_site`,`is_qc_samples_site`,`sort_order`,`is_active`) VALUES ('10','Granbury',1,1,'0',1);
INSERT INTO `main_sites` (`id`,`description`,`is_vista_site`,`is_qc_samples_site`,`sort_order`,`is_active`) VALUES ('11','Fort Worth North',1,1,'100',1);
INSERT INTO `main_sites` (`id`,`description`,`is_vista_site`,`is_qc_samples_site`,`sort_order`,`is_active`) VALUES ('12','Fort Worth South',1,1,'200',1);
INSERT INTO `main_sites` (`id`,`description`,`is_vista_site`,`is_qc_samples_site`,`sort_order`,`is_active`) VALUES ('13','Cleburne',1,1,'300',1);
INSERT INTO `main_sites` (`id`,`description`,`is_vista_site`,`is_qc_samples_site`,`sort_order`,`is_active`) VALUES ('14','Gardendale',1,1,'310',1);
INSERT INTO `main_sites` (`id`,`description`,`is_vista_site`,`is_qc_samples_site`,`sort_order`,`is_active`) VALUES ('15','Big Spring',1,1,'320',1);
INSERT INTO `main_sites` (`id`,`description`,`is_vista_site`,`is_qc_samples_site`,`sort_order`,`is_active`) VALUES ('16','Enid',1,1,'330',1);
INSERT INTO `main_sites` (`id`,`description`,`is_vista_site`,`is_qc_samples_site`,`sort_order`,`is_active`) VALUES ('17','Sweetwater',1,1,'340',1);
INSERT INTO `main_sites` (`id`,`description`,`is_vista_site`,`is_qc_samples_site`,`sort_order`,`is_active`) VALUES ('18','Dilley',1,1,'350',1);
INSERT INTO `main_sites` (`id`,`description`,`is_vista_site`,`is_qc_samples_site`,`sort_order`,`is_active`) VALUES ('19','Pecos',1,1,'360',1);
INSERT INTO `main_sites` (`id`,`description`,`is_vista_site`,`is_qc_samples_site`,`sort_order`,`is_active`) VALUES ('20','Cresson',1,1,'400',1);
INSERT INTO `main_sites` (`id`,`description`,`is_vista_site`,`is_qc_samples_site`,`sort_order`,`is_active`) VALUES ('25','Big Lake',1,1,'450',1);
INSERT INTO `main_sites` (`id`,`description`,`is_vista_site`,`is_qc_samples_site`,`sort_order`,`is_active`) VALUES ('26','Barnhart',1,1,'460',1);
INSERT INTO `main_sites` (`id`,`description`,`is_vista_site`,`is_qc_samples_site`,`sort_order`,`is_active`) VALUES ('30','Fort Stockon',1,1,'500',1);
INSERT INTO `main_sites` (`id`,`description`,`is_vista_site`,`is_qc_samples_site`,`sort_order`,`is_active`) VALUES ('40','Corporate',1,1,'1000',1);
INSERT INTO `main_sites` (`id`,`description`,`is_vista_site`,`is_qc_samples_site`,`sort_order`,`is_active`) VALUES ('50','Tolar',1,1,'50',1);
INSERT INTO `main_sites` (`id`,`description`,`is_vista_site`,`is_qc_samples_site`,`sort_order`,`is_active`) VALUES ('60','Kermit',1,1,'60',1);
INSERT INTO `main_sites` (`id`,`description`,`is_vista_site`,`is_qc_samples_site`,`sort_order`,`is_active`) VALUES ('210','Momentive',0,1,'600',1);
INSERT INTO `main_sites` (`id`,`description`,`is_vista_site`,`is_qc_samples_site`,`sort_order`,`is_active`) VALUES ('700','Tidewater San Angelo',0,1,'700',1);
INSERT INTO `main_sites` (`id`,`description`,`is_vista_site`,`is_qc_samples_site`,`sort_order`,`is_active`) VALUES ('701','Pinnacle San Angelo',0,1,'701',1);
INSERT INTO `main_sites` (`id`,`description`,`is_vista_site`,`is_qc_samples_site`,`sort_order`,`is_active`) VALUES ('999','Unknown/Customer',0,1,'999',1);
INSERT INTO `main_sites` (`id`,`description`,`is_vista_site`,`is_qc_samples_site`,`sort_order`,`is_active`) VALUES ('998','Unknown Sample Site',0,1,'950',1);

# update main_sites set local_network = '192.168.3' where id = 30; # Fort Stockton
update main_sites set local_network = '192.168.97' where id = 10; # Granbury
update main_sites set local_network = '192.168.22' where id = 20; # Cresson
update main_sites set local_network = '10.221.14' where id = 30; # Fort Stockton
update main_sites set local_network = '192.168.88' where id = 40; # Corporate
update main_sites set local_network = '192.168.XXX' where id = 50; # Tolar (TBD)

# ADD CONSTRAINTS,FOREIGN KEYS,INDEXES,ETC.
