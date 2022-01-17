
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_ThresholdsGetAll.sql
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 02/07/2018|whildebrandt|KACE:20499 - Created stored procedure to get all thresholds where send_alert is flagged
 *
 ******************************************************************************************************************************************/
DROP PROCEDURE IF EXISTS sp_gb_plc_ThresholdsGetAll;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_ThresholdsGetAll`()
(
SELECT
	threshold,
	user_id,
	tag_id
FROM
	gb_plc_plant_thresholds
WHERE
	send_alert = 1
)$$
DELIMITER ;




