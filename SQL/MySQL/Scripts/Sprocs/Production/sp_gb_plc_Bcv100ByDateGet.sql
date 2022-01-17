
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_Bcv100ByDateGet.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 12/22/2017|whildebrandt|KACE:16787 - Created sproc that returns Fine, Coarse and Date for the BCV100 tag.
 *
 ******************************************************************************************************************************************/
DROP PROCEDURE IF EXISTS sp_gb_plc_Bcv100ByDateGet;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_Bcv100ByDateGet`(IN p_start datetime, IN p_end datetime)
(
SELECT
	r1.tons AS 'Fine',
	r2.tons AS 'Coarse',
    s.date AS 'Date'
FROM 
	gb_plc_production p
JOIN 
	gb_plc_shifts s ON s.Xfer_id = p.shift_id
JOIN 
	(SELECT shift_id, tons FROM gb_plc_production WHERE tag_id = 166) r1 ON r1.shift_id = p.shift_id
JOIN 
	(SELECT shift_id, tons FROM gb_plc_production WHERE tag_id = 167) r2 ON r2.shift_id = p.shift_id
WHERE 
	s.date BETWEEN p_start AND p_end
)$$
DELIMITER ;



