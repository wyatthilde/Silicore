
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_InventorySiloXferInfoByDateGet.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 12/13/2017|whildebrandt|KACE:16787 - Created sproc that returns info from Inventory silos 
 *
 ******************************************************************************************************************************************/
DROP PROCEDURE `sp_gb_plc_InventorySiloXferInfoByDateGet`;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_InventorySiloXferInfoByDateGet`(IN p_date datetime)
(
SELECT 
        t.dt, so.site_id, t.silo_id, so.capacity_pounds, so.cone_pounds, max(t.product_id) product_id, max(t.volume) volume 
    FROM
        (
        SELECT 
            dt, 
            CASE WHEN at.tag = "SILO1_PROD_temp" THEN 1 
            WHEN at.tag = "SILO2_PROD_temp" THEN 2 
            WHEN at.tag = "SILO6_PROD_temp" THEN 6 
            WHEN at.tag = "SILO7_PROD_temp" THEN 7 END silo_id, 
            value product_id, 
            NULL volume
        FROM 
            gb_plc_analog_data ad JOIN gb_plc_analog_tags at ON ad.tag_id = at.id  
        WHERE 
            tag IN ("SILO1_PROD_temp", "SILO2_PROD_temp", "SILO6_PROD_temp", "SILO7_PROD_temp") AND
            dt > p_date
        UNION
        SELECT 
            dt, 
            CASE WHEN at.tag = "SILO1_LVL_temp" THEN 1 
				 WHEN at.tag = "SILO2_LVL_temp" THEN 2 
				 WHEN at.tag = "SILO6_LVL_temp" THEN 6 
                 WHEN at.tag = "SILO7_LVL_temp" THEN 7 END silo_id, 
			NULL product_id, 
			ad.value volume
        FROM 
            gb_plc_analog_data ad JOIN gb_plc_analog_tags at ON ad.tag_id = at.id  
        WHERE 
            tag IN ("SILO1_LVL_temp", "SILO2_LVL_temp", "SILO6_LVL_temp", "SILO7_LVL_temp") AND
            dt > p_date
        ) t JOIN gb_plc_silos so ON t.silo_id = so.id 
    GROUP BY 
        t.dt, t.silo_id, so.capacity_pounds 
    HAVING 
        MAX(t.product_id) IS NOT NULL AND
        MAX(t.volume) IS NOT NULL
    ORDER BY t.dt, t.silo_id
)$$
DELIMITER ;



