
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_ProdAutoProductionInsert.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/15/2017|whildebrandt|KACE:16787 - Initial creation
 *
 ******************************************************************************************************************************************/
DROP PROCEDURE IF EXISTS `sp_gb_plc_ProdAutoProductionInsert`;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_ProdAutoProductionInsert`(
	IN p_id int(5),
	IN p_shift_id bigint(20), 
    IN p_tons int(5), 
    IN p_tag_id bigint(20), 
    IN p_tag varchar(32), 
    IN p_product_id int(3), 
    IN p_product varchar(64)
)
INSERT INTO prod_auto_plant_production
(	
	id,
	shift_id, 
    tons, 
    tag_id, 
    tag, 
    product_id, 
    product
) 
VALUES
(
	p_id,
	p_shift_id, 
    p_tons, 
    p_tag_id, 
    p_tag, 
    p_product_id, 
    p_product
)$$
DELIMITER ;




