/*******************************************************************************************************************************************
 * File Name: sp_tl_qc_SieveStacksGetBySiteID.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 09/15/2017|mnutsch|KACE:17957 - Initial creation
 * 
 ******************************************************************************************************************************************/

DELIMITER $$

DROP PROCEDURE IF EXISTS sp_tl_qc_SieveStacksGetBySiteID$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_SieveStacksGetBySiteID`
(
    IN  p_sieveStackSiteID int(11)
)
BEGIN
    SELECT * FROM tl_qc_sieve_stacks
    WHERE main_site_id = p_sieveStackSiteID
    AND is_active = 1
    ORDER BY sort_order ASC; 
END$$

DELIMITER ;



