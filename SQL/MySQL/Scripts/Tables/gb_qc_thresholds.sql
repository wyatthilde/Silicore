/*******************************************************************************************************************************************
 * File Name: gb_qc_thresholds.sql
 * Project: smashbox
 * Description: This table stores the performance thresholds for Sieve sizes by Location.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 06/30/2017|mnutsch|KACE:17366 - Initial creation
 * 
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `gb_qc_thresholds`;

CREATE TABLE `gb_qc_thresholds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `screen` varchar(16) NOT NULL,
  `location_id` int(11) DEFAULT NULL,
  `low_threshold` double NOT NULL,
  `high_threshold` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

insert into gb_qc_thresholds (screen,location_id,low_threshold,high_threshold)
values
('30',54,0.1,1),
('PAN',54,1,1),
('-40+70',54,0,.96),
('30',14,0.1,1),
('PAN',14,1,1),
('-40+70',14,0,.96),
('30',16,0.1,1),
('PAN',16,1,1),
('-40+70',16,0,.96),
('30',101,0.1,1),
('PAN',101,1,1),
('-40+70',101,0,.96),
('+70',55,1,0),
('-140',55,0,.9),
('+70',13,0,0),
('-140',13,0,.9),
('+70',102,0,0),
('-140',102,0,.9),
('+70',103,0,0),
('-140',103,0,.9),
('+70',50,0,0),
('-140',50,0,.9),
('+70',3,0.8,1),
('+70',4,0.2,1),
('+70',20,0.8,1),
('+70',21,0.2,1)
;

# ADD CONSTRAINTS, FOREIGN KEYS, INDEXES, ETC.



