/*******************************************************************************************************************************************
 * File Name: sp_adm_UserGet.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 09/01/2017|nolliff|KACE:18394 - Initial creation
 * 
 ******************************************************************************************************************************************/

DROP PROCEDURE IF EXISTS `sp_adm_UserGet`;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adm_UserGet`(
	IN  p_id int(11)
)
BEGIN
	SELECT 	username,
            first_name,
            last_name,
            display_name,
            email,
            company,
            main_department_id,
            last_logged,
            start_date,
            separation_date,
            is_active,
            require_password_reset,
            password_reset_token,
            password_token_expiration,
			case when rc.role_id = 1 then 1 
			else 0 end as qc_operator,
			case when rc.role_id = 2 then 1 
			else 0 end as qc_sampler,
			case when rc.role_id = 3 then 1 
			else 0 end as qc_labtech,
            user_type_id,   
            manager_id
	FROM main_users as mu
JOIN main_users_roles_check as rc on mu.id = rc.user_id	
    WHERE mu.id = p_id;
END$$
DELIMITER ;
