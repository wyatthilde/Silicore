
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_ThresholdUpdate.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 10/18/2017|whildebrandt|KACE:19161 - Initial creation
 *
 ******************************************************************************************************************************************/
DROP procedure IF EXISTS `sp_gb_plc_ThresholdUpdate`;
DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_ThresholdUpdate`(
		IN  p_description varchar(256),
		IN  p_gauge_min float,
		IN  p_gauge_max float,
		IN  p_low_threshold float,
		IN  p_high_threshold float
)
BEGIN
	UPDATE gb_plc_tags
		SET description = p_description,
			gauge_min = p_gauge_min,
			gauge_max = p_gauge_max,
			low_threshold = p_low_threshold,
      high_threshold = p_high_threshold
		WHERE id = p_id;

END$$
DELIMITER ;;




