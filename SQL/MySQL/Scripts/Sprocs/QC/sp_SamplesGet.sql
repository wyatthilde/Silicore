/*******************************************************************************
 * File Name: sp_GetSamples.sql
 * Project: Sandbox
 * Author: mnutsch
 * Date Created: 6-5-2017
 * Description: Gets all data from gb_qc_samples.
 * Notes: 
 ******************************************************************************/

DELIMITER $$

DROP PROCEDURE IF EXISTS sp_GetSamples$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetSamples`()
BEGIN
    SELECT * from gb_qc_samples;
END$$

DELIMITER ;
