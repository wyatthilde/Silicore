/*******************************************************************************************************************************************
 * File Name: sp_gb_qc_ThresholdsUpdate.sql
 * Project: Silicore
 * Description: update a record in the table gb_qc_thresholds.
 * Notes: Usage example: CALL sp_gb_qc_ThresholdsUpdate('30','54','0.2','0.9');
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 11/07/2017|mnutsch|KACE:19061 - Initial creation
 * 11/10/2017|mnutsch|KACE:19061 - Modified parameters and logic.
 * 
 ******************************************************************************************************************************************/

DROP PROCEDURE IF EXISTS sp_gb_qc_ThresholdsUpdate;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE sp_gb_qc_ThresholdsUpdate
(
    IN p_id INT(11),
    IN p_screen VARCHAR(16),
    IN p_location_id INT(11),
    IN p_low_threshold DOUBLE,
    IN p_high_threshold DOUBLE,
    IN p_is_active TINYINT(1)
)
BEGIN
    UPDATE gb_qc_thresholds
    SET 
    `screen` = p_screen,
    `location_id` = p_location_id,
    `low_threshold` = p_low_threshold,
    `high_threshold` = p_high_threshold,
    `is_active` = p_is_active
    WHERE `id` = p_id;
END$$
DELIMITER ;