
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_60IntervalMaxIdGet.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 12/11/2017|whildebrandt|KACE:16787 - Created sproc to get max id where the interval is 60
 *
 ******************************************************************************************************************************************/
DROP PROCEDURE IF EXISTS sp_gb_plc_60IntervalMaxIdGet;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_60IntervalMaxIdGet`()
(
SELECT 
	MAX(Xfer_id) AS MaxId
FROM
	gb_plc_analog_data
WHERE 
	interval_seconds = 60
)$$
DELIMITER ;



