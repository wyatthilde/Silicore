/*******************************************************************************************************************************************
 * File Name: sp_tl_qc_SitesGet.sql
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
DROP PROCEDURE IF EXISTS sp_tl_qc_SitesGet$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_SitesGet`()
BEGIN
    SELECT * from main_sites WHERE is_qc_samples_site = "1";
END$$
DELIMITER ;

