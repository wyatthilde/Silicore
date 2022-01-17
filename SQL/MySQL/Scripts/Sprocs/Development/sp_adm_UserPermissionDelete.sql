/*******************************************************************************************************************************************
 * File Name: sp_adm_UserPermissionDelete.sql
 * Project: smashbox
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 09/13/2017|nolliff|KACE: - Initial creation
 * 09/15/2017|nolliff|KACE: - added site as a parameter
 ******************************************************************************************************************************************/
DROP procedure IF EXISTS `sp_adm_UserPermissionDelete`;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adm_UserPermissionDelete`(
    IN 	p_id INT(11),
    IN 	p_department VARCHAR(32),
    in 	p_site VARCHAR(32)
)
BEGIN
	DELETE FROM main_user_permissions
		WHERE user_id = p_id AND permission = p_department AND site = p_site
	LIMIT 1;
END$$
DELIMITER ;
