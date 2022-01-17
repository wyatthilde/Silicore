/* * *****************************************************************************
 * File Name: sp_GetUserByName.sql
 * Project: Sandbox
 * Author: Matt Nutsch
 * Date Created: Mar. 23, 2017
 * Description: This file contains the stored procedures for GetUserByName.
 * Notes: 
 * **************************************************************************** */

DELIMITER //

DROP PROCEDURE IF EXISTS sp_GetUserByName//

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_GetUserByName
(
    IN  p_username varchar(64)
)
BEGIN
SELECT * FROM main_users
    WHERE username = p_username
LIMIT 1; 
END//

DELIMITER ;