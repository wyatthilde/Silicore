/*******************************************************************************************************************************************
 * File Name: sp_gb_qc_PlantSettingsRecordUpdate.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 10/06/2017|mnutsch|KACE:17957 - Initial creation
 * 11/29/2017|mnutsch|KACE:19445 - Replaced "prod_plant_mir_data" references with "gb_plant_settings_data".
 * 
 ******************************************************************************************************************************************/

DROP PROCEDURE IF EXISTS sp_gb_qc_PlantSettingsRecordUpdate;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE sp_gb_qc_PlantSettingsRecordUpdate
(
    IN p_value DECIMAL(16,4),
    IN p_id INT(11)
)
BEGIN
    UPDATE gb_plant_settings_data 
    SET `value` = p_value
    WHERE `id` = p_id;
END$$
DELIMITER ;



