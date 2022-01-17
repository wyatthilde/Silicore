
/*******************************************************************************************************************************************
 * File Name: gb_plc_TS_10minute.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 09/27/2017|whildebrandt|KACE:18867 - Initial creation
 *
 ******************************************************************************************************************************************/

USE silicore_site;

DROP TABLE IF EXISTS `gb_plc_TS_10minute`;

CREATE TABLE `gb_plc_TS_10minute` 
(
  `id` int(11) NOT NULL,
  `timestamp` datetime NOT NULL,
  `name` varchar(50) NOT NULL,
  `value` float NOT NULL,
  `quality` int(11) NOT NULL,
  PRIMARY KEY (`id`)
)
ENGINE=InnoDB DEFAULT CHARSET=latin1;