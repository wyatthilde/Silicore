/*******************************************************************************************************************************************
 * File Name: sp_tl_qc_PlantSettingsRecordInsert.sql
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

DROP PROCEDURE IF EXISTS sp_tl_qc_PlantSettingsRecordInsert//

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_tl_qc_PlantSettingsRecordInsert
(
    IN p_sample_id INT(11),
    IN p_tag_id INT(11),
    IN p_value DECIMAL(16,4)
)
BEGIN
    INSERT INTO tl_plant_settings_data 
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
END//

DELIMITER ;



