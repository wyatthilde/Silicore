/*******************************************************************************************************************************************
 * File Name: sp_tl_qc_KValueRecordInsert.sql
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

DROP PROCEDURE IF EXISTS sp_tl_qc_KValueRecordInsert//

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_tl_qc_KValueRecordInsert
(
    IN p_sample_id INT(11),
    IN p_k_value_id INT(11),
    IN p_description VARCHAR(50),
    IN p_value DOUBLE
)
BEGIN
    INSERT INTO tl_qc_k_value_records 
    (
        sample_id,
        k_value_id, 
        description, 
        value
    ) 
    VALUES 
    (
        p_sample_id, 
        p_k_value_id, 
        p_description, 
        p_value
    );
END//

DELIMITER ;



