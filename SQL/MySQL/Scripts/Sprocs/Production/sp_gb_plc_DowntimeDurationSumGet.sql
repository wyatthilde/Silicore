
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_DowntimeDurationSumGet.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 12/01/2017|whildebrandt|KACE:19563 - Created stored procedure that gets the sum of duration minutes from idletime table
 *
 ******************************************************************************************************************************************/
DROP PROCEDURE IF EXISTS `sp_gb_plc_DowntimeDurationSumGet`;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_DowntimeDurationSumGet`(
	IN p_shift_id bigint(20)
)
SELECT 
	SUM(duration_minutes) AS downtime_minutes 
FROM 
	gb_plc_downtime 
WHERE 
	shift_id = p_shift_id$$
DELIMITER ;




