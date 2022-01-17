/* * *****************************************************************************************************************************************
 * File Name: sp_GetLocations.sql
 * Project: Silicore
 * Description: Gets all data from qc_locations.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 06/15/2017|mnutsch|KACE:xxxxx - Initial creation
 * 07/07/2017|mnutsch|KACE:xxxxx - Continued development
 * 08/04/2017|mnutsch|KACE:17803 - Added ORDER BY to the SQL.
 * 
 * **************************************************************************************************************************************** */

DELIMITER $$

DROP PROCEDURE IF EXISTS sp_GetLocations$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetLocations`()
BEGIN
    SELECT * from gb_qc_locations 
    WHERE is_active = 1
    ORDER BY sort_order ASC;
END$$

DELIMITER ;
