/*******************************************************************************************************************************************
 * File Name: sp_tl_qc_SampleVoid.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 09/11/2017|mnutsch|KACE:17959 - Initial creation
 * 
 ******************************************************************************************************************************************/

DELIMITER //
DROP PROCEDURE IF EXISTS sp_tl_qc_SampleVoid//
CREATE DEFINER=`root`@`localhost` PROCEDURE sp_tl_qc_SampleVoid
(
    IN  p_sample_id BIGINT(20)
)
BEGIN
    UPDATE `tl_qc_samples` 
    SET `void_status_code`='V' 
    WHERE id = p_sample_id; 
END//
DELIMITER ;


