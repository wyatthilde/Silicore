 /* * *****************************************************************************************************************************************
 * File Name: sp_qc_SamplesInDateRangeGet.sql
 * Project: Silicore
 * Description: Gets all data from gb_qc_samples for a date range, excluding voided items.
 * Notes: 
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 06/05/2017|mnutsch|KACE:xxxxx - Initial creation
 * 08/01/2017|mnutsch|KACE:17693 - Updated code.
 * 08/02/2017|mnutsch|KACE:17693 - Updated code.
 * 08/16/2017|mnutsch|KACE:17978 - Fixed an issue where one sproc was overwritten with another.
 * 
 * **************************************************************************************************************************************** */

DELIMITER $$

DROP PROCEDURE IF EXISTS sp_qc_GetSamplesInDateRange$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_qc_GetSamplesInDateRange`
(
    IN  p_start_date DATETIME,
    IN  p_end_date DATETIME
)
BEGIN
    SELECT * from gb_qc_samples
    WHERE void_status_code != 'V' AND
    date >= p_start_date AND
    date <= p_end_date
    ORDER BY id DESC
    ;
END$$
