/*******************************************************************************************************************************************
 * File Name: gb_qc_composites.sql
 * Project: Silicore
 * Description: This table holds the select options for Composite.
 * Notes: 
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 06/15/2017|mnutsch|KACE:xxxxx - Initial creation.
 * 08/08/2017|mnutsch|KACE:17803 - I fixed a typo.
 * 
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `gb_qc_composites`;

CREATE TABLE `gb_qc_composites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `main_site_id` int(11) NOT NULL,
  `description` varchar(256) NOT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

# INSERT LEGACY BACKOFFICE DATA HERE
INSERT INTO gb_qc_composites(main_site_id,description,sort_order,is_active)
VALUES
(10,'Snapshot',0,1),
(10,'Weekly',10,1),
(10,'Monthly',20,1),
(10,'Quarterly',30,1),
(10,'Annual',40,1);

# ADD CONSTRAINTS, FOREIGN KEYS, INDEXES, ETC.

