 /* * *****************************************************************************************************************************************
 * File Name: sp_qc_SieveStacksGetBySiteID.sql
 * Project: Silicore
 * Description: Gets all data from gb_qc_sieve_stacks for a given Site ID.
 * Notes: This gets called by sampleedit.php and sampleview.php
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 08/01/2017|mnutsch|KACE:17717 - Initial creation
 * 08-08-2017|mnutsch|KACE:17803 - added order by
 * 
 * **************************************************************************************************************************************** */

DELIMITER $$

DROP PROCEDURE IF EXISTS sp_qc_SieveStacksGetBySiteID$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_qc_SieveStacksGetBySiteID`
(
    IN  p_sieveStackSiteID int(11)
)
BEGIN
    SELECT * FROM gb_qc_sieve_stacks
    WHERE main_site_id = p_sieveStackSiteID
    AND is_active = 1
    ORDER BY sort_order ASC; 
END$$

DELIMITER ;
