/*******************************************************************************************************************************************
 * File Name: sp_gb_qc_PlantSettingsRecordInsert.sql
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

DROP PROCEDURE IF EXISTS sp_gb_qc_PlantSettingsRecordInsert;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE sp_gb_qc_PlantSettingsRecordInsert
(
    IN p_sample_id INT(11),
    IN p_tag_id INT(11),
    IN p_value DECIMAL(16,4)
)
BEGIN
    INSERT INTO gb_plant_settings_data 
    (
        sample_id, 
        tag_id, 
        value
    ) 
    VALUES 
    (
        p_sample_id, 
        p_tag_id, 
        p_value
    );
END$$
DELIMITER ;



