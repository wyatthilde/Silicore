/*******************************************************************************************************************************************
 * File Name: sp_tl_qc_SampleByLocationMostRecentGet.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 09/07/2017|mnutsch|KACE:17959 - Initial creation
 * 02/12/2018|mnutsch|KACE:20683 - Updated to filter out Resample tests.
 * 
 ******************************************************************************************************************************************/

DELIMITER $$

DROP PROCEDURE IF EXISTS sp_tl_qc_SampleByLocationMostRecentGet$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_SampleByLocationMostRecentGet`
(
    IN  p_location INT
)
BEGIN
    SELECT * FROM tl_qc_samples 
    WHERE void_status_code != 'V' 
    AND location_id = p_location
    AND test_type_id != '1'
    AND test_type_id != '7'
    AND is_complete = 1 
    ORDER BY dt DESC 
    LIMIT 1
    ;
END$$


