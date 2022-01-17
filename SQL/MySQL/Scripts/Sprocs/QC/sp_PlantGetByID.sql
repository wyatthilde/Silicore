/*******************************************************************************
 * File Name: sp_GetOperators.sql
 * Project: Sandbox
 * Author: mnutsch
 * Date Created: 6-5-2017
 * Description: Gets all a list of users who are flagged as operators.
 * Notes: 
 ******************************************************************************/

DELIMITER $$

DROP PROCEDURE IF EXISTS sp_GetOperators$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetOperators`()
BEGIN
    SELECT * from main_users
    WHERE qc_operator = '1';
END$$

DELIMITER ;
