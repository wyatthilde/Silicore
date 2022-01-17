/*******************************************************************************************************************************************
 * File Name: sp_hr_EmpSelect.sql
 * Project: silicore
 * Description: SQL used to select short info front table of HR Checklist.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 08/18/2017|ktaylor|KACE:16070 - Initial creation
 * 09/05/2017|ktaylor|KACE:16070 - Drop procedure if exist added
 * 
 ******************************************************************************************************************************************/

USE `silicore_site`;
DROP PROCEDURE IF EXISTS `sp_hr_EmpSelect`;

DELIMITER $$
USE `silicore_site`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_hr_EmpSelect`(
 
)
BEGIN
    SELECT main_hr_checklist.id,
		       main_hr_checklist.last_name,
           main_hr_checklist.first_name,
		       main_hr_checklist.employee_id,
		       main_hr_checklist.department_id,
		       main_hr_checklist.manager,
           main_hr_checklist.site_id,
		       main_hr_checklist.create_date,
           main_hr_checklist.is_active,
           main_departments.name,
           main_sites.description
    FROM main_hr_checklist
    LEFT JOIN main_departments 
    ON main_hr_checklist.department_id = main_departments.id
    LEFT JOIN main_sites 
    ON main_hr_checklist.site_id = main_sites.id
	ORDER BY main_hr_checklist.create_date DESC ;
    
END$$
DELIMITER ;