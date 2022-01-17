/*******************************************************************************************************************************************
 * File Name: sp_UserTypesSelectAll.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 09/05/2017|mnutsch|KACE:18406 - Initial creation
 * 09/07/2017|mnutsch|KACE:19756 - Added DEFINER command.
 * 
 ******************************************************************************************************************************************/

DELIMITER $$
DROP PROCEDURE IF EXISTS sp_UserTypesSelectAll$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_UserTypesSelectAll`()
BEGIN
    SELECT * from main_user_types WHERE is_active = '1' ORDER BY value ASC;
END$$
DELIMITER ;


