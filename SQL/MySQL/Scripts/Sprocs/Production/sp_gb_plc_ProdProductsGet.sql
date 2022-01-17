
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_ProdProductsGet.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/22/2017|whildebrandt|KACE:16787 - Initial creation
 *
 ******************************************************************************************************************************************/
DROP PROCEDURE IF EXISTS `sp_gb_plc_ProdProductsGet`;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_ProdProductsGet`(IN p_tag varchar(32))
SELECT id 
FROM prod_products 
WHERE tag = p_tag
limit 1$$
DELIMITER ;
