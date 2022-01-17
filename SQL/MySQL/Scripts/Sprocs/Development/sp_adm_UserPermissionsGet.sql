/*******************************************************************************************************************************************
 * File Name: 
 * Project: smashbox
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 09/13/17|nolliff|KACE: - Initial creation
 * 
 ******************************************************************************************************************************************/

DELIMITER $$
DROP procedure IF EXISTS `sp_adm_UserPermissionsGet`;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adm_UserPermissionsGet`(
	IN p_id INT(11)
)
BEGIN
	SELECT user_id, permission, site, permission_level FROM main_user_permissions
    WHERE user_id = p_id;
END$$
DELIMITER ;