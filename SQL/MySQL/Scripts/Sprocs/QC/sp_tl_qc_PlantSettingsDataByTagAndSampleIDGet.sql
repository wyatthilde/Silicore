/*******************************************************************************************************************************************
 * File Name: sp_tl_qc_PlantSettingsDataByTagAndSampleIDGet.sql
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
DROP PROCEDURE IF EXISTS sp_tl_qc_PlantSettingsDataByTagAndSampleIDGet$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_PlantSettingsDataByTagAndSampleIDGet`
(
    IN p_sample_id INT(11),
    IN p_tag_id INT(11)
)
BEGIN
    SELECT tl_plant_mir_data.id, tl_plant_mir_data.sample_id, tl_plant_mir_data.tag_id, tl_plant_mir_data.value, tl_auto_plant_analog_tags.device 
    FROM tl_plant_mir_data 
    LEFT JOIN tl_auto_plant_analog_tags ON tl_plant_mir_data.tag_id = tl_auto_plant_analog_tags.id 
    WHERE tl_plant_mir_data.sample_id = p_sample_id 
    AND tl_plant_mir_data.tag_id = p_tag_id 
    LIMIT 1;
END$$
DELIMITER ;
