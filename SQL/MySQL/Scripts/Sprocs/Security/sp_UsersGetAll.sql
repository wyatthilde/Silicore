/*******************************************************************************
 * File Name: sp_GetAllUsers.sql
 * Project: Sandbox
 * Author: kkuehn
 * Date Created: Dec 30, 2016[4:42:11 PM]
 * Description: Gets all user data from main_users.
 * Notes: 
 ******************************************************************************/

DELIMITER $$

DROP PROCEDURE IF EXISTS sp_GetAllUsers$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetAllUsers`()
BEGIN
    SELECT * from main_users;
END$$

DELIMITER ;
