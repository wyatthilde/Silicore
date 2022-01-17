/*******************************************************************************************************************************************
 * File Name: gb_plc_analog_tag_hourly_totals.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 08/09/2017|kkuehn|KACE:16842 - Initial creation
 * 
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `gb_plc_analog_tag_hourly_totals`;

CREATE TABLE `gb_plc_analog_tag_hourly_totals` 
(
  `id` int(11) NOT NULL,
  `timestamp` datetime NOT NULL,
  `name` varchar(50) NOT NULL,
  `value` int(11) NOT NULL,
  `quality` int(11) NOT NULL,
  PRIMARY KEY (`id`)
)
ENGINE=InnoDB DEFAULT CHARSET=latin1;