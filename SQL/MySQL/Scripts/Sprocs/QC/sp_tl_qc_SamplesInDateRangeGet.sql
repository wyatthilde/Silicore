/*******************************************************************************************************************************************
 * File Name: sp_tl_qc_SamplesInDateRangeGet.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 09/07/2017|mnutsch|KACE:17959 - Initial creation
 * 
 ******************************************************************************************************************************************/

DELIMITER $$

DROP PROCEDURE IF EXISTS sp_tl_qc_SamplesInDateRangeGet$$

CREATE PROCEDURE `sp_tl_qc_SamplesInDateRangeGet`
(
    IN  p_start_date DATETIME,
    IN  p_end_date DATETIME
)
BEGIN
    SELECT * from tl_qc_samples
    WHERE dt >= p_start_date AND
    dt <= p_end_date
    ORDER BY id DESC;
END$$

DELIMITER ;

