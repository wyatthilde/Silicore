/*******************************************************************************************************************************************
 * File Name: tl_plant_settings_data.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 09/06/2017|mnutsch|KACE:17959 - Initial creation
 * 
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `tl_plant_settings_data`;

CREATE TABLE `tl_plant_settings_data` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sample_id` bigint(20) NOT NULL,
  `tag_id` bigint(20) NOT NULL,
  `value` decimal(16,4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `device_id` (`tag_id`),
  KEY `sample_id` (`sample_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1917595 DEFAULT CHARSET=latin1;