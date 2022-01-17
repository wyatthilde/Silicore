/*******************************************************************************************************************************************
 * File Name: sp_tl_qc_KValueRecordUpdate.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 10/06/2017|mnutsch|KACE:17957 - Initial creation
 * 
 ******************************************************************************************************************************************/

DROP PROCEDURE IF EXISTS sp_tl_qc_KValueRecordUpdate$$

DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE sp_tl_qc_KValueRecordUpdate
(
    IN p_value DOUBLE,
    IN p_id INT(11),
    IN p_k_value_id INT(11),
    IN p_description VARCHAR(50) 
)
BEGIN
    UPDATE tl_qc_k_value_records 
    SET `value` = $value 
    WHERE `sample_id` = p_id
    AND `k_value_id` = p_k_value_id
    AND `description` = p_description;
END$$
DELIMITER ;



