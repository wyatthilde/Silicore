/*******************************************************************************************************************************************
 * File Name: main_locations.sql
 * Project: Sandbox
 * Author: kkuehn
 * Date Created: Jan 17, 2017[2:32:02 PM]
 * Description: 
 * Notes: This table will contain the various locations within sites, i.e., Cresson has the truck office, the 6-pack, the main office, 
 *        loadout and the e-house.
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `sandbox`.`main_locations`;

CREATE TABLE `sandbox`.`main_locations` (
  `id` varchar(16) NOT NULL,
  `main_site_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `description` varchar(256) DEFAULT NULL,
  `local_network` varchar(15) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# INSERT DATA

insert into main_locations (id,main_site_id,name,description,local_network)
values
('10-000',10,'Granbury Office','Granbury Offices at primary mine site','192.168.97'),
('10-200',10,'Granbury Dry Plant','Main dry plant in Granbury','192.168.30'),
('10-100',10,'Granbury QC Lab','Main QC lab near the dry plant in Granbury','192.168.97'),
('20-000',20,'Cresson Foo','Cresson Loadout','192.168.22'),
('30-000',30,'Fort Stockton Foo','Fort Stockton Foo Place','10.221.14'),
('40-000',40,'Maalt Corporate','Maalt offices at Carey Street in FW','192.168.88');

# ADD CONSTRAINTS, FOREIGN KEYS, INDEXES, ETC.

