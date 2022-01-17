/* * *****************************************************************************************************************************************
 * File Name: sp_gb_qc_SpecificLocationsGet.sql
 * Project: Silicore
 * Description: Gets all data from gb_qc_location_details.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 09/27/2017|mnutsch|KACE:17957 - Initial creation
 * 
 * **************************************************************************************************************************************** */

DELIMITER $$

DROP PROCEDURE IF EXISTS sp_gb_qc_SpecificLocationsGet$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_SpecificLocationsGet`()
BEGIN
    SELECT * from gb_qc_locations_details
    WHERE is_active = 1
    ORDER BY sort_order ASC;
END$$

DELIMITER ;