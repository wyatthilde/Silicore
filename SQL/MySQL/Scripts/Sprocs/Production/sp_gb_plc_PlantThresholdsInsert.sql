
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_PlantThresholdsInsert.sql
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 01/25/2018|whildebrandt|KACE:20499 - Added procedure to insert into gb_plc_plant_thresholds
 * 04/16/2018|whildebrandt|KACE:20499 - Added fields to the sproc to work with plant thresholds table.

 ******************************************************************************************************************************************/
DROP PROCEDURE IF EXISTS `sp_gb_plc_PlantThresholdsInsert`;
DELIMITER $$
USE `silicore_site`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_PlantThresholdsInsert`(
	IN p_tag_id int(11),
	IN p_user_id int(11),
	IN p_threshold int(11),
	IN p_gauge_max int(11),
  IN p_gauge_action_limit int(11),
  IN p_gauge_warning_limit int(11),
	IN p_send_alert int(1)
)
INSERT INTO gb_plc_plant_thresholds 
(
    tag_id,
    user_id,
    threshold,
	  gauge_max,
    gauge_action_limit,
    gauge_warning_limit,
    send_alert,
    create_date,
    create_user_id,
    is_active
)
VALUES
(
    p_tag_id,
    p_user_id,
    p_threshold,
	  p_gauge_max,
    p_gauge_action_limit,
    p_gauge_warning_limit,
    p_send_alert,
    now(),
    p_user_id,
	1
)
ON DUPLICATE KEY UPDATE
	threshold = p_threshold,
	gauge_max = p_gauge_max,
  gauge_action_limit = p_gauge_action_limit,
  gauge_warning_limit = p_gauge_warning_limit,
	send_alert = p_send_alert,
	modify_date = now(),
	modify_user_id = p_user_id$$
DELIMITER ;