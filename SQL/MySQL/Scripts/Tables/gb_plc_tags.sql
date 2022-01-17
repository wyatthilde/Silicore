
/*******************************************************************************************************************************************
 * File Name: gb_plc_tags.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 10/16/2017|whildebrandt|KACE:19142 - Initial creation
 * 10/18/2017|kkuehn|KACE:19142 - Rearranged column order
 * 10/18/2017|whildebrandt|KACE:19142 - Added additional fields to table
 * 11/29/2017|whildebrandt|KACE:19563 - added xfer_id to tags table
 ******************************************************************************************************************************************/
DROP TABLE IF EXISTS `gb_plc_tags`;
CREATE TABLE `gb_plc_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plant_id` int(11) NOT NULL,
  `plc_id` varchar(32) NOT NULL,
  `plc_ip` varchar(16) NOT NULL,
  `name` varchar(64) NOT NULL,
  `description` varchar(256) DEFAULT NULL,
  `units` varchar(16) NOT NULL,
  `low_threshold` float NOT NULL,
  `high_threshold` float NOT NULL,
  `show_in_kpi` tinyint(4) DEFAULT '0',
  `kpi_gauge_title` varchar(32) DEFAULT NULL,
  `kpi_gauge_label` varchar(64) DEFAULT NULL,
  `kpi_gauge_min` int(11) DEFAULT NULL,
  `kpi_gauge_max` int(11) DEFAULT NULL,
  `kpi_gauge_sector01_high` int(11) DEFAULT NULL,
  `kpi_gauge_sector02_high` int(11) DEFAULT NULL,
  `kpi_gauge_sector03_high` int(11) DEFAULT NULL,
  `kpi_gauge_sector04_high` int(11) DEFAULT NULL,
  `kpi_gauge_init_value` int(11) DEFAULT NULL,
  `kpi_gauge_sector01_color` int(11) DEFAULT NULL,
  `kpi_gauge_sector02_color` int(11) DEFAULT NULL,
  `kpi_gauge_sector03_color` int(11) DEFAULT NULL,
  `kpi_gauge_sector04_color` int(11) DEFAULT NULL,
  `kpi_gauge_sector05_color` int(11) DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  `Xfer_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

