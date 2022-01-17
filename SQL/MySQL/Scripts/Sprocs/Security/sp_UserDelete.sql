/* * *****************************************************************************
 * File Name: sp_DeleteUser.sql
 * Project: Sandbox
 * Author: Matt Nutsch
 * Date Created: Mar. 6, 2017
 * Description: This file contains the stored procedures for DeleteUser.
 * Notes: 
 * **************************************************************************** */

DELIMITER //

DROP PROCEDURE IF EXISTS sp_DeleteUser//

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_DeleteUser
(
    IN  p_id int(11)
)
BEGIN
DELETE FROM main_users
    WHERE id = p_id; 
END//

DELIMITER ;