/*******************************************************************************************************************************************
 * File Name: sp_adm_UserUpdate.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 09/01/2017|nolliff|KACE:18394 - Initial creation
 * 03/19/2018|whildebrandt|KACE:20499 - Adjusted sproc to work with role checks. Fixed error with insert and delete not working properly.
 ******************************************************************************************************************************************/
DROP PROCEDURE IF EXISTS sp_adm_UserUpdate;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adm_UserUpdate`(
    IN  p_id int(11),
    IN  p_first_name VARCHAR(32),
    IN  p_last_name VARCHAR(32),
    IN  p_display_name VARCHAR(64),
    IN  p_email VARCHAR(128),
    IN  p_company VARCHAR(32),
    IN  p_main_department_id INT(11),
    IN  p_start_date DATE,
    IN 	p_separation_date DATE,
    IN  p_is_active TINYINT(1),
    IN 	p_qc_labtech TINYINT(1),
    IN 	p_qc_sampler TINYINT(1),
    IN 	p_qc_operator TINYINT(1),
    IN 	p_user_type_id TINYINT(1),
    IN 	p_manager_id TINYINT(1),
    IN 	p_user_id INT(11),
    IN 	p_permission VARCHAR(32),
    IN  p_permission_level INT(11)
)
BEGIN
	UPDATE main_users
		SET 
			first_name = p_first_name, 
			last_name = p_last_name, 
			display_name = p_display_name, 
			email = p_email, 
			company = p_company, 
			main_department_id = p_main_department_id, 
			start_date = p_start_date,
			separation_date = p_separation_date,
			is_active = p_is_active,
			user_type_id = p_user_type_id,
			manager_id = p_manager_id
		WHERE id = p_id;
 
	IF p_qc_operator = 1 THEN CALL sp_adm_RoleCheckInsert(p_id, 10, 1); 
    ELSEIF p_qc_operator = 0 THEN CALL sp_adm_RoleDelete(p_id, 1);
      END IF;
	IF p_qc_sampler = 1 THEN CALL sp_adm_RoleCheckInsert(p_id, 10, 2);
    ELSEIF p_qc_sampler = 0 THEN CALL sp_adm_RoleDelete(p_id, 2);
    		END IF;
	IF p_qc_labtech = 1 THEN CALL sp_adm_RoleCheckInsert(p_id, 10, 3);
    ELSEIF p_qc_labtech = 0 THEN CALL sp_adm_RoleDelete(p_id, 3);
      END IF;
 
	INSERT INTO main_user_permissions (
		user_id,
		permission,
		permission_level,
		site,
		created_datetime,
		modified_datetime,
		created_by,
		modified_by,
		company
		)
	VALUES(
		p_id,
		'general',
		p_permission_level,
		'granbury',
		now(),
		NULL,
		p_user_id,
		NULL,
		'vista')
	ON DUPLICATE KEY UPDATE permission_level = p_permission_level, modified_by = p_user_id, modified_datetime=now();
    
	 INSERT INTO main_user_permissions 
	 (
		user_id,
		permission,
		permission_level,
		site,
		created_datetime,
		modified_datetime,
		created_by,
		modified_by,
		company
	)
	VALUES
	(
		p_id,
		p_permission,
		p_permission_level,
		'granbury',
		now(),
		NULL,
		p_user_id,
		NULL,
		'vista'
	)
	ON DUPLICATE KEY UPDATE permission_level = p_permission_level, modified_by = p_user_id, modified_datetime = now();
END$$
DELIMITER ;

