/*******************************************************************************************************************************************
 * File Name: sp_tl_qc_PlantSettingsRecordUpdate.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 10/06/2017|mnutsch|KACE:17957 - Initial creation
 * 
 ******************************************************************************************************************************************/

DELIMITER //

DROP PROCEDURE IF EXISTS sp_tl_qc_PlantSettingsRecordUpdate//

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_tl_qc_PlantSettingsRecordUpdate
(
    IN p_value DECIMAL(16,4),
    IN p_id INT(11)
)
BEGIN
    UPDATE tl_plant_settings_data 
    SET `value` = p_value
    WHERE `id` = p_id;
END//

DELIMITER ;



