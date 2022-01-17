/*******************************************************************************************************************************************
 * File Name: sp_hr_EmpGetAll.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 09/25/2017|kkuehn|KACE:18777 - Initial creation
 * 
 ******************************************************************************************************************************************/

# HR Checklist: Get all employees by department, levels 1-3, 1-5 in dev
DROP PROCEDURE IF EXISTS `sp_hr_EmpGetAll`;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_hr_EmpGetAll`
()
BEGIN
  SELECT 
    id, 
    main_department_id,
    CONCAT(first_name, ' ',last_name) as empname
  FROM main_users
  WHERE is_active = 1
  AND user_type_id in(1,2,3)
  AND main_department_id != 2
  UNION
  SELECT 
    id,  
    main_department_id,
    CONCAT(first_name, ' ',last_name) as empname
  FROM main_users
  WHERE user_type_id in(1,2,3,4,5)
  ORDER BY main_department_id;
END$$
DELIMITER ;

call sp_hr_EmpGetAll();