/*******************************************************************************************************************************************
 * File Name: sp_tl_qc_TestTypesGet.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 09/11/2017|mnutsch|KACE:17959 - Initial creation
 * 
 ******************************************************************************************************************************************/

DELIMITER $$
DROP PROCEDURE IF EXISTS sp_tl_qc_TestTypesGet$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_TestTypesGet`()
BEGIN
    SELECT * from tl_qc_test_types;
END$$
DELIMITER ;

