/*******************************************************************************************************************************************
 * File Name: sp_tl_qc_SievesGetByID.sql
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
DROP PROCEDURE IF EXISTS sp_tl_qc_SievesGetByID//
CREATE DEFINER=`root`@`localhost` PROCEDURE sp_tl_qc_SievesGetByID
(
    IN  p_sieveStackId varchar(64)
)
BEGIN
SELECT * FROM tl_qc_sieves
WHERE sieve_stack_id = p_sieveStackId; 
END//
DELIMITER ;

