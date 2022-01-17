/*******************************************************************************************************************************************
 * File Name: sp_tl_qc_TestTypeGetByID.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 09/11/2017|mnutsch|KACE:17959 - Initial creation
 * 
 ******************************************************************************************************************************************/

DELIMITER //
DROP PROCEDURE IF EXISTS sp_tl_qc_TestTypeGetByID//
CREATE DEFINER=`root`@`localhost` PROCEDURE sp_tl_qc_TestTypeGetByID
(
    IN  p_testTypeId varchar(64)
)
BEGIN
SELECT * FROM tl_qc_test_types
    WHERE id = p_testTypeId
LIMIT 1; 
END//
DELIMITER ;

