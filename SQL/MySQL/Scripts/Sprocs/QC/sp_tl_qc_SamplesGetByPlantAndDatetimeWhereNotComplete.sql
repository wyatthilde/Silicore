/*******************************************************************************************************************************************
 * File Name: sp_gb_qc_SamplesGetByPlantAndDatetimeWhereNotComplete.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 11/30/2017|mnutsch|KACE:18968 - Initial creation
 * 
 ******************************************************************************************************************************************/

DROP PROCEDURE IF EXISTS sp_tl_qc_SamplesGetByPlantAndDatetimeWhereNotComplete;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_SamplesGetByPlantAndDatetimeWhereNotComplete`
(
    IN  p_plant_id INT(11),
    IN  p_date_id DATETIME
)
BEGIN
    SELECT * FROM tl_qc_samples 
    WHERE plant_id = p_plant_id
    AND dt = p_date_id
    AND is_complete = 0
    AND void_status_code = 'A';
END$$

DELIMITER ;

