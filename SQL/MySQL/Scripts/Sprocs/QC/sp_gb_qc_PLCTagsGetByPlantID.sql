/*******************************************************************************************************************************************
 * File Name: sp_gb_qc_PLCTagsGetByPlantID.sql
 * Project: smashbox
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 10/09/2017|mnutsch|KACE:17957 - Initial creation
 * 01/19/2018|mnutsch|KACE:18518 - I cleaned up the organization of the file.
 * 
 ******************************************************************************************************************************************/

DROP PROCEDURE IF EXISTS sp_gb_qc_PLCTagsGetByPlantID;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_PLCTagsGetByPlantID`
(
    IN p_plant_id INT(11)
)
BEGIN
    SELECT * FROM prod_auto_plant_analog_tags 
    WHERE is_mir = 1 
    AND is_hidden = 0 
    AND is_removed = 0 
    AND plant_id = p_plant_id;
END$$
DELIMITER ;



