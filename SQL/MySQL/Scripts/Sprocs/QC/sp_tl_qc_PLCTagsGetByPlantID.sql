/*******************************************************************************************************************************************
 * File Name: sp_tl_qc_PLCTagsGetByPlantID.sql
 * Project: smashbox
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 10/09/2017|mnutsch|KACE:17957 - Initial creation
 * 
 ******************************************************************************************************************************************/

DELIMITER $$
DROP PROCEDURE IF EXISTS sp_tl_qc_PLCTagsGetByPlantID$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_PLCTagsGetByPlantID`
(
    IN p_plant_id INT(11)
)
BEGIN
    SELECT * FROM tl_auto_plant_analog_tags 
    WHERE is_mir = 1 
    AND is_hidden = 0 
    AND is_removed = 0 
    AND plant_id = p_plant_id;
END$$
DELIMITER ;



