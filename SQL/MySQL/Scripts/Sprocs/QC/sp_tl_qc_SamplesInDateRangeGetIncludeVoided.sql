/*******************************************************************************************************************************************
 * File Name: sp_tl_qc_SamplesInDateRangeGetIncludeVoided.sql
 * Project: Silicore
 * Description: Gets all data from gb_qc_samples for a date range, including voided items.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 09/07/2017|mnutsch|KACE:17959 - Initial creation
 * 
 ******************************************************************************************************************************************/

DELIMITER $$

DROP PROCEDURE IF EXISTS sp_tl_qc_SamplesInDateRangeGetIncludeVoided$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_SamplesInDateRangeGetIncludeVoided`
(
    IN  p_start_date DATETIME,
    IN  p_end_date DATETIME,
    IN  p_start_row INT,
    IN  p_results_per_page INT
)
BEGIN
    SELECT * from tl_qc_samples
    WHERE date >= p_start_date AND
    date <= p_end_date
    ORDER BY id DESC
    LIMIT p_start_row, p_results_per_page
    ;
END$$

