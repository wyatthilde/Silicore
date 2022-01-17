
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_ConveyorAvgTotalGet.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 12/22/2017|whildebrandt|KACE:19901 - Created sproc that gets the average and total sums from gb_plc_production
 * 12/27/2017|whildebrandt|KACE:19901 - Edited sp_gb_plc_ConveyorAvgTotalGet to include date difference of max and min date.
 * 12/28/2017|whildebrandt|KACE:19901 - Edited sp_gb_plc_ConveyorAvgTotalGet to include a 'where' for operator to support search function.
 ******************************************************************************************************************************************/
DROP PROCEDURE IF EXISTS sp_gb_plc_ConveyorAvgTotalGet;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_ConveyorAvgTotalGet`(IN p_tag varchar(64), IN p_start datetime, IN p_end datetime, IN p_operator varchar(32))
(
SELECT 
	DATEDIFF(MAX(s.date), MIN(s.date)) AS 'Days', 
	p.tag, 
    AVG(p.tons) AS 'AverageTons',
	SUM(p.tons) AS 'TotalTons' 
FROM 
	gb_plc_production p 
JOIN gb_plc_shifts s ON s.Xfer_id = p.shift_id
WHERE p.tag = p_tag
AND s.operator LIKE p_operator
AND s.date BETWEEN p_start AND p_end)$$
DELIMITER ;
