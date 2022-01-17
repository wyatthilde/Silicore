
/*******************************************************************************************************************************************
 * File Name: sp_adm_RoleDelete.sql
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 03/19/2018|whildebrandt|KACE:20499 - Fixed role delete to exclude site_id as a parameter. This was causing issues.
 *
 ******************************************************************************************************************************************/
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adm_RoleDelete`(
	IN p_id int(11), IN p_role_id int(11)
)
DELETE FROM main_users_roles_check WHERE p_id = user_id  AND p_role_id = role_id$$
DELIMITER ;




