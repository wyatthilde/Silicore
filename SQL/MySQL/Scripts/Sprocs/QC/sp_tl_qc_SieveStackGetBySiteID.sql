/*******************************************************************************************************************************************
 * File Name: sp_tl_qc_SieveStackGetBySiteID.sql
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

DROP PROCEDURE IF EXISTS sp_ql_qc_SieveStackGetByID//

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_ql_qc_SieveStackGetByID
(
    IN  p_sieveStackId varchar(64)
)
BEGIN
SELECT * FROM tl_qc_sieve_stacks
    WHERE id = p_sieveStackId
    ORDER BY sort_order ASC
LIMIT 1; 
END//

DELIMITER ;

