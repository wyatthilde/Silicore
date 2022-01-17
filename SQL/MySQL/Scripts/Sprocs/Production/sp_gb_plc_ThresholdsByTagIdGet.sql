
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_ThresholdsByTagIdGet.sql
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 02/05/2018|whildebrandt|KACE:20499 - Created stored procedure to retrieve thresholds by the tag_id
 *
 ******************************************************************************************************************************************/
DROP PROCEDURE IF EXISTS `sp_gb_plc_ThresholdsByTagIdGet`;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_ThresholdsByTagIdGet`
(
	IN p_tag_id int(11)
)
(
SELECT 
	threshold 
FROM 
	gb_plc_plant_thresholds
WHERE tag_id = p_tag_id
)$$
DELIMITER ;




