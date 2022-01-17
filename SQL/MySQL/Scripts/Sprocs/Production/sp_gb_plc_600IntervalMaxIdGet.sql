
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_600IntervalMaxIdGet.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 12/11/2017|whildebrandt|KACE:16787 - Created sproc to get max id from analog data where interval seconds are 600
 *
 ******************************************************************************************************************************************/
DROP PROCEDURE IF EXISTS sp_gb_plc_600IntervalMaxIdGet;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_600IntervalMaxIdGet`()
(
SELECT 
	MAX(Xfer_id) AS MaxId
FROM
	gb_plc_analog_data
WHERE 
	interval_seconds = 600
)$$
DELIMITER ;



