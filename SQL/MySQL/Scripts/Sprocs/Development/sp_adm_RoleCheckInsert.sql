
/*******************************************************************************************************************************************
 * File Name: sp_adm_RoleCheckInsert.sql
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 02/09/2018|whildebrandt|KACE:20499 - Inserts role check.
 *
 ******************************************************************************************************************************************/
DROP PROCEDURE IF EXISTS `sp_adm_RoleCheckInsert`;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adm_RoleCheckInsert`(
	IN p_user_id int(11),
    IN p_site_id int(11),
    IN p_role_id int(11)
)
BEGIN
	INSERT INTO main_users_roles_check
	(
		user_id,
		site_id,
		role_id
	)
	VALUES
	(
        p_user_id,
        p_site_id,
        p_role_id
	)
	on duplicate key update site_id = p_site_id, role_id = p_role_id;
END$$
DELIMITER ;



