/*******************************************************************************************************************************************
 * File Name: sp_UserInsert.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 09/05/2017|mnutsch|KACE:18406 - Initial creation
 * 
 ******************************************************************************************************************************************/

DELIMITER //

DROP PROCEDURE IF EXISTS sp_UserInsert//

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_UserInsert
(
    IN p_username VARCHAR(64),
    IN p_first_name VARCHAR(32),
    IN p_last_name VARCHAR(32),
    IN p_display_name VARCHAR(64),
    IN p_email VARCHAR(128),
    IN p_company VARCHAR(64),
    IN p_main_department_id INT(11),
    IN p_password VARCHAR(255),
    IN p_last_logged DATETIME,
    IN p_start_date DATE,
    IN p_separation_date DATE,
    IN p_is_active TINYINT(1),
    IN p_require_password_reset TINYINT(1),
    IN p_password_reset_token VARCHAR(64),
    IN p_password_token_expiration DATETIME,
    IN p_user_type_id INT(11)
)
BEGIN
INSERT INTO main_users
(
    username, 
    first_name, 
    last_name, 
    display_name, 
    email, 
    company, 
    main_department_id, 
    password, 
    last_logged, 
    start_date, 
    separation_date, 
    is_active, 
    require_password_reset, 
    password_reset_token,
    password_token_expiration, 
    user_type_id
)
VALUES 
(
    p_username, 
    p_first_name, 
    p_last_name, 
    p_display_name, 
    p_email, 
    p_company, 
    p_main_department_id, 
    p_password, 
    p_last_logged, 
    p_start_date, 
    p_separation_date, 
    p_is_active, 
    p_require_password_reset, 
    p_password_reset_token,
    p_password_token_expiration, 
    p_user_type_id
) ; 
END//

DELIMITER ;

