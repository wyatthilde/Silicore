
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_ClassificationGet.sql
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 01/23/2018|whildebrandt|KACE:20499 - Added procedure to get classification from gb_plc_analog_tags
 *
 ******************************************************************************************************************************************/
DROP PROCEDURE IF EXISTS `sp_gb_plc_ClassificationsGet`;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_ClassificationsGet`()
BEGIN
		SELECT DISTINCT classification 
        FROM gb_plc_analog_tags 
        WHERE classification IS NOT NULL; 
END$$
DELIMITER ;



