
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_IdletimeDurationSumGet.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 12/01/2017|whildebrandt|KACE:19563 - created stored procedure to select the sum of duration minutes from 
 *
 ******************************************************************************************************************************************/
DROP PROCEDURE IF EXISTS `sp_gb_plc_IdletimeDurationSumGet`;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_IdletimeDurationSumGet`(
	IN p_shift_id bigint(20)
)
SELECT 
	SUM(duration_minutes) AS idletime_minutes 
FROM 
	gb_plc_idletime
WHERE 
	shift_id = p_shift_id$$
DELIMITER ;



