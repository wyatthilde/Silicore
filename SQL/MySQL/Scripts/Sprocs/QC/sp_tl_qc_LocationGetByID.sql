/*******************************************************************************************************************************************
 * File Name: sp_tl_qc_LocationGetByID.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 10/05/2017|mnutsch|KACE:17957 - Initial creation
 * 
 ******************************************************************************************************************************************/

DELIMITER //

DROP PROCEDURE IF EXISTS sp_tl_qc_LocationGetByID//

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_tl_qc_LocationGetByID
(
    IN  p_locationId INT(11)
)
BEGIN
SELECT * FROM tl_qc_locations
    WHERE id = p_locationId
LIMIT 1; 
END//

DELIMITER ;


