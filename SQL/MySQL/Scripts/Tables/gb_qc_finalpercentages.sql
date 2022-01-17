/* * *****************************************************************************************************************************************
 * File Name: gb_qc_finalpercentages.sql
 * Project: Silicore
 * Description:  This MySQL table stores the final percentages for sieve stacks.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 06/13/2017|mnutsch|KACE:xxxxx - Initial creation
 * 10/02/2017|mnutsch|KACE:17957 - Added sieve stacks 11 - 18.
 * 
 * **************************************************************************************************************************************** */

DROP TABLE IF EXISTS `gb_qc_finalpercentages`;

CREATE TABLE `gb_qc_finalpercentages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sample_id` int(11) NOT NULL,
  `finalpercent1` double,
  `finalpercent2` double,
  `finalpercent3` double,
  `finalpercent4` double,
  `finalpercent5` double,
  `finalpercent6` double,
  `finalpercent7` double,
  `finalpercent8` double,
  `finalpercent9` double,
  `finalpercent10` double,
  `finalpercent11` double,
  `finalpercent12` double,
  `finalpercent13` double,
  `finalpercent14` double,
  `finalpercent15` double,
  `finalpercent16` double,
  `finalpercent17` double,
  `finalpercent18` double,
  `finalpercenttotal` double,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
