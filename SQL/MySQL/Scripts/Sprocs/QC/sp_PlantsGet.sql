/*******************************************************************************************************************************************
 * File Name: sp_GetPlants.sql
 * Project: Silicore
 * Description: This table stores a list of Plants used by the application.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 6/5/2017|mnutsch|KACE:xxxxx - Initial creation
 * 7/7/2017|mnutsch|KACE:xxxxx - Updated
 * 8/4/2017|mnutsch|KACE:17803 - Added ORDER BY to query.
 * 
 ******************************************************************************************************************************************/

DELIMITER $$

DROP PROCEDURE IF EXISTS sp_GetPlants$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetPlants`()
BEGIN
    SELECT * from main_plants 
    where is_active = 1
    ORDER BY sort_order ASC;
END$$

DELIMITER ;
