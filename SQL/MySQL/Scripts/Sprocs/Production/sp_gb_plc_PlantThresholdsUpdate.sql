
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_PlantThresholdsUpdate.sql
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 01/25/2018|whildebrandt|KACE:20499 - Added procedure to update gb_plc_plant_thresholds
 * 04/16/2018|whildebrandt|KACE:20499 - Updated sproc to add fields for changes on plant thresholds table.
 ******************************************************************************************************************************************/
DROP PROCEDURE IF EXISTS `sp_gb_plc_PlantThresholdsUpdate`;
DELIMITER $$
USE `silicore_site`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_PlantThresholdsUpdate`(
	IN p_id int(11),
	IN p_user_id int(11),
	IN p_threshold int(11),
  IN p_gauge_max int(11),
  IN p_gauge_action_limit int(11),
  IN p_gauge_warning_limit int(11),
	IN p_send_alert int(1)
)
BEGIN
UPDATE gb_plc_plant_thresholds
SET
	threshold = p_threshold,
  gauge_max = p_gauge_max,
  gauge_action_limit = p_gauge_action_limit,
  gauge_warning_limit = p_gauge_warning_limit,
	send_alert = p_send_alert,
	modify_date = now(),
	modify_user_id = p_user_id
WHERE id = p_id;
END$$
DELIMITER ;

