
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_UserThresholdGet.sql
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 01/22/2018|whildebrandt|KACE:20499 - Added procedure to get threshold data from gb_plc_plant_thresholds
 * 04/18/2018|whildebrandt|KACE:20499 - Adjusted for additional gauge settings in plant thresholds.
 ******************************************************************************************************************************************/
DELIMITER $$
USE `silicore_site`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_UserThresholdGet`(IN p_tag_id int(11), IN p_user_id int(11))
(
SELECT
	id,
	threshold,
  gauge_max,
  gauge_action_limit,
  gauge_warning_limit,
  send_alert
FROM
	gb_plc_plant_thresholds
WHERE
	tag_id = p_tag_id AND user_id = p_user_id
)$$
DELIMITER ;




