/*******************************************************************************************************************************************
 * File Name: sp_gb_qc_LocationGetByID.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 06/05/2017|mnutsch|KACE:17959 - Initial creation
 * 10/05/2017|mnutsch|KACE:17957 - Edited and renamed
 * 
 ******************************************************************************************************************************************/

DELIMITER //

DROP PROCEDURE IF EXISTS sp_gb_qc_LocationGetByID//

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_gb_qc_LocationGetByID
(
    IN  p_locationId INT(11)
)
BEGIN
SELECT * FROM gb_qc_locations
    WHERE id = p_locationId
LIMIT 1; 
END//

DELIMITER ;