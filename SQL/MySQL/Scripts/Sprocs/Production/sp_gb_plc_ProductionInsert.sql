
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_ProductionInsert.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/15/2017|whildebrandt|KACE:19563 - Initial creation
 * 11/27/2017|whildebrandt|KACE:19563 - Updated to insert into production
 * 11/27/2017|whildebrandt|KACE:19563 - Updated p_product to varchar(64) from varchar(32)
 * 11/27/2017|whildebrandt|KACE:19563 - Updated to include Xfer_id
 ******************************************************************************************************************************************/
DROP PROCEDURE IF EXISTS`sp_gb_plc_ProductionInsert`;
DELIMITER $$
CREATE DEFINER=`webdev`@`smashbox` PROCEDURE `sp_gb_plc_ProductionInsert`(
	IN p_Xfer_id int(5),
	IN p_shift_id bigint(20), 
    IN p_tons int(5), 
    IN p_tag_id bigint(20), 
    IN p_tag varchar(32), 
    IN p_product_id int(3), 
    IN p_product varchar(64)
)
INSERT INTO gb_plc_production
(	
    Xfer_id,
    shift_id, 
      tons, 
    tag_id, 
    tag, 
    product_id, 
    product
) 
VALUES
(
    p_Xfer_id,
	  p_shift_id, 
    p_tons, 
    p_tag_id, 
    p_tag, 
    p_product_id, 
    p_product
)$$
DELIMITER ;
