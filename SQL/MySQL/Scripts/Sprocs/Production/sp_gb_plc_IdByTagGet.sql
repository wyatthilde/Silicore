
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_IdByTagGet.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/27/2017|whildebrandt|KACE:19563 - Created stored procedure to get Id from prod_auto_plant_analog_tags by specified tag
 *
 ******************************************************************************************************************************************/
DROP PROCEDURE IF EXISTS `sp_gb_plc_IdByTagGet`;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_IdByTagGet`(IN p_tag varchar(32))
SELECT id 
FROM prod_auto_plant_analog_tags 
WHERE tag = p_tag 
LIMIT 1$$
DELIMITER ;

