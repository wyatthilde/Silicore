
/*******************************************************************************************************************************************
 * File Name: sp_adm_UserTypesGet-


 * Project: smashbox
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 09/13/17|nolliff|KACE: - Initial creation
 * 
 ******************************************************************************************************************************************/
DROP procedure IF EXISTS `sp_adm_UserTypesGet`;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adm_UserTypesGet`(

)
BEGIN
	SELECT id, name, value, is_active FROM main_user_types;
END$$
DELIMITER ;
