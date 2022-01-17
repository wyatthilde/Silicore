/*******************************************************************************************************************************************
 * File Name: sp_gb_qc_ThresholdsInsert.sql
 * Project: Silicore
 * Description: Insert a value into the table gb_qc_thresholds.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 11/07/2017|mnutsch|KACE:19061 - Initial creation
 * 
 ******************************************************************************************************************************************/

DROP PROCEDURE IF EXISTS sp_gb_qc_ThresholdsInsert;
 
DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_gb_qc_ThresholdsInsert
(
    IN p_screen VARCHAR(16),
    IN p_location_id INT(11),
    IN p_low_threshold DOUBLE,
    IN p_high_threshold DOUBLE
)
BEGIN
INSERT INTO gb_qc_thresholds
(
    screen, 
    location_id, 
    low_threshold, 
    high_threshold
) 
VALUES 
(
    p_screen, 
    p_location_id, 
    p_low_threshold, 
    p_high_threshold
);
END$$

DELIMITER ;




