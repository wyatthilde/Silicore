
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_ProductionMaxIdGet.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/22/2017|whildebrandt|KACE:16787 - Initial creation
 *
 ******************************************************************************************************************************************/
DROP PROCEDURE IF EXISTS `sp_gb_plc_ProductionMaxIdGet`;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_ProductionMaxIdGet`()
SELECT id 
FROM prod_auto_plant_production
WHERE id in (SELECT MAX(id) FROM prod_auto_plant_production)$$
DELIMITER ;



