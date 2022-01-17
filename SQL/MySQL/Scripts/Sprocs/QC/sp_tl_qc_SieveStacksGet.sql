/*******************************************************************************************************************************************
 * File Name: sp_tl_qc_SieveStacksGet.sql
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
DROP PROCEDURE IF EXISTS sp_tl_qc_SieveStacksGet$$
CREATE PROCEDURE `sp_tl_qc_SieveStacksGet`()
BEGIN
    SELECT * from tl_qc_sieve_stacks WHERE is_active = '1' ORDER BY sort_order;
END$$
DELIMITER ;

