
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_SamplesByLocationGet.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 12/22/2017|whildebrandt|KACE:16787 - Created sproc to get average from qc sample values based on location
 *
 ******************************************************************************************************************************************/
DROP PROCEDURE IF EXISTS `sp_gb_plc_SamplesByLocationGet`;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_SamplesByLocationGet`(IN p_start date, IN p_end date, IN p_location_id int)
(
SELECT 
	AVG(s.moisture_rate), 
    AVG(s.plus_70),
	AVG(s.minus_40_plus_70),
	AVG(s.minus_70), 
	AVG(s.minus_70_plus_140), 
	AVG(s.plus_140), 
	AVG(s.minus_140)
FROM 
	gb_qc_samples s
WHERE 
	date BETWEEN p_start AND p_end
    AND
    location_id = p_location_id
)$$
DELIMITER ;



