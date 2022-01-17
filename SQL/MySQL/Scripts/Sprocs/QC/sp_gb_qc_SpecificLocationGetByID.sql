/* * *****************************************************************************************************************************************
 * File Name: sp_gb_qc_SpecificLocationGetByID.sql
 * Project: Silicore
 * Description: 
 * Notes: 
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 10/10/2017|mnutsch|KACE:17957 - Initial creation
 * 
 * **************************************************************************************************************************************** */

DROP PROCEDURE IF EXISTS sp_gb_qc_SpecificLocationGetByID;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_SpecificLocationGetByID`
(
    IN  p_specific_location_id INT(11)
)
BEGIN
    SELECT * FROM gb_qc_locations_details 
    WHERE id = p_specific_location_id
    LIMIT 1;
END$$

DELIMITER ;