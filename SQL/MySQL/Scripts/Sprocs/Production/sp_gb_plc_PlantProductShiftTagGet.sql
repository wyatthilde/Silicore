
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_PlantProductShiftTagGet.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/22/2017|whildebrandt|KACE:16787 - Initial creation
 *
 ******************************************************************************************************************************************/
DROP PROCEDURE IF EXISTS `sp_gb_plc_PlantProductShiftTagGet`;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_PlantProductShiftTagGet`(
	IN p_shift_id bigint(20), 
	IN p_tag_id bigint(20), 
	IN p_product_id int(3)
)
SELECT id 
FROM prod_auto_plant_production 
WHERE shift_id = p_shift_id
AND tag_id = p_tag_id
AND product_id = p_product_id
LIMIT 1$$
DELIMITER ;
