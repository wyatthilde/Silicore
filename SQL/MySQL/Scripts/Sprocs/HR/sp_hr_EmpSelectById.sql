/*******************************************************************************************************************************************
 * File Name: sp_hr_EmpSelectById.sql
 * Project: silicore
 * Description: SQL used to select all info of employee for HR Checklist.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 08/18/2017|ktaylor|KACE:16070 - Initial creation
 * 09/05/2017|ktaylor|KACE:16070 - Drop procedure if exist added
 * 09/05/2017|ktaylor|KACE:16281 - Added email model field.
 * 10/09/2017|whildebrandt|KACE:18984 - Added cell phone, laptop, desktop, tablet and radio fields. Changed drop procedure to sp_hr_EmpSelectById.
 ******************************************************************************************************************************************/

USE `silicore_site`;
DROP PROCEDURE IF EXISTS `sp_hr_EmpSelectById`;

DELIMITER $$
USE `silicore_site`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_hr_EmpSelectById`(   
	IN p_id INT(11)
)
BEGIN
    SELECT main_hr_checklist.id,
           main_hr_checklist.last_name,
           main_hr_checklist.first_name,
           main_hr_checklist.employee_id,
           main_hr_checklist.department_id,
           main_hr_checklist.manager,
           main_hr_checklist.site_id,
           main_hr_checklist.start_date,
           main_hr_checklist.separation_date,
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
           main_hr_checklist.cell_phone_notes,
           main_hr_checklist.laptop_notes,
           main_hr_checklist.desktop_notes,
           main_hr_checklist.tablet_notes,
           main_hr_checklist.two_way_radio_notes
        
    FROM   main_hr_checklist 
    WHERE  id = p_id;

END$$
DELIMITER ;
;