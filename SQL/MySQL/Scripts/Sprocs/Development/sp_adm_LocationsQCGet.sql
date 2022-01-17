/*******************************************************************************************************************************************
 * File Name: sp_adm_LocationsQCGet.sql
 * Project: silicore_site
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 09/15/2017|nolliff|KACE:xxxxx - Initial creation
 * 
 ******************************************************************************************************************************************/
DELIMITER $$
DROP IF EXISTS `sp_adm_LocationsQCGet`;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adm_LocationsQCGet`()
BEGIN
	SELECT description FROM main_sites
		WHERE is_active = 1 AND is_qc_samples_site = 1 AND is_vista_site = 1;
END$$
DELIMITER ;