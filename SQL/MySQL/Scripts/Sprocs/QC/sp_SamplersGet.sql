/*******************************************************************************
 * File Name: sp_GetSamplers.sql
 * Project: Sandbox
 * Author: mnutsch
 * Date Created: 6-5-2017
 * Description: Gets all a list of users who are flagged as samplers.
 * Notes: 
 ******************************************************************************/

DELIMITER $$

DROP PROCEDURE IF EXISTS sp_GetSamplers$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetSamplers`()
BEGIN
    SELECT * from main_users
    WHERE qc_sampler = '1';
END$$

DELIMITER ;
