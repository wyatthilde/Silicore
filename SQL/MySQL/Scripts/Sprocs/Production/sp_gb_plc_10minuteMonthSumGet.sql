
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_10minuteMonthSumGet.sql
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 03/12/2018|whildebrandt|KACE:20499 - Sproc returns the sum of the value between a month start and end on a specific tag.
 *
 ******************************************************************************************************************************************/
DROP PROCEDURE IF EXISTS sp_gb_plc_10minuteMonthSumGet;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_10minuteMonthSumGet`(IN p_tag_id int(11), IN p_date datetime)
SELECT sum(value) FROM gb_plc_TS_10minute
WHERE tag_id = p_tag_id AND timestamp BETWEEN p_date AND LAST_DAY(p_date)$$
DELIMITER ;




