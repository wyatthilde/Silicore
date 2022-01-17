/*******************************************************************************
 * File Name: sp_GetKValues.sql
 * Project: Sandbox
 * Author: mnutsch
 * Date Created: 6-5-2017
 * Description: Gets all data from gb_qc_k_values.
 * Notes: 
 ******************************************************************************/

DELIMITER $$

DROP PROCEDURE IF EXISTS sp_GetKValues$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetKValues`()
BEGIN
    SELECT * from gb_qc_k_values;
END$$

DELIMITER ;
