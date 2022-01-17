 /* * *****************************************************************************************************************************************
 * File Name: sp_qc_SamplesInDateRangeGet.sql
 * Project: Silicore
 * Description: Gets all data from gb_qc_samples for a date range, including voided items.
 * Notes: 
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 08/04/2017|mnutsch|KACE:17803 - Initial creation
 * 08/15/2017|mnutsch|KACE:17978 - Added order by to the sql query. 
 * 08/16/2017|mnutsch|KACE:17978 - Fixed an issue where one sproc was overwritten with another.
 * 08/28/2017|mnutsch|KACE:17957 - Added parameters for the starting row and results per page.
 * 
 * **************************************************************************************************************************************** */

DELIMITER $$

DROP PROCEDURE IF EXISTS sp_qc_GetSamplesInDateRangeIncludeVoided$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_qc_GetSamplesInDateRangeIncludeVoided`
(
    IN  p_start_date DATETIME,
    IN  p_end_date DATETIME,
    IN  p_start_row INT,
    IN  p_results_per_page INT
)
BEGIN
    SELECT * from gb_qc_samples
    WHERE date >= p_start_date AND
    date <= p_end_date
    ORDER BY id DESC
    LIMIT p_start_row, p_results_per_page
    ;
END$$
