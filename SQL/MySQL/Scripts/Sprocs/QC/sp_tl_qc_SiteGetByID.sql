/* * *****************************************************************************************************************************************
 * File Name: sp_tl_qc_SiteGetByID.sql
 * Project: Silicore
 * Description: 
 * Notes: 
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 10/10/2017|mnutsch|KACE:17957 - Initial creation
 * 
 * **************************************************************************************************************************************** */

DROP PROCEDURE IF EXISTS sp_tl_qc_SiteGetByID;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_SiteGetByID`
(
    IN  p_site_id INT(11)
)
BEGIN
    SELECT * FROM main_sites 
    WHERE id = p_site_id
    LIMIT 1;
END$$

DELIMITER ;

