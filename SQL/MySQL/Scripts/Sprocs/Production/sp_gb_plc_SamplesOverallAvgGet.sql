
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_SamplesOverallAvgGet.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 12/22/2017|whildebrandt|KACE:16787 - Created sproc that returns the Average from QC samples based on location that was entered.
 *
 ******************************************************************************************************************************************/
DROP PROCEDURE IF EXISTS sp_gb_plc_SamplesOverallAvgGet;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_SamplesOverallAvgGet`(IN p_location int(11))
(
SELECT 
	AVG(moisture_rate), 
  AVG(plus_70),
	AVG(minus_40_plus_70),
	AVG(minus_70), 
	AVG(minus_70_plus_140), 
	AVG(plus_140), 
	AVG(minus_140)
FROM 
	gb_qc_samples
WHERE 
  location_id = p_location
)$$
DELIMITER ;



