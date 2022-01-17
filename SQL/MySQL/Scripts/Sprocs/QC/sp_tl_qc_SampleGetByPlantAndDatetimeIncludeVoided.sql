/* * *****************************************************************************************************************************************
 * File Name: sp_tl_qc_SampleGetByPlantAndDatetimeIncludeVoided.sql
 * Project: Silicore
 * Description: 
 * Notes: 
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 10/10/2017|mnutsch|KACE:17957 - Initial creation
 * 
 * **************************************************************************************************************************************** */

DROP PROCEDURE IF EXISTS sp_tl_qc_SampleGetByPlantAndDatetimeIncludeVoided;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_SampleGetByPlantAndDatetimeIncludeVoided`
(
    IN  p_plant_id INT(11),
    IN  p_date_id DATETIME
)
BEGIN
    SELECT * FROM tl_qc_samples 
    WHERE plant_id = p_plant_id
    AND dt = p_date_id;
END$$

DELIMITER ;

