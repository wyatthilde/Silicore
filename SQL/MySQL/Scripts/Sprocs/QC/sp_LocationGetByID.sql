/* * *****************************************************************************
 * File Name: sp_GetLocationByID.sql
 * Project: Sandbox
 * Author: Matt Nutsch
 * Date Created: 6-5-2017
 * Description: This file contains the stored procedure for the function getLocationByID.
 * Notes: 
 * **************************************************************************** */

DELIMITER //

DROP PROCEDURE IF EXISTS sp_GetLocationByID//

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_GetLocationByID
(
    IN  p_locationId varchar(64)
)
BEGIN
SELECT * FROM main_locations
    WHERE id = p_locationId
LIMIT 1; 
END//

DELIMITER ;