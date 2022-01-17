/* * *****************************************************************************************************************************************
 * File Name: sp_GetSites.sql
 * Project: Silicore
 * Description: Returns a list of QC Sites
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 06/05/2017|mnutsch|KACE:? - Initial creation
 * 08/31/2017|mnutsch|KACE:17957 - Added a new parameter to the SQL query.
* 
 * **************************************************************************************************************************************** */

DELIMITER $$

DROP PROCEDURE IF EXISTS sp_GetSites$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetSites`()
BEGIN
    SELECT * from main_sites WHERE is_qc_samples_site = "1";
END$$

DELIMITER ;
