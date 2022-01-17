/* * *****************************************************************************
 * File Name: sp_GetUserPermissions.sql
 * Project: Sandbox
 * Author: Matt Nutsch
 * Date Created: Mar. 23, 2017
 * Description: This file contains the stored procedures for GetUserPermissions.
 * Notes: 
 * **************************************************************************** */

DELIMITER //

DROP PROCEDURE IF EXISTS sp_GetUserPermissions//

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_GetUserPermissions
(
    IN  p_user_id int(11)
)
BEGIN
SELECT * FROM main_user_permissions
    WHERE user_id = p_user_id;
END//

DELIMITER ;