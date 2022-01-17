 /* * *****************************************************************************************************************************************
 * File Name: sp_tl_qc_CompletedSamplesInDateRangeGet.sql
 * Project: Silicore
 * Description: 
 * Notes: 
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 10/10/2017|mnutsch|KACE:17957 - Initial creation
 * 
 * **************************************************************************************************************************************** */

DROP PROCEDURE IF EXISTS sp_tl_qc_CompletedSamplesInDateRangeGet;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_CompletedSamplesInDateRangeGet`
(
    IN  p_start_date DATETIME,
    IN  p_end_date DATETIME
)
BEGIN
    SELECT * FROM tl_qc_samples 
    WHERE void_status_code != 'V' 
    AND date >= p_start_date
    AND date <= p_end_date
    AND is_complete = '1'
    ORDER BY date ASC;
END$$

DELIMITER ;