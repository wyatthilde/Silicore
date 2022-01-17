
/*******************************************************************************************************************************************
 * File Name: sp_adm_DepartmentsGetAll
 * Project: smashbox
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 09/13/2017|nolliff|KACE:18575 - Initial creation
 * 
 ******************************************************************************************************************************************/
DROP procedure IF EXISTS `sp_adm_DepartmentsGetAll`;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adm_DepartmentsGetAll`()
BEGIN
	SELECT id, name FROM main_departments
		WHERE is_active = 1;
END$$
DELIMITER ;
