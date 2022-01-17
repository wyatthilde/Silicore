/*******************************************************************************************************************************************
 * File Name: sp_tl_qc_SampleVoidReverse.sql
 * Project: Silicore
 * Description: This stored prcoedure changes the status of a sample to active.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 09/15/2017|mnutsch|KACE:17957 - Initial creation
 * 
 ******************************************************************************************************************************************/

DELIMITER //
DROP PROCEDURE IF EXISTS sp_tl_qc_SampleVoidReverse//
CREATE DEFINER=`root`@`localhost` PROCEDURE sp_tl_qc_SampleVoidReverse
(
    IN  p_sample_id BIGINT(20)
)
BEGIN
    UPDATE `tl_qc_samples` 
    SET `void_status_code`='A' 
    WHERE id = p_sample_id; 
END//
DELIMITER ;

