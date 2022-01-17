
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_PlantsGet.sql
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 01/23/2018|whildebrandt|KACE:20499 - Added procedure to get id and name from main_plants
 *
 ******************************************************************************************************************************************/
DROP PROCEDURE IF EXISTS `sp_gb_plc_PlantsGet`;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_PlantsGet`()
BEGIN
	SELECT id, name FROM silicore_site.main_plants;
END$$
DELIMITER ;



