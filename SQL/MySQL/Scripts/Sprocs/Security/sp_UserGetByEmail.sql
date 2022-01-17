/* * *****************************************************************************
 * File Name: sp_GetUserByEmail.sql
 * Project: Sandbox
 * Author: Matt Nutsch
 * Date Created: Mar. 23, 2017
 * Description: This file contains the stored procedures for GetUserByEmail.
 * Notes: 
 * **************************************************************************** */

DELIMITER //

DROP PROCEDURE IF EXISTS sp_GetUserByEmail//

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_GetUserByEmail
(
    IN  p_email varchar(128)
)
BEGIN
SELECT * FROM main_users
    WHERE email = p_email
LIMIT 1; 
END//

DELIMITER ;