/*******************************************************************************************************************************************
 * File Name: sp_tl_qc_ShiftsGetBySiteAndDate.sql
 * Project: Silicore
 * Description: This stored procedure reads Shift info by Site ID and Date.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 01/22/2018|mnutsch|KACE:18518 - Initial creation
 * 
 ******************************************************************************************************************************************/

DROP PROCEDURE IF EXISTS sp_tl_qc_ShiftsGetBySiteAndDate;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_ShiftsGetBySiteAndDate`
(
    IN p_plant_id INT(11),
    IN p_time TIME
)
BEGIN
    SELECT * 
    FROM main_shifts 
    WHERE site_id = p_plant_id 
        AND p_time >= start_time 
    ORDER BY start_time DESC 
    LIMIT 1;
END$$

DELIMITER ;



