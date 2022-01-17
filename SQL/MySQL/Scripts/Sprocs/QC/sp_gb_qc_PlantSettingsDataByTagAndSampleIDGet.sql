/*******************************************************************************************************************************************
 * File Name: sp_gb_qc_PlantSettingsDataByTagAndSampleIDGet.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 10/09/2017|mnutsch|KACE:17957 - Initial creation
 * 11/29/2017|mnutsch|KACE:19445 - Replaced "prod_plant_mir_data" references with "gb_plant_settings_data".
 * 11/29/2017|mnutsch|KACE:19445 - Replaced "prod_auto_plant_analog_tags" references with "gb_auto_plant_analog_tags".
 * 
 ******************************************************************************************************************************************/

DROP PROCEDURE IF EXISTS sp_gb_qc_PlantSettingsDataByTagAndSampleIDGet;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_PlantSettingsDataByTagAndSampleIDGet`
(
    IN p_sample_id INT(11),
    IN p_tag_id INT(11)
)
BEGIN
    SELECT gb_plant_settings_data.id, gb_plant_settings_data.sample_id, gb_plant_settings_data.tag_id, gb_plant_settings_data.value, gb_auto_plant_analog_tags.device 
    FROM gb_plant_settings_data 
    LEFT JOIN gb_auto_plant_analog_tags ON gb_plant_settings_data.tag_id = gb_auto_plant_analog_tags.id 
    WHERE gb_plant_settings_data.sample_id = p_sample_id 
    AND gb_plant_settings_data.tag_id = p_tag_id 
    LIMIT 1;
END$$
DELIMITER ;
