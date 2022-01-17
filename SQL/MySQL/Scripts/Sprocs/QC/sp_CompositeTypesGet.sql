/*******************************************************************************
 * File Name: sp_GetCompositeTypes.sql
 * Project: Sandbox
 * Author: Matt Nutsch
 * Date Created: 6-14-2017
 * Description: Gets all data from gb_qc_composites.
 * Notes: 
 ******************************************************************************/

DELIMITER $$

DROP PROCEDURE IF EXISTS sp_GetCompositeTypes$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetCompositeTypes`()
BEGIN
    SELECT * from gb_qc_composites;
END$$

DELIMITER ;