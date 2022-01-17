/* * *****************************************************************************************************************************************
 * File Name: sp_tl_qc_LocationsGetByPlant.sql
 * Project: Silicore
 * Description: 
 * Notes: 
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 10/10/2017|mnutsch|KACE:17957 - Initial creation
 * 
 * **************************************************************************************************************************************** */

DROP PROCEDURE IF EXISTS sp_tl_qc_LocationsGetByPlant;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_LocationsGetByPlant`
(
    IN  p_main_plant_id INT(11)
)
BEGIN
    SELECT * FROM tl_qc_locations 
    WHERE is_active = 1 
    AND main_plant_id = p_main_plant_id
    ORDER BY sort_order ASC;
END$$

DELIMITER ;