/* * *****************************************************************************
 * File Name: sp_UpdateUserPassword.sql
 * Project: Sandbox
 * Author: Matt Nutsch
 * Date Created: Mar. 24, 2017
 * Description: This file contains the stored procedures for UpdateUserPassword.
 * Notes: 
 * **************************************************************************** */

DELIMITER //

DROP PROCEDURE IF EXISTS sp_UpdateUserPassword//

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_UpdateUserPassword
(
    IN  p_password varchar(255),
    IN  p_userid int(11)
)
BEGIN
UPDATE main_users 
SET 
    password = p_password, 
    require_password_reset = '0' 
WHERE id = p_userid;
END//

DELIMITER ;