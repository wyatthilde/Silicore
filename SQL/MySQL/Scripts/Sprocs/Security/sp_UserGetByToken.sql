/* * *****************************************************************************
 * File Name: sp_GetUserByToken.sql
 * Project: Sandbox
 * Author: Matt Nutsch
 * Date Created: Mar. 27, 2017
 * Description: This file contains the stored procedures for GetUserByToken.
 * Notes: 
 * **************************************************************************** */

DELIMITER //

DROP PROCEDURE IF EXISTS sp_GetUserByToken//

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_GetUserByToken
(
    IN  p_password_reset_token varchar(64)
)
BEGIN
SELECT * FROM main_users
    WHERE password_reset_token = p_password_reset_token
LIMIT 1; 
END//

DELIMITER ;