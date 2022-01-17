/*******************************************************************************************************************************************
 * File Name: sp_hr_DeptManagersGetAll.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 09/25/2017|kkuehn|KACE:18776 - Initial creation
 * 
 ******************************************************************************************************************************************/

# HR Checklist: Get all department managers
DROP PROCEDURE IF EXISTS `sp_hr_DeptManagersGetAll`;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_hr_DeptManagersGetAll`()
BEGIN
  SELECT 
    id, 
    main_department_id,
    CONCAT(first_name, ' ',last_name) as mgrname
  FROM main_users
  WHERE is_active = 1
  AND user_type_id in(3,4,5)
  AND main_department_id != 2
  UNION
  SELECT 
    id, 
    main_department_id,
    CONCAT(first_name, ' ',last_name) as mgrname
  FROM main_users
  WHERE id in(2,11);
END$$
DELIMITER ;

call sp_hr_DeptManagersGetAll();