/*******************************************************************************************************************************************
 * File Name: sp_hr_EmpDeptSiteSelectById.sql
 * Project: silicore
 * Description: SQL used in editing an individual employee for HR Checklist.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 08/18/2017|ktaylor|KACE:16070 - Initial creation.
 * 09/05/2017|ktaylor|KACE:16070 - Drop procedure if exist added.
 * 09/05/2017|ktaylor|KACE:18281 - Added email model field.
 * 
 ******************************************************************************************************************************************/


USE `silicore_site`;
DROP PROCEDURE IF EXISTS `sp_hr_EmpDeptSiteSelectById`;

DELIMITER $$
USE `silicore_site`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_hr_EmpDeptSiteSelectById`
(
     IN p_id INT(11)   
)
BEGIN
        SELECT main_hr_checklist.id,
			         main_hr_checklist.last_name,
               main_hr_checklist.first_name,
               main_hr_checklist.employee_id,
               main_hr_checklist.department_id,
               main_hr_checklist.site_id,
               main_hr_checklist.manager,
               main_hr_checklist.silicore_account_requested,
               main_hr_checklist.silicore_account_model,
               main_hr_checklist.email_account_requested,
               main_hr_checklist.email_account_model,
               main_hr_checklist.cell_phone_requested,
               main_hr_checklist.laptop_requested,
               main_hr_checklist.desktop_requested,
               main_hr_checklist.monitors_requested,
               main_hr_checklist.tablet_requested,
               main_hr_checklist.two_way_radio_requested,
               main_hr_checklist.special_software_requested,
               main_hr_checklist.comments,
               main_hr_checklist.create_date,
               main_hr_checklist.create_user_id,
               main_hr_checklist.edit_date,
               main_hr_checklist.edit_user_id,
               main_hr_checklist.is_active,
               main_departments.name,
               main_sites.description
    FROM main_hr_checklist
    LEFT JOIN main_departments 
    ON main_hr_checklist.department_id = main_departments.id
    LEFT JOIN main_sites 
    ON main_hr_checklist.site_id = main_sites.id
	WHERE main_hr_checklist.id=p_id;
    
END$$
DELIMITER ;