
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_10MinutesRecordsGet.sql
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 02/12/2018|whildebrandt|KACE:20499 - Created stored procedure that gets records from gb_plc_TS_10minute within time frame. 
 *
 ******************************************************************************************************************************************/
DROP PROCEDURE IF EXISTS `sp_gb_plc_10MinuteRecordsGet`
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_10MinuteRecordsGet`(IN p_tag_id int(11), IN p_start date, IN p_end date)
(
SELECT avg(value) as 'AvgValue' from gb_plc_TS_10minute 
where tag_id = p_tag_id
AND timestamp between p_start AND p_end
AND 
CASE WHEN (cast(timestamp as Time) between '05:50:00' and '05:59:59' 
OR cast(timestamp as Time) between '17:50:00' and '17:59:59') = 0 THEN (cast(timestamp as Time) between '05:40:00' and '05:49:59'
OR cast(timestamp as Time) between '17:40:00' and '17:49:59') END
)$$
DELIMITER ;




