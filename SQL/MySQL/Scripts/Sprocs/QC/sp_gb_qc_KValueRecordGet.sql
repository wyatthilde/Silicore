/* * *****************************************************************************************************************************************
 * File Name: sp_gb_qc_KValueRecordGet.sql
 * Project: Silicore
 * Description: 
 * Notes: 
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 10/10/2017|mnutsch|KACE:17957 - Initial creation
 * 
 * **************************************************************************************************************************************** */

DROP PROCEDURE IF EXISTS sp_gb_qc_KValueRecordGet;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_KValueRecordGet`
(
    IN  p_sample_id INT(11),
    IN  p_k_value_id INT(11),
    IN  p_description VARCHAR(50)
)
BEGIN
    SELECT * FROM gb_qc_k_value_records 
    WHERE sample_id = p_sample_id
    AND k_value_id = p_k_value_id
    AND description = p_description
    LIMIT 1;
END$$

DELIMITER ;

