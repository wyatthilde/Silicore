/*******************************************************************************************************************************************
 * File Name: sp_hr_EmpUpdate.sql
 * Project: silicore
 * Description: SQL used to update employee for HR Checklist.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 08/18/2017|ktaylor|KACE:16070 - Initial creation
 * 09/05/2017|ktaylor|KACE:16070 - Drop procedure if exist added
 * 09/05/2017|ktaylor|KACE:18281 - Added email model field.
 * 10/09/2017|whildebrandt|KACE:18984 - Added cell phone, laptop, desktop, tablet and radio fields.
 * 04/23/2018|whildebrandt|KACE:22395 - Added the following fields: uniform_requested, uniform_notes, business_card_requested, credit_card_requested, fuel_card_requested.
 ******************************************************************************************************************************************/

DROP PROCEDURE IF EXISTS `sp_hr_EmpUpdate`;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_hr_EmpUpdate`(
  IN  p_id INT(11),
  IN  p_last_name varchar(45),
  IN  p_first_name varchar(45),
  IN  p_employee_id varchar(45),
  IN  p_department_id int(11),
  IN  p_job_title_id int(11),
  IN  p_manager_user_id int(11),
  IN  p_site_id int(11),
  IN  p_start_date DATE,
  IN  p_separation_date DATE,
  IN  p_silicore_account_requested tinyint(1),
 #IN  p_silicore_account_model varchar(45),
  IN  p_email_account_requested tinyint(1),
  IN  p_email_account_model_id int(11),
  IN  p_cell_phone_requested tinyint(1),
  IN  p_laptop_requested tinyint(1),
  IN  p_desktop_requested tinyint(1),
  IN  p_monitors_requested varchar(45),
  IN  p_tablet_requested tinyint(1),
  IN  p_two_way_radio_requested tinyint(1),
  IN  p_special_software_requested varchar(45),
  IN  p_uniform_requested tinyint(1),
  IN  p_uniform_notes varchar(256),
  IN  p_business_card_requested tinyint(1),
  IN  p_credit_card_requested tinyint(1),
  IN  p_fuel_card_requested tinyint(1),
  IN  p_comments varchar(1024),
  IN  p_is_approved tinyint(1),
  IN  p_approved_user_id int(11),
  IN  p_edit_user_id int(11),
  IN  p_is_active tinyint(1),
  IN  p_cell_phone_note varchar(256),
  IN  p_laptop_note varchar(256),
  IN  p_desktop_note varchar(256),
  IN  p_tablet_note varchar(256),
  IN  p_two_way_radio_note varchar(256)
)
BEGIN
UPDATE main_hr_checklist
	SET last_name = p_last_name,
    first_name = p_first_name,
    employee_id = p_employee_id,
    department_id = p_department_id,
    job_title_id = p_job_title_id,
    manager_user_id = p_manager_user_id,
    site_id = p_site_id,
    start_date = p_start_date,
    separation_date = p_separation_date,
    silicore_account_requested = p_silicore_account_requested,
   #silicore_account_model = p_silicore_account_model,
    email_account_requested = p_email_account_requested,
    email_account_model_id = p_email_account_model_id,
    cell_phone_requested = p_cell_phone_requested,
    laptop_requested = p_laptop_requested,
    desktop_requested = p_desktop_requested,
    monitors_requested = p_monitors_requested,
    tablet_requested = p_tablet_requested,
    two_way_radio_requested = p_two_way_radio_requested,
    special_software_requested = p_special_software_requested,
	uniform_requested = p_uniform_requested,
    uniform_notes = p_uniform_notes,
    business_card_requested = p_business_card_requested,
    credit_card_requested = p_credit_card_requested,
    fuel_card_requested = p_fuel_card_requested,
    comments = p_comments,
    is_approved = p_is_approved,
    approved_date = now(),
    approved_user_id = p_approved_user_id,
    edit_date = now(),
    edit_user_id = p_edit_user_id,
    is_active = p_is_active,
    cell_phone_notes = p_cell_phone_note,
    laptop_notes = p_laptop_note,
    desktop_notes = p_desktop_note,
    tablet_notes = p_tablet_note,
    two_way_radio_notes = p_two_way_radio_note        
WHERE id = p_id; 
END$$
DELIMITER ;
