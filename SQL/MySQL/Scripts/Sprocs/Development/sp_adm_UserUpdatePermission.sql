
/*******************************************************************************************************************************************
 * File Name: sp_adm_UserUpdatePermission
 * Project: smashbox
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 09/13/2017|nolliff|KACE: - Initial creation
 * 09/15/2017|nolliff|KACE: - added site as a parameter
 *
 ******************************************************************************************************************************************/
DROP procedure IF EXISTS `sp_adm_UserUpdatePermission`;
DELIMITER $$
CREATE DEFINER=`root @ localhost` PROCEDURE `sp_adm_UserUpdatePermission`(
    IN 	p_id INT(11),
    IN 	p_user_id INT(11),
    IN 	p_permission VARCHAR(32),
    IN	p_permission_level INT(11),
    IN 	p_site VARCHAR(32)
)
BEGIN

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
		p_site,
		now(),
		NULL,
		p_user_id,
		NULL,
		'vista'
	)
	ON DUPLICATE KEY UPDATE permission_level = p_permission_level, modified_by=p_user_id, modified_datetime=now();
END$$
DELIMITER ;
