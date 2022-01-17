/*******************************************************************************************************************************************
 * File Name: sp_hr_DeptSelect.sql
 * Project: silicore
 * Description: SQL used for the creation of a dropdown menu to select departments for HR Checklist.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 08/18/2017|ktaylor|KACE:16070 - Initial creation
 * 09/05/2017|ktaylor|KACE:16070 - Drop procedure if exist added
 * 09/05/2017|ktaylor|KACE:18282 - Dropped 'General' department
 ******************************************************************************************************************************************/


USE `silicore_site`;
DROP PROCEDURE IF EXISTS `sp_hr_DeptSelect`;

DELIMITER $$
USE `silicore_site`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_hr_DeptSelect`()
BEGIN
    SELECT id, name, is_active from main_departments
    WHERE is_active='1'
    AND id !='1';
END$$
DELIMITER ;