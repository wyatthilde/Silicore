/* * *****************************************************************************
 * File Name: sp_UpdateUser.sql
 * Project: Sandbox
 * Author: Matt Nutsch
 * Date Created: Mar. 6, 2017
 * Updated 3-23-2017 mnutsch
 * Description: This file contains the stored procedures for UpdateUser.
 * Notes: 
 * **************************************************************************** */

DELIMITER //

DROP PROCEDURE IF EXISTS sp_UpdateUser//

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_UpdateUser
(
    IN  p_id int(11),
    IN  p_username VARCHAR(64),
    IN  p_first_name VARCHAR(32),
    IN  p_last_name VARCHAR(32),
    IN  p_display_name VARCHAR(64),
    IN  p_email VARCHAR(128),
    IN  p_company VARCHAR(32),
    IN  p_main_department_id INT(11),
    IN  p_last_logged DATETIME,
    IN  p_start_date DATE,
    IN  p_is_active TINYINT(1),
    IN  p_require_password_reset TINYINT(1),
    IN  p_password_reset_token VARCHAR(64),
    IN  p_password_token_expiration DATETIME
)
BEGIN
UPDATE main_users
    SET 
        username = p_username,
        first_name = p_first_name, 
        last_name = p_last_name, 
        display_name = p_display_name, 
        email = p_email, 
        company = p_company, 
        main_department_id = p_main_department_id, 
        last_logged = p_last_logged,
        start_date = p_start_date,
        is_active = p_is_active,
        require_password_reset = p_require_password_reset,
        password_reset_token = p_password_reset_token,
	password_token_expiration = p_password_token_expiration
    WHERE id = p_id;
END//

DELIMITER ;