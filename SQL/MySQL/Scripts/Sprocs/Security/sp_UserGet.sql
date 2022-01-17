/* * *****************************************************************************
 * File Name: sp_GetUser.sql
 * Project: Sandbox
 * Author: Matt Nutsch
 * Date Created: Mar. 6, 2017
 * Description: This file contains the stored procedures for GetUser.
 * Notes: 
 * **************************************************************************** */

DELIMITER //

DROP PROCEDURE IF EXISTS sp_GetUser//

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_GetUser
(
    IN  p_id int(11)
)
BEGIN
SELECT * FROM main_users
    WHERE id = p_id
LIMIT 1; 
END//

DELIMITER ;