/*******************************************************************************************************************************************
 * File Name: gb_qc_repeatability_pairs.sql
 * Project: Sandbox
 * Author: mnutsch
 * Date Created: 6-27-2017
 * Description: This table holds QC repeatability sample pairs.
 * Notes: The database table should be prefixed with the plant abbreviation: gb_ = granbury, etc.
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `gb_qc_repeatability_pairs`;

CREATE TABLE `gb_qc_repeatability_pairs` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `original_sample` bigint(20) NOT NULL,
  `repeated_sample` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_index` (`original_sample`,`repeated_sample`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=latin1;
