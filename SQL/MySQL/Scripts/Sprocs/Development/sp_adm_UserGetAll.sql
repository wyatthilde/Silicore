/*******************************************************************************************************************************************
 * File Name: sp_adm_UserGetAll.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 09/13/2017|nolliff|KACE:18394 - Initial creation
 * 03/16/2018|whildebrandt|KACE:20499 - Adjusted sproc to work with role checks.
 ******************************************************************************************************************************************/
DROP PROCEDURE IF EXISTS `sp_adm_UserGetAll`;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adm_UserGetAll`()
BEGIN
SELECT  mu.id, 
		mu.username,
		mu.first_name,
		mu.last_name,
		mu.display_name,
		mu.email,
		mu.company,
		mu.main_department_id,
		mu.last_logged,
		mu.start_date,
		mu.separation_date,
		mu.is_active,
		mu.require_password_reset,
		mu.password_reset_token,
		mu.password_token_expiration,
		max(case when rc.role_id = 1 then 1 else 0 end) as qc_operator,
		max(case when rc.role_id = 2 then 1 else 0 end) as qc_sampler,
		max(case when rc.role_id = 3 then 1 else 0 end) as qc_labtech,
		mu.user_type_id,   
		mu.manager_id
FROM main_users as mu
JOIN main_users_roles_check as rc on mu.id = rc.user_id	
GROUP BY mu.id, rc.user_id
UNION 
SELECT 
		mu.id, 
		mu.username,
		mu.first_name,
		mu.last_name,
		mu.display_name,
		mu.email,
		mu.company,
		mu.main_department_id,
		mu.last_logged,
		mu.start_date,
		mu.separation_date,
		mu.is_active,
		mu.require_password_reset,
		mu.password_reset_token,
		mu.password_token_expiration,
		0 as qc_operator,
        0 as qc_sampler,
        0 as qc_labtech,
		mu.user_type_id,   
		mu.manager_id
FROM main_users as mu
WHERE role_check = 0
ORDER BY id ASC;
END$$
DELIMITER ;
