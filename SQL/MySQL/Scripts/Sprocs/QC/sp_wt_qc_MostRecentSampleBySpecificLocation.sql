/*******************************************************************************************************************************************
 * File Name: sp_wt_qc_MostRecentSampleBySpecificLocation.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 02/12/2018|mnutsch|KACE:20683 - Initial creation
 * 02/12/2018|mnutsch|KACE:20683 - Add filter to exclude Resample tests.
 * 
 ******************************************************************************************************************************************/

DELIMITER //

DROP PROCEDURE IF EXISTS sp_wt_qc_MostRecentSampleBySpecificLocation//

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_wt_qc_MostRecentSampleBySpecificLocation
(
    IN  p_specific_location_id int(11)
)
BEGIN
SELECT * FROM wt_qc_samples 
    WHERE void_status_code != 'V' 
    AND test_type_id != '7'
    AND specific_location_id = p_specific_location_id
    AND is_complete = 1 
    ORDER BY id DESC 
    LIMIT 1;
END//

DELIMITER ;

