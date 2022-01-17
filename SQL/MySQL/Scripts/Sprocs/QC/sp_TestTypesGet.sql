/*******************************************************************************
 * File Name: sp_GetTestTypes.sql
 * Project: Sandbox
 * Author: mnutsch
 * Date Created: 6-15-2017
 * Description: Gets all data from gb_qc_test_types.
 * Notes: 
 ******************************************************************************/

DELIMITER $$

DROP PROCEDURE IF EXISTS sp_GetTestTypes$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetTestTypes`()
BEGIN
    SELECT * from gb_qc_test_types;
END$$

DELIMITER ;
