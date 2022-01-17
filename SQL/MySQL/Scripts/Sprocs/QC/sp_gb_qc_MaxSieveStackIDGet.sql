/*******************************************************************************************************************************************
 * File Name: sp_gb_qc_MaxSieveStackIDGet.sql
 * Project: smashbox
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 01/24/2018|mnutsch|KACE:18518 - Initial creation
 * 
 ******************************************************************************************************************************************/

DROP PROCEDURE IF EXISTS sp_gb_qc_MaxSieveStackIDGet;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_MaxSieveStackIDGet`
(
    # no input parameters
)
BEGIN
    SELECT MAX(id)
    FROM gb_qc_sieve_stacks
    LIMIT 1;
END$$

DELIMITER ;


