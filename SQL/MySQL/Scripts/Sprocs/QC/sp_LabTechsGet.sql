/*******************************************************************************
 * File Name: sp_GetLabTechs.sql
 * Project: Sandbox
 * Author: mnutsch
 * Date Created: 6-5-2017
 * Description: Gets all a list of users who are flagged as lab techs.
 * Notes: 
 ******************************************************************************/

DELIMITER $$

DROP PROCEDURE IF EXISTS sp_GetLabTechs$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetLabTechs`()
BEGIN
    SELECT * from main_users
    WHERE qc_labtech = '1';
END$$

DELIMITER ;
