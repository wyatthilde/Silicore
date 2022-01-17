/*******************************************************************************************************************************************
 * File Name: sp_gb_qc_SpecificLocationsGetByLocation.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 10/04/2017|mnutsch|KACE:17957 - Initial creation
 * 
 ******************************************************************************************************************************************/

DELIMITER //

DROP PROCEDURE IF EXISTS sp_gb_qc_SpecificLocationsGetByLocation//

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_gb_qc_SpecificLocationsGetByLocation
(
    IN  p_locationId int(11)
)
BEGIN
SELECT * FROM gb_qc_locations_details 
    WHERE is_active = 1 
    AND qc_location_id = p_locationId 
    ORDER BY sort_order ASC; 
END//

DELIMITER ;



